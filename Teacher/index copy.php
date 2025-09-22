<?php
session_start(); // Start the session

// Check if the admin is not logged in, redirect them to the login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

require '../db.php';

// Get the admin's username from the session
$admin_username = $_SESSION['admin_username'];

// Query to fetch the admin's name based on their username
$sql = "SELECT `name` FROM `owners` WHERE `username`='$admin_username'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the admin's name from the result
    $row = mysqli_fetch_assoc($result);
    $admin_name = $row['name'];
} else {
    // Handle the case where the query fails
    $admin_name = "Admin";
}

// Update password if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Validate the current password
    $sql = "SELECT `password` FROM `owners` WHERE `username`='$admin_username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        // Compare plain text passwords
        if ($current_password == $stored_password) {
            // Current password is correct, update the password
            $update_sql = "UPDATE `owners` SET `password`='$new_password' WHERE `username`='$admin_username'";
            $update_result = mysqli_query($conn, $update_sql);

            if ($update_result) {
                echo '<div class="alert alert-success" role="alert">Password updated successfully!</div>';
            } else {
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

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello <?php echo $admin_name ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'Navbar.php'; ?>

<main>
    <div class="container admin-container">
    <h2 class="text-center mb-4">Welcome <?php echo $admin_name; ?></h2>
        <h2 class="my-5">How Are You?</h2>
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
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
