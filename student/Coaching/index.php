<?php

$alert = FALSE;
$alertContent = '';


require '../../db.php';
session_start();


if (!isset($_SESSION['userid'])) {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
}
$userid = $_SESSION["userid"];
$sql = "SELECT `full_name` FROM `students` WHERE `userid` = $userid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$fullname = $row['full_name'];
// echo $fullname; - Here We Got Full Name

$sql = "SELECT `password` FROM `students` WHERE `userid` = $userid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$password = $row['password'];
// echo $password; //  Password Value


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Hello <?php echo $fullname; ?></title>
</head>

<body>
    <?php
    require 'navbar.php';
    // Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    if ($current_password == $password) {
        $sql = "UPDATE students SET password = '$new_password' WHERE userid = $userid";
        if (mysqli_query($conn, $sql)) {
            // Password changed successfully
            $alert = TRUE;
            $strong = "Password Changed Successfully! ";
            $message = "Refreshing The Page...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 3000);</script>";
        } else {
            // Error occurred while updating password
            $alert = TRUE;
            $strong = "Error Changing Password! ";
            $message = "Please try again later.";
            // Constructing the error alert content
            $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
        }
    } else {
        // Current password entered by the user is incorrect
        $alert = TRUE;
        $strong = "Incorrect Current Password! ";
        $message = "Please enter the correct current password.";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
    }
}
?>
    <div class="top-container">
        <div class="container">
            <br><br><br>
        <div class="Greetings">
            <h1 class="nameGreet">Welcome <?php echo $fullname; ?></h1>
        </div>
        <br><br><br>    
        <div class="pass-Field">
        <div class="card">
            <div class="card-header">
                Change Password
            </div>
            <div class="card-body">
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
</body>

<script src="index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>