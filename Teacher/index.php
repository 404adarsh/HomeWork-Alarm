<?php
session_start(); // Start the session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the teacher is not logged in, redirect them to the login page
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../../index.php");
    exit();
}

require '../db.php';

// Get the teacher's username from the session
$teacher_id = $_SESSION['teacher_id'];

// Query to fetch the teacher's name based on their username
$sql = "SELECT `name` FROM `teachers` WHERE `teacher_id`='$teacher_id'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the teacher's name from the result
    $row = mysqli_fetch_assoc($result);
    $teacher_name = $row['name'];
} else {
    // Handle the case where the query fails
    $teacher_name = "Teacher";
}

// Update password if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Validate the current password
    $sql = "SELECT `password` FROM `teachers` WHERE `teacher_id`='$teacher_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        // Compare plain text passwords
        if ($current_password == $stored_password) {
            // Current password is correct, update the password
            $update_sql = "UPDATE `teachers` SET `password`='$new_password' WHERE `teacher_id`='$teacher_id'";
            $update_result = mysqli_query($conn, $update_sql);

            if ($update_result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'Password updated successfully!';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
             else {
                echo '<div class="alert alert-danger" role="alert">Failed to update password. Please try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Incorrect current password. Please try again.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to retrieve current password. Please try again.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome <?php echo $teacher_name ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 15px;
            text-align: center;
        }
        .card-body {
            padding: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php require 'Navbar.php'; ?>
    <main>
        <div class="container">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center mb-4">Welcome <?php
                    $teacher_id = $_SESSION['teacher_id'];
                    $sql = "SELECT `name` FROM `teachers` WHERE `teacher_id` = $teacher_id";
                    $result = mysqli_query($conn, $sql);
                    
                    // Check if the query was successful
                    if ($result) {
                        // Fetch the teacher's name from the result
                        $row = mysqli_fetch_assoc($result);
                        $teacher_name = $row['name'];
                        echo $teacher_name;
                    } else {
                        // Handle the case where the query fails or no name is found
                        $teacher_name = "Teacher";
                    }
                    
                    
                    
                    ?></h2>
                </div>
            </div>
        </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Change Password
                        </div>
                        <div class="card-body">
                            <?php
                            // Display password change messages
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                // Password change logic here...
                            }
                            ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
