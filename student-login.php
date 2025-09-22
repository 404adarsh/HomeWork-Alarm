<?php
session_start(); // Session start karo

// Agar admin login hai, toh unko admin panel pe redirect karo
if (isset($_SESSION['admin_username'])) {
    header("Location: admin/index.php");
    exit();
} elseif (isset($_SESSION['userid'])) {
    header("Location: student/Coaching/index.php");
    exit();
} elseif (isset($_SESSION['teacher_id'])) {
    header("Location: Teacher/index.php");
    exit();
}

require 'db.php';

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
        header("Location: student-login.php");
        exit();
    }
} else {
    // Agar cookie nahi hai ya value empty hai, toh 0 set karo
    $wrong_attempts = 0;
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
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Custom CSS to adjust alert position */
        .alert-fixed {
            position: fixed;
            top: 60px; /* Adjust as per your requirement */
            right: 15px; /* Adjust as per your requirement */
            z-index: 1000; /* To ensure it stays on top of other elements */
        }
    </style>
</head>
<body>
    <?php include 'singleNavbar.php'; 
    
    
    
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $CoachingId = $_POST['CoachingId'];

    // Prepared statement ka istemal karke SQL query ko secure karo
    $sql = "SELECT * FROM `students` WHERE `userid`=? AND `password`=? AND `CoachingId`=?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $userid, $password, $CoachingId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result === false) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['userid'] = $userid;

        $alert = TRUE;
        $strong = "Login Successful!";
        $message = "Redirecting to student panel...";
        $alertContent = '<div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;

        setcookie('studentLogin', 'true', time() + (86400 * 90), "/"); // 86400 seconds in a day * 90 days = 3 months

        // Delay the redirection to ensure the alert is displayed
        echo "<script>setTimeout(function() { window.location.href = 'student/Coaching/index.php'; }, 4000);</script>";
        exit(); // Terminate the script after echoing the alert
    } else {
        $alert = TRUE;
        $strong = "Invalid Credentials!";
        $message = "Please Check Your Id Or Password";
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;

        // Galat password ka count increment karo
        $wrong_attempts++;
        // Cookie mein count store karo
        setcookie('wrong_password_attempts', $wrong_attempts, time() + (24 * 3600)); // 24 hours ke liye

        // Agar attempts 6 se zyada hai, toh block ka message dikhao
        if($wrong_attempts >= 6) {
            $alertContent = '<div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">';
            $alertContent .= 'अब कुछ नहीं हो सकता कृपा करके अब सो जाये, लिट्टी चोखा खाये और कल आये';
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo $alertContent;
        }
    }
}
    ?>
    <br><br>

    <?php 
    // Agar $alert TRUE hai, toh alert display karo
    if ($alert) {
        echo $alertContent;
    }
    ?>
    <main>
        <h2>Student Login</h2>
        <form action="student-login.php" method="post">
            <label for="CoachingId">Coaching Id:</label>
            <input type="text" id="CoachingId" name="CoachingId" required><br>
            <label for="student_username">Student Id:</label>
            <input type="text" id="userid" name="userid" required><br>
            <label for="student_password">Password:</label>
            <input type="password" id="student_password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </main>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
    <script src="js/Portal.js"></script>
</body>
</html>
