<?php
declare(strict_types=1);

function upload_attachment(string $resourceName, string $id): void {
    $upload = $_FILES['attachment'] ?? null;
    if (!$upload || $upload['error'] === UPLOAD_ERR_NO_FILE) return;
    if ($upload['error'] !== UPLOAD_ERR_OK || $upload['size'] > 5*1024*1024) throw new InvalidArgumentException('Upload a file smaller than 5 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($upload['tmp_name']);
    $types = ['application/pdf'=>'pdf','image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    if (!isset($types[$mime])) throw new InvalidArgumentException('Attachments must be PDF, JPEG, PNG, or WebP files.');
    $directory = ROOT . '/storage/uploads';
    if (!is_dir($directory) && !mkdir($directory,0770,true)) throw new RuntimeException('Unable to create attachment storage.');
    $stored = bin2hex(random_bytes(24)) . '.' . $types[$mime];
    if (!move_uploaded_file($upload['tmp_name'],$directory . '/' . $stored)) throw new RuntimeException('Unable to store attachment.');
    try {
        query('INSERT INTO app_files (resource,record_id,stored_name,original_name,mime) VALUES (?, ?, ?, ?, ?)',[$resourceName,$id,$stored,substr(basename($upload['name']),0,255),$mime]);
    } catch (Throwable $error) { unlink($directory . '/' . $stored); throw $error; }
}
function process_action(): never {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail(405,'Use the form to perform this action.');
    verify_csrf();
    $user = require_user();
    $action = (string)($_POST['action'] ?? '');
    if ($action !== 'logout') rate_limit('write', 120, 300, (string)$user['user_id']);
    if (in_array($action, ['archive','restore'], true)) rate_limit('archive', 20, 300, (string)$user['user_id']);
    if ($action === 'logout') {
        audit('sign_out','accounts',$user['user_id']);
        query('DELETE FROM auth_tokens WHERE user_id = ?',[$user['user_id']]);
        $_SESSION = [];
        session_regenerate_id(true);
        clear_remember_cookie();
        redirect('login');
    }
    if ($action === 'profile') {
        try {
            $name = trim((string)($_POST['name'] ?? ''));
            $email = trim((string)($_POST['email'] ?? ''));
            $contact = trim((string)($_POST['contact'] ?? ''));
            if ($name === '' || strlen($name)>80 || strlen($email)>100 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($contact)>20) throw new InvalidArgumentException('Enter a name, valid email, and contact number of up to 20 characters.');
            $values = ['name'=>$name,'email'=>$email,'contact'=>$contact];
            $password = (string)($_POST['new_password'] ?? '');
            if ($password !== '') {
                if (!password_verify((string)($_POST['current_password'] ?? ''),$user['password'])) throw new InvalidArgumentException('Your current password is incorrect.');
                if (!password_valid($password) || $password !== ($_POST['cpassword'] ?? '')) throw new InvalidArgumentException('Use matching new passwords of 12–72 bytes.');
                $values['password'] = password_hash($password,PASSWORD_DEFAULT);
                query('DELETE FROM auth_tokens WHERE user_id = ?',[$user['user_id']]);
                clear_remember_cookie();
                session_regenerate_id(true);
            }
            update_record('mainuser_acc','user_id',$user['user_id'],$values);
            if (isset($values['password'])) {
                query('UPDATE mainuser_acc SET session_version = session_version + 1 WHERE user_id = ?',[$user['user_id']]);
                $_SESSION['session_version'] = (int)$user['session_version'] + 1;
            }
            audit('profile_update','accounts',$user['user_id']);
            flash('Profile updated.');
        } catch (InvalidArgumentException $error) { $_SESSION['form_error'] = $error->getMessage(); }
        redirect('profile');
    }
    $name = (string)($_POST['resource'] ?? '');
    $config = resource($name);
    $id = (string)($_POST['id'] ?? '');
    if (!in_array($action,['save','archive','restore','review','seen','reply'],true)) fail(400,'Unknown action.');
    if ($action === 'reply') {
        allow_roles(['admin']);
        if ($name !== 'messages') fail(400,'Only messages can be replied to.');
        $message = record($name,$id);
        $body = trim((string)($_POST['message'] ?? ''));
        if ((int)$message['user_id']===0) fail(422,'This public inquiry has no signed-in account. Contact the sender using your municipal communication process.');
        if ($body==='' || strlen($body)>10000) fail(422,'Enter a reply of up to 10,000 characters.');
        $replyId = insert_record('message_tbl',['name'=>$user['name'],'email'=>$user['email'],'user_id'=>$message['user_id'],'brgy_location'=>$message['brgy_location'],'subject'=>'Re: ' . $message['subject'],'message'=>$body]);
        audit('reply','messages',$replyId);
        flash('Reply saved to the resident or official’s inbox.');
        redirect('detail',['resource'=>'messages','id'=>(string)$replyId]);
    }
    if ($action === 'seen') {
        record($name,$id);
        if (!in_array($name,['messages','memos'],true)) fail(400,'That record has no notification.');
        query('INSERT INTO app_notifications (user_id,resource,record_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE seen_at = CURRENT_TIMESTAMP',[$user['user_id'],$name,$id]);
        flash('Marked as read.');
        redirect('detail',['resource'=>$name,'id'=>$id]);
    }
    if ($action === 'review') {
        allow_roles(['admin','dilg']);
        if ($name !== 'memos') fail(400,'Only memos can be reviewed.');
        record($name,$id);
        $status = (string)($_POST['memo_status'] ?? '');
        if (!in_array($status,['APPROVED','DECLINED','MODIFICATION REQUEST'],true)) fail(422,'Choose a valid review status.');
        $remarks = trim((string)($_POST['remarks'] ?? ''));
        if (strlen($remarks)>10000 || ($status === 'MODIFICATION REQUEST' && $remarks === '')) fail(422,'Modification requests require remarks.');
        update_record('memo','memo_id',$id,['memo_status'=>$status,'remarks'=>$remarks]);
        audit('review_' . strtolower(str_replace(' ','_',$status)),$name,$id);
        flash('Memo review saved.');
        redirect('detail',['resource'=>$name,'id'=>$id]);
    }
    if (in_array($action,['archive','restore'],true)) {
        if (!can_archive($name)) fail(403,'Your account cannot archive these records.');
        record($name,$id,true);
        if ($name === 'accounts' && (int)$id === (int)$user['user_id']) fail(422,'You cannot archive your own account.');
        if ($action === 'archive') query('INSERT IGNORE INTO app_archives (resource,record_id,archived_by) VALUES (?, ?, ?)',[$name,$id,$user['user_id']]);
        else query('DELETE FROM app_archives WHERE resource = ? AND record_id = ?',[$name,$id]);
        if ($name === 'accounts') {
            query('DELETE FROM auth_tokens WHERE user_id = ?',[$id]);
            query('UPDATE mainuser_acc SET session_version = session_version + 1 WHERE user_id = ?',[$id]);
        }
        audit($action,$name,$id);
        flash($action === 'archive' ? 'Record archived. You can restore it from the archive.' : 'Record restored.');
        redirect('records',['resource'=>$name,'archived'=>$action === 'restore' ? '1' : '0']);
    }
    allow_roles($config['write']);
    $existing = $id !== '' ? record($name,$id) : null;
    try {
        $values = validate_fields($name,$_POST,$existing !== null);
        if ($name === 'accounts') {
            if (!preg_match('/^[A-Za-z0-9_.-]{3,100}$/',$values['username'])) throw new InvalidArgumentException('Use a username of 3–100 letters, numbers, dots, underscores, or hyphens.');
            if (query('SELECT user_id FROM mainuser_acc WHERE username = ? AND user_id <> ?',[$values['username'],$id ?: 0])->fetchColumn()) throw new InvalidArgumentException('That username is already used.');
            if ((int)$id === (int)$user['user_id'] && ($values['type'] !== 'admin' || $values['app_enabled'] !== '1')) throw new InvalidArgumentException('Keep your own administrator account enabled with its administrator role.');
        }
        if ($user['type'] === 'official' && in_array($name,['resident-records','resident-surveys','barangay-surveys'],true)) {
            if ($user['brgy_location'] === '' || $user['brgy_location'] === 'Unassigned') throw new InvalidArgumentException('An administrator must assign your barangay first.');
            $values['brgy_location'] = $user['brgy_location'];
        }
        if (in_array($name,['resident-surveys','barangay-surveys'],true)) {
            $subject = $user;
            if ($name === 'resident-surveys' && $user['type'] !== 'resident') {
                $subjectId = $existing['user_id'] ?? (int)($_POST['subject_user_id'] ?? 0);
                $subject = query("SELECT * FROM mainuser_acc WHERE user_id = ? AND type = 'resident'",[$subjectId])->fetch();
                if (!$subject || ($user['type'] === 'official' && $subject['brgy_location'] !== $user['brgy_location'])) throw new InvalidArgumentException('Choose a resident account within your barangay.');
            } elseif ($existing && $user['type'] === 'admin') {
                $subject = query('SELECT * FROM mainuser_acc WHERE user_id = ?',[$existing['user_id']])->fetch() ?: $user;
            }
            $values['user_id'] = $subject['user_id'];
            $values['type'] = $subject['type'];
            $values['name'] = $subject['name'];
            $values['brgy_location'] = $subject['brgy_location'];
            $values['date'] = $existing['date'] ?? date('Y-m-d');
        }
        if ($name === 'messages') {
            if ($existing && $user['type'] !== 'admin' && (int)$existing['user_id'] !== (int)$user['user_id']) fail(403,'You cannot edit another person’s message.');
            if (!$existing) $values += ['user_id'=>$user['user_id'],'name'=>$user['name'],'email'=>$user['email'],'brgy_location'=>$user['brgy_location']];
        }
        if ($name === 'resident-records') $values['type'] = 'resident';
        if ($name === 'official-records') $values['type'] = 'official';
        if ($name === 'memos') {
            $values['memo_status'] = 'PENDING';
            $values['remarks'] = null;
            if (!$existing) $values['created_by'] = $user['user_id'];
        }
        // Validate attachment before committing any database edits.
        $file = $_FILES['attachment'] ?? null;
        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            if (empty($config['attachment']) || $file['error'] !== UPLOAD_ERR_OK || $file['size']>5*1024*1024) throw new InvalidArgumentException('Upload a PDF or image smaller than 5 MB.');
            if (!in_array((new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']),['application/pdf','image/jpeg','image/png','image/webp'],true)) throw new InvalidArgumentException('Use a PDF, JPEG, PNG, or WebP attachment.');
        }
        db()->beginTransaction();
        if ($existing) update_record($config['table'],$config['key'],$id,$values);
        else { $inserted = insert_record($config['table'],$values); $id = $config['key'] === 'psgc' ? $values['psgc'] : (string)$inserted; }
        if (!empty($config['attachment'])) upload_attachment($name,$id);
        audit($existing ? 'update' : 'create',$name,$id);
        if ($name === 'accounts' && (isset($values['password']) || (isset($values['app_enabled']) && $values['app_enabled']==='0') || ($existing && $existing['type']!==$values['type']))) {
            query('DELETE FROM auth_tokens WHERE user_id = ?',[$id]);
            query('UPDATE mainuser_acc SET session_version = session_version + 1 WHERE user_id = ?',[$id]);
            if ((int)$id===(int)$user['user_id']) $_SESSION['session_version'] = (int)$user['session_version']+1;
        }
        db()->commit();
        flash('Record saved.' . ($name === 'memos' ? ' The memo is pending review.' : ''));
        redirect('detail',['resource'=>$name,'id'=>$id]);
    } catch (InvalidArgumentException $error) {
        if (db()->inTransaction()) db()->rollBack();
        $_SESSION['form_error'] = $error->getMessage();
        unset($_POST['password'],$_POST['csrf']);
        $_SESSION['form_values'] = $_POST;
        redirect('edit',['resource'=>$name,'id'=>$existing ? $id : '']);
    } catch (PDOException $error) {
        if (db()->inTransaction()) db()->rollBack();
        if ($error->getCode() === '23000') { $_SESSION['form_error'] = 'A record with that identifier already exists.'; redirect('edit',['resource'=>$name,'id'=>$existing ? $id : '']); }
        throw $error;
    }
}
