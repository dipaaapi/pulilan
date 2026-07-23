<?php
session_start();

$uid = $_SESSION['user_id'] ?? null;
if (!$uid) {
    header("location: ../login.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "pulilan");
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['send_message'])) {

    $receiver = $_POST['receiver'] ?? '';
    $subject  = $_POST['subject'] ?? '';
    $message  = $_POST['message'] ?? '';

    $stmt = mysqli_prepare($con, "INSERT INTO message_tbl (message, subject, brgy_location, user_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssi', $message, $subject, $receiver, $uid);
    $sql = mysqli_stmt_execute($stmt);

    if ($sql) {
        $_SESSION['notif'] = "Successfuly sent message!";
        header("location: ../brgyindex.php");
        exit();
    } else {
        $_SESSION['notif'] = "Failed to send message.";
        header("location: ../brgyindex.php");
        exit();
    }
}