<?php
session_start(); // Start the session to use session variables

// Include the database connection
require_once __DIR__ . '/../pulilan_db_connect.php';

if (isset($_POST['send_memo'])) {
    $memo = $_POST['memo'] ?? '';
    $body = $_POST['memo_body'] ?? '';
    $receiver = $_POST['receiver'] ?? ''; // Get the receiver from the form
    $picture_name = ''; // Default to empty string

    // Handle file upload
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $fileToUpload = $_FILES['picture'];
        $picture_name = basename($fileToUpload["name"]);
        $file_extension = strtolower(pathinfo($picture_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        // Server-side validation for file type
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error_message'] = "Upload failed. Only JPG, PNG, GIF, and PDF files are allowed.";
            header("location: ../admin/admin_memo.php?done=error");
            exit();
        }

        $target_dir = __DIR__ . "/temp/"; // Use absolute path for reliability
        $target_file = $target_dir . $picture_name;

        // Ensure the target directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Move the uploaded file
        move_uploaded_file($fileToUpload["tmp_name"], $target_file);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connection, "INSERT INTO memo (project_name, project_description, receiver, picture, memo_date) VALUES (?, ?, ?, ?, CURDATE())");
    mysqli_stmt_bind_param($stmt, 'ssss', $memo, $body, $receiver, $picture_name);

    if (mysqli_stmt_execute($stmt)) {
        header("location: ../admin/admin_memo.php?done=memo");
        exit();
    } else {
        $_SESSION['error_message'] = "Database error: Failed to save the memo.";
        header("location: ../admin/admin_memo.php?done=error");
        exit();
    }
}
?>