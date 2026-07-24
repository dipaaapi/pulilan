<?php
error_reporting(E_ALL ^ E_NOTICE);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../pulilan_db_connect.php';

// Fetch the unread message count here so it's available for any included partials (like the sidebar)
$sidebar_msg_count_query = mysqli_query($connection, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'");
$sidebar_msg_count = mysqli_fetch_assoc($sidebar_msg_count_query)['c'] ?? 0;

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

include __DIR__ . '/partials/admin_header.php';
include __DIR__ . '/partials/admin_sidebar.php';