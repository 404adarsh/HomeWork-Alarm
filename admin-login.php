<?php
session_start(); // Session shuru karo

// Admin logged in hai ya nahi, uska check karo aur unhe unke destination page par redirect karo
if (isset($_SESSION['admin_username'])) {
    header("Location: admin/index.php"); // "destination_page.php" ko admin ka redirect hone wala page se badal do
    exit();
}
elseif (isset($_SESSION['userid'])) {
    header("Location: student/Coaching/index.php"); // "destination_page.php" ko student ka redirect hone wala page se badal do
    exit();
}
elseif (isset($_SESSION['teacher_id'])) {
    header("Location: Teacher/index.php"); // "destination_page.php" ko teacher ka redirect hone wala page se badal do
    exit();
}
elseif(isset($_COOKIE['CoachingId'])){
    header("Location: admin/index.php"); // "destination_page.php" ko admin ka redirect hone wala page se badal do
}

// Database connection file ko require karo
require './db.php';

$alert = FALSE;
$alertContent = '';

// Check karne ke liye ki user ne galat password kitni baar try kiya hai
if(isset($_COOKIE['wrong_password_attempts'])) {
    $wrong_attempts = $_COOKIE['wrong_password_attempts'];
    // Agar attempts 6 se zyada hain, toh user ko block kar do
    if($wrong_attempts >= 6) {
        // Cookie ko set karo jismein block ka message ho
        setcookie('login_block', 'true', time() + (24 * 3600)); // 24 hours ke liye
        // Aur user ko redirect karo login page par
        header("Location: login.php");
        exit();
    }
} else {
    // Agar cookie nahi hai ya value empty hai, toh 0 set karo
    $wrong_attempts = 0;
}

// Agar POST request aayi hai, tab admin ka username aur password lekar SQL query execute karo
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $CoachingId = $_POST['CoachingId'];
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];
    
    // Prepared statement ka istemal karke SQL injection ko roko
    $sql = "SELECT * FROM `owners` WHERE `username`=? AND `password`=? AND `CoachingId`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $admin_username, $admin_password, $CoachingId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Agar query mein error hai, toh uska error message print karo
    if ($result === false) {
        echo "Error: " . mysqli_error($conn);
    } else {
        // Agar ek record milta hai toh admin ka login sahi hai, session set karo aur admin panel par redirect karo
        if ($result->num_rows == 1) {
            $_SESSION['admin_username'] = $admin_username;
            // Set the CoachingId cookie
            setcookie('CoachingId', $CoachingId, time() + (86400 * 30), "/"); // 30 days ke liye
            $alert = TRUE;  
            $strong = "Login Successful!";
            $message = "Redirecting to admin panel...";
            // Success alert content banakar print karo
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            // 4 seconds ke baad admin panel par redirect karo
            echo "<script>setTimeout(function() { window.location.href = 'admin/index.php'; }, 4000);</script>";
        } else {
            // Agar credentials invalid hai toh error alert print karo
            $alert = TRUE;  
            $strong = "Invalid Credentials!";
            $message = "Please Check Your Username Or Password";
            // Error alert content banakar print karo
            $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';

            // Galat password ka count increment karo
            $wrong_attempts++;
            // Cookie mein count store karo
            setcookie('wrong_password_attempts', $wrong_attempts, time() + (24 * 3600)); // 24 hours ke liye

            // Agar attempts 6 ho gaye hain, toh message dikhao aur user ko block karo
            if ($wrong_attempts >= 6) {
                $alertContent .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $alertContent .= 'अब कुछ नहीं हो सकता कृपा करके अब सो जाये, लिट्टी चोखा खाये और कल आये';
                $alertContent .= '</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agarwal Coaching Centre - Portal</title>
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/portal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'singleNavbar.php'; ?>
    <br><br>

    <?php 
    // Agar $alert TRUE hai, toh alert print karo
    if ($alert) {
        echo $alertContent;
    }
    ?>
    <main>
        <h2>Admin Login</h2>
        <form method="post">
            <label for="CoachingId">Enter Your Coaching Id:</label>
            <input type="text" id="CoachingId" name="CoachingId" required><br>
            <label for="admin_username">Username:</label>
            <input type="text" id="admin_username" name="admin_username" required><br>
            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required><br>
            <button type="submit">Login</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
    <script src="js/Portal.js"></script>
</body>
</html>
