<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
$credentials = require '/run/pulilan/database.php';
$pdo = new PDO('mysql:host=localhost;dbname=' . $credentials['database'], $credentials['username'], $credentials['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$pdo->query('SELECT COUNT(*) FROM mainuser_acc')->fetchColumn();
foreach (['DELETE FROM mainuser_acc WHERE 1=0', 'UPDATE app_audit SET action=action WHERE 1=0', 'DELETE FROM app_audit WHERE 1=0', 'DROP TABLE app_permission_probe_nonexistent'] as $sql) {
    try { $pdo->exec($sql); throw new RuntimeException('Unexpected permission: ' . $sql); }
    catch (PDOException $error) {
        if (!in_array((int)($error->errorInfo[1] ?? 0), [1044,1142], true)) throw $error;
    }
}
$pdo->beginTransaction();
$pdo->exec("INSERT INTO app_audit (action,resource,record_id) VALUES ('permission_probe','test','0')");
$pdo->rollBack();
echo "Runtime reads and audit inserts allowed; business deletion, audit tampering, and DROP denied.\n";
