<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/app/database.php';
$username = getenv('ADMIN_USERNAME') ?: '';
$password = getenv('ADMIN_PASSWORD') ?: '';
if (!preg_match('/^[A-Za-z0-9_.-]{3,100}$/', $username) || strlen($password)<12 || strlen($password)>72) {
    fwrite(STDERR, "Set ADMIN_USERNAME (3-100 allowed characters) and ADMIN_PASSWORD (12-72 bytes).\n");
    exit(1);
}
if (query('SELECT 1 FROM mainuser_acc WHERE username = ?', [$username])->fetchColumn()) {
    fwrite(STDERR, "Username already exists; existing accounts are not changed.\n"); exit(1);
}
$id = insert_record('mainuser_acc', ['name'=>'System Administrator','username'=>$username,'password'=>password_hash($password,PASSWORD_DEFAULT),'type'=>'admin','position'=>'Administrator','brgy_location'=>'Unassigned','app_enabled'=>1,'session_version'=>1]);
echo "Administrator account created: $id.\n";
