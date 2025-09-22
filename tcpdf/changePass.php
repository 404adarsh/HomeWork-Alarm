<?php
session_start(); // Start the session

// Check if the admin is logged in, redirect them to their destination page
if (!isset($_SESSION['sudo_username'])) {
    header("Location: index.php"); // Change "index.php" to the login page URL
    exit();
}

require '../db.php';

$alert = FALSE;
$alertContent = '';

// Fetch current password from the database
$sql = "SELECT `password` FROM `notify` WHERE `username`='{$_SESSION['sudo_username']}'";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Error in query execution
    echo "Error: " . mysqli_error($conn);
    exit();
} else {
    // Fetch the current password
    $row = mysqli_fetch_assoc($result);
    $current_password = $row['password'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $current_password_input = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Check if the current password matches the input password
    if ($current_password_input === $current_password) {
        // Update the password in the database
        $sql_update = "UPDATE `notify` SET `password`='$new_password' WHERE `username`='{$_SESSION['sudo_username']}'";
        $result_update = mysqli_query($conn, $sql_update);

        if ($result_update === false) {
            // Error in query execution
            echo "Error: " . mysqli_error($conn);
            exit();
        } else {
            // Password updated successfully
            $alert = TRUE;  
            $strong = "Password Updated!";
            $message = "Your password has been successfully updated.";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
        }
    } else {
        // Current password doesn't match
        $alert = TRUE;  
        $strong = "Incorrect Password!";
        $message = "Please enter the correct current password.";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacker Change Password</title>
    <link rel="stylesheet" href="css/hacker-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="background"></div>
    <div class="container">
        <div class="terminal">
            <h2 class="text-white">Hacker Change Password</h2>
            <form method="post">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required><br>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required><br>
                <button type="submit">Change Password</button>
                <button type="text"><a class="text-decoration-none text-white" href="forgetPass.php">Forget Password</a></button>
            </form>
            <?php 
            // Display the alert if $alert is TRUE
            if ($alert) {
                echo $alertContent;
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>

</html>
