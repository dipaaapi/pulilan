<?php
error_reporting(E_ALL ^ E_NOTICE);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../pulilan_db_connect.php';

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

if (!isset($con) || !($con instanceof mysqli)) {
    $con = mysqli_connect('localhost', 'root', '', 'pulilan');
    if (!$con) {
        die('Database connection failed: ' . mysqli_connect_error());
    }
}

$current_page = basename($_SERVER['PHP_SELF']);

include __DIR__ . '/partials/admin_header.php';
include __DIR__ . '/partials/admin_sidebar.php';
