<?php
session_start();

require_once __DIR__ . '/../pulilan_db_connect.php';

if (!isset($_SESSION['username'])) {
    header("location: ../login.php");
    exit();
}

if (isset($_GET['brgydetails_id'])) {
    $brgydetails_id = $_GET['brgydetails_id'];

    // Permanently delete the record
    $stmt = mysqli_prepare($connection, "DELETE FROM brgydetails_tbl WHERE brgydetails_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $brgydetails_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['update_success'] = "Account permanently deleted successfully.";
    } else {
        $_SESSION['update_error'] = "Failed to permanently delete account: " . mysqli_error($connection);
    }
}
header("location: ../deleted_history_brgy.php");
exit();