<?php
session_start(); // Start the session

// Check if the admin is logged in, redirect them to their destination page
if (isset($_SESSION['sudo_username'])) {
    header("Location: list.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}






require '../db.php';

$alert = FALSE;
$alertContent = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sudo_username = $_POST['sudo_username'];
    $sudo_password = $_POST['sudo_password'];
    
    $sql = "SELECT * FROM `notify` WHERE `username`='$sudo_username' AND `password`='$sudo_password'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Error in query execution
        echo "Error: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) == 1) { // Check if one record matches
            // Admin credentials are valid, set session and redirect to admin panel
            $_SESSION['sudo_username'] = $sudo_username;
            $alert = TRUE;  
            $strong = "Login Successful!";
            $message = "Redirecting to admin panel...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            // After 4 seconds, redirect to admin panel
            echo "<script>setTimeout(function() { window.location.href = 'list.php'; }, 4000);</script>";
        } else {
            $alert = TRUE;  
            $strong = "Invalid Credentials!";
            $message = "Please Check Your Username Or Password";
            // Constructing the error alert content
            $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacker Login</title>
    <link rel="stylesheet" href="css/hacker-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="background"></div>
    <div class="container">
        <div class="terminal">
            <h2 class="text-white">Hacker Login</h2>
            <form method="post">
                <label for="sudo_username">Username:</label>
                <input type="text" id="sudo_username" name="sudo_username" required><br>
                <label for="sudo_password">Password:</label>
                <input type="password" id="sudo_password" name="sudo_password" required><br>
                <button type="submit">Login</button>
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
