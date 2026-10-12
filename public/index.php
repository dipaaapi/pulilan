<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require ROOT . '/app/routes.php';
require ROOT . '/app/controllers/auth.php';
require ROOT . '/app/controllers/actions.php';
require ROOT . '/app/controllers/pages.php';

try {
    if (isset($_GET['legacy'])) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') fail(410,'This old action has been retired. Use the updated application forms.');
        $target = legacy_route((string)$_GET['legacy']);
        if (!$target) fail(404,'This old page has been replaced. Use the navigation to find its current screen.');
        $targetPage = $target['page']; unset($target['page']);
        redirect($targetPage,$target);
    }
    $page = (string)($_GET['page'] ?? 'home');
    if (in_array($page,['login','register'],true)) { auth_page($page); exit; }
    if ($page === 'action') process_action();
    if ($page === 'contact') {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail(405,'Submit the contact form to send a message.');
        verify_csrf();
        rate_limit('contact',5,900);
        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));
        if ($name === '' || strlen($name)>80 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($email)>100 || $message === '' || strlen($message)>10000) {
            flash('Please enter your name, valid email, and a message of up to 10,000 characters.');
        } else {
            insert_record('message_tbl',['name'=>$name,'email'=>$email,'message'=>$message,'subject'=>'Public inquiry','user_id'=>0,'brgy_location'=>'']);
            flash('Thank you. Your message has been saved for the municipal administrator.');
        }
        header('Location: ' . url() . '#message-us',true,303); exit;
    }
    render_page($page);
} catch (Throwable $error) {
    try { if (db()->inTransaction()) db()->rollBack(); } catch (Throwable $ignored) {}
    error_log((string)$error);
    fail(500,'The request could not be completed. Please try again or contact the administrator.');
}
