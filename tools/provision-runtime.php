<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/app/database.php';
$database = getenv('DB_NAME') ?: 'pulilan';
if (!preg_match('/^[a-zA-Z0-9_]+$/', $database)) throw new RuntimeException('Invalid database name.');
$username = 'web_' . substr(hash('sha256', $database), 0, 16);
$password = bin2hex(random_bytes(32));
$account = db()->quote($username) . "@'localhost'";
query("CREATE USER IF NOT EXISTS $account IDENTIFIED BY " . db()->quote($password));
query("ALTER USER $account IDENTIFIED BY " . db()->quote($password));
query("REVOKE ALL PRIVILEGES, GRANT OPTION FROM $account");
foreach (query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $table) {
    if (!preg_match('/^[a-z_]+$/', $table)) throw new RuntimeException('Invalid table name.');
    if ($table === 'app_migrations') continue;
    $grants = $table === 'app_audit' ? 'SELECT, INSERT' : 'SELECT, INSERT, UPDATE';
    if (in_array($table, ['auth_tokens','app_rate_limits','app_archives'], true)) $grants .= ', DELETE';
    query("GRANT $grants ON `$database`.`$table` TO $account");
}
$directory = '/run/pulilan';
if (!is_dir($directory)) mkdir($directory, 0750, true);
chgrp($directory, 'www-data');
$config = ['database'=>$database, 'username'=>$username, 'password'=>$password];
file_put_contents($directory . '/database.php', '<?php return ' . var_export($config, true) . ';', LOCK_EX);
chmod($directory . '/database.php', 0640);
chgrp($directory . '/database.php', 'www-data');
echo "Restricted web database account provisioned.\n";
