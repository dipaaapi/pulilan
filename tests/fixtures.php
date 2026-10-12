<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
require dirname(__DIR__) . '/app/database.php';
if (getenv('DB_NAME') !== 'pulilan_upgrade_test') throw new RuntimeException('Fixtures require the isolated preview database.');
$mode = $argv[1] ?? 'setup';
if ($mode === 'cleanup') {
    foreach (query("SELECT f.* FROM app_files f JOIN memo m ON f.resource='memos' AND f.record_id=CAST(m.memo_id AS CHAR) WHERE m.project_name LIKE 'QA %'")->fetchAll() as $file) {
        $path = dirname(__DIR__) . '/storage/uploads/' . basename($file['stored_name']);
        if (is_file($path)) unlink($path);
        query('DELETE FROM app_files WHERE id = ?',[$file['id']]);
    }
    $ids = query("SELECT user_id FROM mainuser_acc WHERE username LIKE 'qa_%'")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($ids as $id) {
        query('DELETE FROM resident_q WHERE user_id = ?',[$id]);
        query('DELETE FROM brgy_q WHERE user_id = ?',[$id]);
        query('DELETE FROM auth_tokens WHERE user_id = ?',[$id]);
        query('DELETE FROM app_audit WHERE user_id = ?',[$id]);
        query('DELETE FROM app_notifications WHERE user_id = ?',[$id]);
        query('DELETE FROM message_tbl WHERE user_id = ?',[$id]);
        query("DELETE FROM app_archives WHERE resource='accounts' AND record_id=?",[(string)$id]);
    }
    query("DELETE FROM mainuser_acc WHERE username LIKE 'qa_%'");
    query("DELETE FROM memo WHERE project_name LIKE 'QA %'");
    query("DELETE FROM achievement_tbl WHERE project_name LIKE 'QA %'");
    query("DELETE FROM residentdetails_tbl WHERE name LIKE 'QA %'");
    query("DELETE FROM brgydetails_tbl WHERE fullname LIKE 'QA %'");
    query("DELETE FROM brgy_tbl WHERE psgc = '999999999'");
    query("DELETE FROM message_tbl WHERE name LIKE 'QA %'");
    // Only preview test artifacts are affected.
    query('DELETE FROM app_rate_limits');
    echo "Preview fixtures removed.\n";
    exit;
}
$users = [];
foreach (['admin','official','resident','executive','dilg','outsider'] as $role) {
    $username = 'qa_' . $role;
    query('DELETE FROM mainuser_acc WHERE username = ?',[$username]);
    $password = 'Review-' . bin2hex(random_bytes(10));
    $id = insert_record('mainuser_acc',['name'=>'QA ' . ucfirst($role),'username'=>$username,'password'=>password_hash($password,PASSWORD_DEFAULT),'type'=>$role==='outsider' ? 'resident' : $role,'email'=>$username . '@example.test','contact'=>'09170000000','brgy_location'=>$role==='outsider' ? 'Balatong A' : 'Tibag','gender'=>'Not Specified','position'=>ucfirst($role),'app_enabled'=>1]);
    $users[$role] = ['id'=>$id,'username'=>$username,'password'=>$password];
}
query('DELETE FROM app_rate_limits');
echo json_encode($users,JSON_THROW_ON_ERROR);
