<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';

// Check if student ID is provided in the form data
if (!isset($_POST['student_id']) || empty($_POST['student_id'])) {
    $_SESSION['delete_message'] = "Error: Student ID not provided.";
    header("Location: viewStudent.php"); // Redirect if ID is not provided
    exit();
}

// Get the student ID from the form data
$student_id = $_POST['student_id'];

// Prepare the SQL query to delete the student
$sql = "DELETE FROM `students` WHERE `id` = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $student_id);

// Execute the statement
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
