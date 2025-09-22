<?php
session_start(); // Start session

// Check if user is not logged in, then redirect to index.php
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dangerous Hacking Website - Access Page</title>
    <style>
        body {
            background-color: #111;
            color: #00ff00;
            font-family: 'Courier New', Courier, monospace;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            animation: fadeInDown 1s ease;
        }
        h1 {
            color: #00ff00;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            animation: pulse 1s infinite alternate;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            color: #00ff00;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px; /* Increased font size */
            margin: 0 10px; /* Added margin for better spacing */
        }
        a:hover {
            color: #ccffcc;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-50%);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, Hacker! You have accessed the dangerous hacking website.</h1>
        <ul>
            <!-- <li><a href="access.php">Access Page</a></li> -->
            <li><a href="coursebuyer.php">Course Buyers</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
