<?php
declare(strict_types=1);

function db(): PDO {
    static $pdo;
    if (!$pdo) {
        $host = getenv('DB_HOST') ?: 'localhost';
        $name = getenv('DB_NAME') ?: 'pulilan';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: '';
        if (PHP_SAPI !== 'cli') {
            $credentials = is_file('/run/pulilan/database.php') ? require '/run/pulilan/database.php' : null;
            if (is_array($credentials) && $credentials['database'] === $name) {
                $username = $credentials['username'];
                $password = $credentials['password'];
            } elseif (getenv('APP_REQUIRE_RUNTIME_DB') === '1') {
                throw new RuntimeException('Restricted database credentials are unavailable.');
            }
        }
        $pdo = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $username, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false]);
        $pdo->exec("SET time_zone = '+08:00'");
        $pdo->exec('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
    }
    return $pdo;
}
function query(string $sql, array $params = []): PDOStatement {
    $statement = db()->prepare($sql);
    $statement->execute($params);
    return $statement;
}
function columns(string $table): array {
    if (!preg_match('/^[a-z_]+$/', $table)) throw new InvalidArgumentException('Invalid table');
    static $cache = [];
    return $cache[$table] ??= query("SHOW COLUMNS FROM `$table`")->fetchAll();
}
/** Populate required legacy columns without relaxing MySQL strict mode. */
function insert_record(string $table, array $values): int {
    foreach (columns($table) as $column) {
        $name = $column['Field'];
        if (str_contains($column['Extra'], 'auto_increment') || array_key_exists($name, $values) || $column['Default'] !== null || $column['Null'] === 'YES') continue;
        $values[$name] = str_contains($column['Type'], 'int') ? 0 : (str_starts_with($column['Type'], 'date') ? date('Y-m-d') : '');
    }
    $allowed = array_column(columns($table), 'Field');
    $values = array_intersect_key($values, array_flip($allowed));
    $fields = implode(',', array_map(fn($key) => "`$key`", array_keys($values)));
    query("INSERT INTO `$table` ($fields) VALUES (" . implode(',', array_fill(0, count($values), '?')) . ')', array_values($values));
    return (int) db()->lastInsertId();
}
function update_record(string $table, string $key, string|int $id, array $values): void {
    $allowed = array_column(columns($table), 'Field');
    if (!in_array($key, $allowed, true)) throw new InvalidArgumentException('Invalid key');
    $values = array_intersect_key($values, array_flip($allowed));
    unset($values[$key]);
    if (!$values) return;
    $sets = implode(',', array_map(fn($name) => "`$name` = ?", array_keys($values)));
    query("UPDATE `$table` SET $sets WHERE `$key` = ?", [...array_values($values), $id]);
}
