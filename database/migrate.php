<?php
declare(strict_types=1);
// CLI only; never expose migrations through a web endpoint.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/app/database.php';
date_default_timezone_set('Asia/Manila');
query('CREATE TABLE IF NOT EXISTS app_migrations (version varchar(100) PRIMARY KEY, applied_at timestamp DEFAULT CURRENT_TIMESTAMP)');
if (!query('SELECT 1 FROM app_migrations WHERE version = ?', ['001_native_app'])->fetchColumn()) {
if (!in_array('app_enabled',array_column(columns('mainuser_acc'),'Field'),true)) query('ALTER TABLE mainuser_acc ADD app_enabled tinyint NOT NULL DEFAULT 1');
if (!in_array('remarks',array_column(columns('memo'),'Field'),true)) query('ALTER TABLE memo ADD remarks text NULL');
if (!in_array('created_by',array_column(columns('memo'),'Field'),true)) query('ALTER TABLE memo ADD created_by int NULL');
query('CREATE TABLE IF NOT EXISTS auth_tokens (id bigint AUTO_INCREMENT PRIMARY KEY, user_id int NOT NULL, selector varchar(32) NOT NULL UNIQUE, hashed_validator varchar(64) NOT NULL, expires datetime NOT NULL, INDEX (user_id), INDEX (expires))');
query('CREATE TABLE IF NOT EXISTS app_archives (resource varchar(40) NOT NULL, record_id varchar(100) NOT NULL, archived_by int NULL, archived_at timestamp DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(resource, record_id))');
query('CREATE TABLE IF NOT EXISTS app_audit (id bigint AUTO_INCREMENT PRIMARY KEY, user_id int NULL, action varchar(50) NOT NULL, resource varchar(40) NOT NULL, record_id varchar(100) NOT NULL, created_at timestamp DEFAULT CURRENT_TIMESTAMP)');
query('CREATE TABLE IF NOT EXISTS app_rate_limits (bucket varchar(64) PRIMARY KEY, attempts int NOT NULL, expires_at datetime NOT NULL)');
query('CREATE TABLE IF NOT EXISTS app_files (id bigint AUTO_INCREMENT PRIMARY KEY, resource varchar(40) NOT NULL, record_id varchar(100) NOT NULL, stored_name varchar(80) NOT NULL UNIQUE, original_name varchar(255) NOT NULL, mime varchar(100) NOT NULL, created_at timestamp DEFAULT CURRENT_TIMESTAMP, INDEX(resource, record_id))');
query('CREATE TABLE IF NOT EXISTS app_notifications (user_id int NOT NULL, resource varchar(40) NOT NULL, record_id varchar(100) NOT NULL, seen_at timestamp DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(user_id, resource, record_id))');
db()->beginTransaction();
try {
    $count = 0;
    foreach (['mainuser_acc'=>'user_id','residentdetails_tbl'=>'user_id','brgydetails_tbl'=>'brgydetails_id'] as $table=>$key) {
        $freeze = '';
        foreach (columns($table) as $column) if (str_contains(strtolower($column['Extra']),'on update')) $freeze .= ', `' . $column['Field'] . '` = `' . $column['Field'] . '`';
        foreach (query("SELECT `$key`, password FROM `$table`")->fetchAll() as $row) {
            if ($row['password'] !== '' && password_get_info($row['password'])['algo'] === null) {
                query("UPDATE `$table` SET password = ?$freeze WHERE `$key` = ?", [password_hash($row['password'], PASSWORD_DEFAULT),$row[$key]]);
                $count++;
            }
        }
    }
    foreach (['accounts'=>['mainuser_acc','user_id'], 'resident-records'=>['residentdetails_tbl','user_id'], 'official-records'=>['brgydetails_tbl','brgydetails_id'], 'resident-surveys'=>['resident_q','question_id'], 'barangay-surveys'=>['brgy_q','question_id']] as $resource=>[$table,$key]) {
        if (in_array('visibility',array_column(columns($table),'Field'),true)) {
            query("INSERT IGNORE INTO app_archives (resource,record_id) SELECT ?, CAST(`$key` AS CHAR) FROM `$table` WHERE visibility = 1",[$resource]);
        }
    }
    query('INSERT INTO app_migrations (version) VALUES (?)',['001_native_app']);
    db()->commit();
    echo "Migration complete; $count legacy passwords hashed. Existing account access preserved.\n";
} catch (Throwable $error) { db()->rollBack(); throw $error; }
}
if (!query('SELECT 1 FROM app_migrations WHERE version = ?', ['002_optional_voting_date'])->fetchColumn()) {
    query('ALTER TABLE resident_q MODIFY latest_vote date NULL DEFAULT NULL');
    query("UPDATE resident_q SET latest_vote = NULL WHERE CAST(latest_vote AS CHAR) = '0000-00-00'");
    query('INSERT INTO app_migrations (version) VALUES (?)',['002_optional_voting_date']);
    echo "Voting dates can be left blank when not applicable.\n";
}
if (!query('SELECT 1 FROM app_migrations WHERE version = ?', ['003_unique_usernames'])->fetchColumn()) {
    $duplicate = query('SELECT username FROM mainuser_acc GROUP BY username HAVING COUNT(*) > 1 LIMIT 1')->fetch();
    if ($duplicate) throw new RuntimeException('Duplicate account usernames must be resolved before the unique-username migration.');
    if (!query("SHOW INDEX FROM mainuser_acc WHERE Key_name = 'app_username_unique'")->fetch()) query('ALTER TABLE mainuser_acc ADD UNIQUE INDEX app_username_unique (username)');
    query('INSERT INTO app_migrations (version) VALUES (?)',['003_unique_usernames']);
    echo "Account usernames now have database-enforced uniqueness.\n";
}
if (!query('SELECT 1 FROM app_migrations WHERE version = ?', ['004_session_revocation'])->fetchColumn()) {
    if (!in_array('session_version',array_column(columns('mainuser_acc'),'Field'),true)) query('ALTER TABLE mainuser_acc ADD session_version int NOT NULL DEFAULT 1');
    query('INSERT INTO app_migrations (version) VALUES (?)',['004_session_revocation']);
    echo "Password changes now revoke previous sessions.\n";
}
echo "Database is up to date.\n";
if (!query('SELECT 1 FROM app_migrations WHERE version = ?', ['005_metadata_collations'])->fetchColumn()) {
    foreach (['app_migrations','auth_tokens','app_archives','app_audit','app_rate_limits','app_files','app_notifications'] as $table) query("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    query('INSERT INTO app_migrations (version) VALUES (?)',['005_metadata_collations']);
    echo "Application metadata collations normalized.\n";
}
