<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: ../../login.php");
    exit();
}

require_once __DIR__ . '/../../pulilan_db_connect.php';

if (isset($_GET['brgydetails_id'])) {
    $brgydetails_id = mysqli_real_escape_string($connection, $_GET['brgydetails_id']);

    // Permanently delete the record
    $query = "DELETE FROM brgydetails_tbl WHERE brgydetails_id = '{$brgydetails_id}'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['update_success'] = "Account permanently deleted successfully.";
    } else {
        $_SESSION['update_error'] = "Failed to permanently delete account: " . mysqli_error($con);
    }
}
header("location: ../deleted_history_brgy.php");
exit();