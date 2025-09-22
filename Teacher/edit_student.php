<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_username']) && !isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';

// Initialize variables
$id = $name = $phone_number = $aadhar_number = $email = $class = $role = $teacher_id = "";

// Check if teacher ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: viewTeacher.php");
    exit();
}

$teacher_id = $_GET['id'];

// Fetch teacher details using provided ID
$sql = "SELECT * FROM teachers WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    // Redirect to view teachers page if teacher with given ID is not found
    header("Location: viewTeacher.php");
    exit();
}

$teacher = mysqli_fetch_assoc($result);

// Check if form is submitted for updating teacher details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated details from the form
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $aadhar_number = $_POST['aadhar_number'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $role = $_POST['role'];
    $teacher_id = $_POST['teacher_id'];

    // Update teacher details in the database
    $update_query = "UPDATE teachers SET name=?, phone_number=?, aadhar_number=?, email=?, class=?, role=?, teacher_id=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $name, $phone_number, $aadhar_number, $email, $class, $role, $teacher_id, $teacher_id);
    $update_result = mysqli_stmt_execute($stmt);

    if ($update_result) {
        // Redirect to view teachers page after successful update
        header("Location: viewTeacher.php?success=1");
        exit();
    } else {
        $error_message = "Failed to update teacher details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'Navbar.php'; ?>

<main>
    <div class="container admin-container">
        <h1 class="text-strong">Edit Teacher</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $teacher['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="aadhar_number" class="form-label">Aadhar Number</label>
                        <input type="text" class="form-control" id="aadhar_number" name="aadhar_number" value="<?php echo $teacher['aadhar_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $teacher['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" class="form-control" id="class" name="class" value="<?php echo $teacher['class']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="teacher" <?php if ($teacher['role'] === 'teacher') echo 'selected'; ?>>Teacher</option>
                            <option value="admin" <?php if ($teacher['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher ID</label>
                        <input type="text" class="form-control" id="teacher_id" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9f
