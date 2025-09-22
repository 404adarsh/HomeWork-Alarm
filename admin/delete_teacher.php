<?php
session_start(); // Start the session

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

require '../db.php';

// Check if teacher ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve teacher ID from the URL
    $teacher_id = $_GET['id'];

    // Prepare a delete statement
    $query = "DELETE FROM teachers WHERE id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $teacher_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the view teachers page with a success message
        $_SESSION['delete_message'] = "Teacher deleted successfully.";
        header("Location: view_teachers.php");
        exit();
    } else {
        // If deletion fails, redirect back to the view teachers page with an error message
        $_SESSION['delete_message'] = "Failed to delete teacher.";
        header("Location: view_teachers.php");
        exit();
    }
} else {
    // If teacher ID is not provided in the URL, redirect back to the view teachers page
    header("Location: view_teachers.php");
    exit();
}
?>
