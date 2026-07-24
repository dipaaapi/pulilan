<?php
session_start();

require_once __DIR__ . '/../pulilan_db_connect.php';

if (!isset($_SESSION['username'])) {
    header("location: ../login.php");
    exit();
}

if (isset($_GET['brgydetails_id'])) {
    $brgydetails_id = $_GET['brgydetails_id'];

    // Set the timezone to your local timezone
    date_default_timezone_set('Asia/Manila');
    $archived_date = date('Y-m-d H:i:s');

    // Update visibility to 1 (archived) and set the archived_date
    $query = "UPDATE brgydetails_tbl SET visibility = 1, archived_date = '{$archived_date}' WHERE brgydetails_id = '{$brgydetails_id}'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['update_success'] = "Account archived successfully.";
    } else {
        $_SESSION['update_error'] = "Failed to archive account.";
    }
}
header("location: ../brgylist_table.php");
exit();