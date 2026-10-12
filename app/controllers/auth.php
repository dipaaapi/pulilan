<?php
declare(strict_types=1);

function auth_page(string $page): void {
    if (current_user()) redirect('dashboard');
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verify_csrf();
        rate_limit($page, $page === 'login' ? 20 : 5, 900);
        try {
            $username = trim((string)($_POST['username'] ?? ''));
            $password = (string)($_POST['password'] ?? '');
            if (!preg_match('/^[A-Za-z0-9_.-]{3,100}$/',$username)) throw new InvalidArgumentException('Use a username of 3–100 letters, numbers, dots, underscores, or hyphens.');
            if ($page === 'login') {
                $user = query('SELECT * FROM mainuser_acc WHERE username = ? LIMIT 1',[$username])->fetch();
                $valid = password_verify($password,$user['password'] ?? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi');
                $archived = $user && query("SELECT 1 FROM app_archives WHERE resource = 'accounts' AND record_id = ?",[(string)$user['user_id']])->fetchColumn();
                if (!$user || !$valid || (int)$user['app_enabled'] !== 1 || $archived || !in_array($user['type'],['admin','official','resident','dilg','executive'],true)) throw new InvalidArgumentException('Unable to sign in. Check your credentials or ask an administrator to enable your account.');
                if (password_needs_rehash($user['password'],PASSWORD_DEFAULT)) update_record('mainuser_acc','user_id',$user['user_id'],['password'=>password_hash($password,PASSWORD_DEFAULT)]);
                login_user($user, isset($_POST['remember_me']));
                redirect('dashboard');
            }
            $name = trim((string)($_POST['name'] ?? ''));
            $email = trim((string)($_POST['email'] ?? ''));
            $contact = trim((string)($_POST['contact'] ?? ''));
            $barangay = (string)($_POST['brgy_location'] ?? '');
            if ($name === '' || strlen($name)>80 || strlen($email)>100 || strlen($contact)>20 || !filter_var($email,FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Provide your name, a valid email address, and a contact number of up to 20 characters.');
            if (!array_key_exists($barangay,choices('brgy_location')) || $barangay === 'Unassigned') throw new InvalidArgumentException('Select your barangay.');
            if (!password_valid($password) || $password !== ($_POST['cpassword'] ?? '')) throw new InvalidArgumentException('Use matching passwords of 12–72 bytes.');
            if (query('SELECT 1 FROM mainuser_acc WHERE username = ?',[$username])->fetchColumn()) throw new InvalidArgumentException('That username is unavailable.');
            $id = insert_record('mainuser_acc',['name'=>$name,'username'=>$username,'email'=>$email,'contact'=>$contact,'password'=>password_hash($password,PASSWORD_DEFAULT),'type'=>'resident','position'=>'Resident','brgy_location'=>$barangay,'province'=>'Bulacan','city_municipality'=>'Pulilan','gender'=>'Not Specified','date'=>date('Y-m-d'),'app_enabled'=>0]);
            audit('registration','accounts',$id);
            flash('Registration received. An administrator must enable your resident account before you can sign in.');
            redirect('login');
        } catch (InvalidArgumentException $exception) { $error = $exception->getMessage(); }
    }
    $title = ($page === 'login' ? 'Sign in' : 'Create an account') . ' · Pulilan CBMS';
    require ROOT . '/views/layouts/header.php';
    require ROOT . '/views/pages/auth.php';
    require ROOT . '/views/layouts/footer.php';
}
