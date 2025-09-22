<?php
// Check if the studentLogin cookie is set
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaching Portal</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 3em;
            margin-bottom: 50px;
        }

        .login-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px 40px;
            border-radius: 10px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .login-box:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .login-link {
            text-decoration: none;
            color: #fff;
            font-size: 1.5em;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
                margin-bottom: 30px;
            }

            .login-options {
                flex-direction: column;
                gap: 10px;
            }

            .login-box {
                padding: 15px 30px;
            }

            .login-link {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Coaching Portal</h1>
        <p>Access your personalized dashboard by selecting your role below:</p>
        <div class="login-options">
            <div class="login-box">
                <a href="student-login.php" class="login-link">Student Login</a>
            </div>
            <div class="login-box">
                <a href="teacher-login.php" class="login-link">Teacher Login</a>
            </div>
            <div class="login-box">
                <a href="admin-login.php" class="login-link">Admin Login</a>
            </div>
            <div class="login-box">
                <a href="addOwner.php" class="login-link">Create Coaching</a>
            </div>
        </div>
    </div>
</body>
</html>
