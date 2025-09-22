<?php
session_start(); // Start the session

require '../db.php';

$alert = FALSE;
$alertContent = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $forget_value = $_POST['forget'];

    // Query to fetch the password based on the provided forget value
    $sql = "SELECT `password` FROM `notify` WHERE `forget`='$forget_value'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Error in query execution
        echo "Error: " . mysqli_error($conn);
        exit();
    } else {
        if (mysqli_num_rows($result) == 1) {
            // Fetch the password
            $row = mysqli_fetch_assoc($result);
            $password = $row['password'];

            // Password found, display it
            $alert = TRUE;
            $strong = "Password Found!";
            $message = "Your password is: $password";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
        } else {
            // No matching forget value found
            $alert = TRUE;
            $strong = "Forget Value Not Found!";
            $message = "Please enter a valid forget value.";
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
    <title>Hacker Forget Password</title>
    <link rel="stylesheet" href="../css/hacker-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="background"></div>
    <div class="container">
        <div class="terminal">
            <h2 class="text-white">Hacker Forget Password</h2>
            <form method="post">
                <label for="forget">Enter Forget Value:</label>
                <input type="text" id="forget" name="forget" required><br>
                <button type="submit">Retrieve Password</button>
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
