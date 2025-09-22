<?php

session_start();
if (!isset($_SESSION['admin_username']) && !isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';

// Check if student ID is provided in the URL parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: viewStudent.php"); // Redirect if ID is not provided
    exit();
}

// Get the student ID from the URL parameter
$student_id = $_GET['id'];

// Prepare and execute the DELETE query
$sql = "DELETE FROM `students` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
$result = mysqli_stmt_execute($stmt);

// Check if the deletion was successful
if ($result) {
    // Set a session message indicating successful deletion
    $_SESSION['delete_message'] = "Student deleted successfully.";
} else {
    // Set a session message indicating deletion failure
    $_SESSION['delete_message'] = "Error: Failed to delete student.";
}

// Redirect back to the page displaying student data
header("Location: viewStudent.php");
exit();

?>
