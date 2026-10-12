<?php
declare(strict_types=1);

define('ROOT', dirname(__DIR__));
date_default_timezone_set('Asia/Manila');
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('session.use_strict_mode', '1');
session_name('pulilan_session');
session_set_cookie_params(['httponly' => true, 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', 'samesite' => 'Lax', 'path' => '/']);
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'");
header('Cache-Control: no-store');

require ROOT . '/app/database.php';
require ROOT . '/app/security.php';
require ROOT . '/app/resources.php';
require ROOT . '/views/components/ui.php';

function e(mixed $value): string { return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function base_path(): string {
    $base = rtrim(getenv('APP_BASE_PATH') ?: '', '/');
    return $base;
}
function url(string $page = 'home', array $params = []): string {
    return base_path() . '/index.php?' . http_build_query(['page' => $page] + $params);
}
function asset(string $path): string { return base_path() . '/assets/' . $path; }
function redirect(string $page, array $params = []): never { header('Location: ' . url($page, $params), true, 303); exit; }
function fail(int $status, string $message): never {
    http_response_code($status);
    $error = $message;
    $title = $status . ' · Pulilan CBMS';
    $page = 'error';
    require ROOT . '/views/layouts/header.php';
    echo '<section class="card"><h1>' . e($status) . '</h1><p>' . e($message) . '</p>' . button('Return home', ['href' => url()]) . '</section>';
    require ROOT . '/views/layouts/footer.php';
    exit;
}
function flash(string $message): void { $_SESSION['flash'] = $message; }
function label(string $name): string {
    $labels = ['brgy_location'=>'Barangay', 'brgy_classification'=>'Barangay classification', 'char_brgy'=>'Barangay terrain', 'no_household'=>'Number of households', 'no_families'=>'Number of families', 'no_fam_house'=>'Families in the household', 'brgy_id_num'=>'Barangay identification number', 'c_pop'=>'Population share', 'psgc'=>'PSGC code', 'educ_stat'=>'Education status', 'civil_stat'=>'Civil status', 'stat_house'=>'Housing status', 'latest_vote'=>'Date last voted', 'app_enabled'=>'Account access', 'no_son'=>'Number of sons', 'no_daughter'=>'Number of daughters', 'no_nephew'=>'Number of nephews', 'no_niece'=>'Number of nieces'];
    return $labels[$name] ?? ucfirst(str_replace('_', ' ', $name));
}
