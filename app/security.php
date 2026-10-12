<?php
declare(strict_types=1);

function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function csrf(): string { return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'; }
function verify_csrf(): void {
    if (!is_string($_POST['csrf'] ?? null) || !hash_equals(csrf_token(), $_POST['csrf'])) fail(403, 'Your form expired. Reload the page and try again.');
}
function current_user(): ?array {
    static $loaded = false, $user = null;
    if ($loaded) return $user;
    $loaded = true;
    $id = $_SESSION['user_id'] ?? null;
    $fromRemember = false;
    if (!$id && !empty($_COOKIE['remember_me'])) {
        $parts = explode(':', $_COOKIE['remember_me']);
        if (count($parts) === 2 && ctype_xdigit($parts[0]) && ctype_xdigit($parts[1])) {
            $token = query('SELECT * FROM auth_tokens WHERE selector = ? AND expires > NOW()', [$parts[0]])->fetch();
            if ($token && hash_equals($token['hashed_validator'], hash('sha256', $parts[1]))) {
                $id = (int) $token['user_id'];
                $fromRemember = true;
                session_regenerate_id(true);
                $_SESSION['user_id'] = $id;
                // Rotate persistent credentials after use.
                query('DELETE FROM auth_tokens WHERE selector = ?', [$parts[0]]);
                remember_user($id);
            }
        }
    }
    if ($id) {
        $candidate = query('SELECT * FROM mainuser_acc WHERE user_id = ?', [$id])->fetch();
        if ($fromRemember && $candidate) $_SESSION['session_version'] = (int)$candidate['session_version'];
        $archived = query("SELECT 1 FROM app_archives WHERE resource = 'accounts' AND record_id = ?", [(string)$id])->fetchColumn();
        if ($candidate && (int)$candidate['app_enabled'] === 1 && (int)($_SESSION['session_version'] ?? 0)===(int)$candidate['session_version'] && !$archived && in_array($candidate['type'], ['admin','official','resident','executive','dilg'], true)) $user = $candidate;
        else { unset($_SESSION['user_id']); clear_remember_cookie(); }
    }
    return $user;
}
function require_user(): array { return current_user() ?? redirect('login'); }
function allow_roles(array $roles): array {
    $user = require_user();
    if (!in_array($user['type'], $roles, true)) fail(403, 'Your account does not have access to this action.');
    return $user;
}
function remember_user(int $id): void {
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));
    query('DELETE FROM auth_tokens WHERE user_id = ? OR expires < NOW()', [$id]);
    query('INSERT INTO auth_tokens (user_id, selector, hashed_validator, expires) VALUES (?, ?, ?, ?)', [$id,$selector,hash('sha256',$validator),date('Y-m-d H:i:s',time()+2592000)]);
    setcookie('remember_me', "$selector:$validator", ['expires'=>time()+2592000,'path'=>'/','httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off','samesite'=>'Lax']);
}
function clear_remember_cookie(): void { setcookie('remember_me','',['expires'=>time()-3600,'path'=>'/','httponly'=>true,'samesite'=>'Lax']); }
function audit(string $action, string $resource, string|int $id = ''): void {
    query('INSERT INTO app_audit (user_id, action, resource, record_id) VALUES (?, ?, ?, ?)', [$_SESSION['user_id'] ?? null,$action,$resource,(string)$id]);
}
function login_user(array $user, bool $remember): void {
    session_regenerate_id(true);
    $_SESSION = ['user_id'=>(int)$user['user_id'], 'session_version'=>(int)$user['session_version'], 'csrf'=>bin2hex(random_bytes(32))];
    if ($remember) remember_user((int)$user['user_id']);
    audit('sign_in','accounts',$user['user_id']);
    insert_record('loghistory',['username'=>$user['username']]);
}
function password_valid(string $password): bool { return strlen($password) >= 12 && strlen($password) <= 72; }
/** A persistent limit independent of the browser's session cookie. */
function rate_limit(string $purpose, int $limit, int $seconds, ?string $identity = null): void {
    $key = hash('sha256', $purpose . '|' . ($identity ?? ($_SERVER['REMOTE_ADDR'] ?? 'cli')));
    query('DELETE FROM app_rate_limits WHERE expires_at < NOW()');
    query('INSERT INTO app_rate_limits (bucket, attempts, expires_at) VALUES (?, 1, ?) ON DUPLICATE KEY UPDATE attempts = attempts + 1', [$key,date('Y-m-d H:i:s',time()+$seconds)]);
    if ((int)query('SELECT attempts FROM app_rate_limits WHERE bucket = ?',[$key])->fetchColumn() > $limit) fail(429,'Too many attempts. Please wait before trying again.');
}
function valid_date(string $value): bool {
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    return $date !== false && $date->format('Y-m-d') === $value && $value >= '1900-01-01' && $value <= '2100-12-31';
}
function csv_value(mixed $value): string {
    $value = (string)($value ?? '');
    return preg_match('/^[\s]*[=+@-]/u', $value) ? "'" . $value : $value;
}
