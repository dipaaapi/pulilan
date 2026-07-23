<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: ../login.php");
    exit();
}

require_once __DIR__ . '/../pulilan_db_connect.php';

if (isset($_GET['brgydetails_id'])) {
    $brgydetails_id = $_GET['brgydetails_id'];

    // Update visibility to 0 (visible) and set archived_date to NULL
    $stmt = mysqli_prepare($connection, "UPDATE brgydetails_tbl SET visibility = 0, archived_date = NULL WHERE brgydetails_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $brgydetails_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['update_success'] = "Account restored successfully.";
    } else {
        $_SESSION['update_error'] = "Failed to restore account.";
    }
}
header("location: ../deleted_history_brgy.php");
exit();