<?php
session_start();

// Admin login only sets $_SESSION['username'], not a mainuser_acc user_id,
// so we fall back to the fixed "Admin" row id used elsewhere in this app.
// NOTE: confirm 42 is really the Admin row in mainuser_acc — if it ever
// changes, update ADMIN_USER_ID here instead of hardcoding it inline.
const ADMIN_USER_ID = 42;
$uid = $_SESSION['user_id'] ?? ADMIN_USER_ID;

if (!isset($_SESSION['username'])) {
    header("location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../pulilan_db_connect.php';


if (isset($_POST['send_message'])) {

    $receiver = $_POST['receiver'] ?? '';
    $subject  = $_POST['subject'] ?? '';
    $message  = $_POST['message'] ?? '';

    $stmt = mysqli_prepare($connection, "INSERT INTO message_tbl (message, subject, brgy_location, user_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssi', $message, $subject, $receiver, $uid); // Assumes $connection is from the included file
    $sql = mysqli_stmt_execute($stmt);

    if ($sql) {
        $_SESSION['notif'] = "Successfuly sent message!";
        header("location: ../adminindex.php");
        exit();
    } else {
        $_SESSION['notif'] = "Failed to send message.";
        header("location: ../adminindex.php");
        exit();
    }
}