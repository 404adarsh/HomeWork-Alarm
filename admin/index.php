<?php
session_start(); // Start the session

// Check if the admin is not logged in, redirect them to the login page
if(!$_COOKIE['CoachingId']){
    header("Location: logout.php"); // "destination_page.php" ko admin ka redirect hone wala page se badal do
    
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
                echo "<script>setTimeout(function() { window.location.href = '../index.php'; }, 4000);</script>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $admin_name ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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

        .welcome-message {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .admin-container {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px 40px;
            border-radius: 10px;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            padding: 20px;
        }

        .card-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Canvas Animation */
        #canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>

<?php require 'navbar.php'; ?>

<!-- Canvas Animation -->
<canvas id="canvas"></canvas>

<!-- Page Content -->
<div class="container">
    <h1 class="welcome-message">Welcome <?php echo $admin_name; ?></h1>
    <button id="showAdminContainer" class="btn btn-primary changeBtn">Change Your Password</button>

    <div class="admin-container" id="adminContainer" style="display: none;">
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

<!-- JavaScript for Toggle Admin Container -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/index.js"></script>
<script>
    const showAdminContainerButton = document.getElementById('showAdminContainer');
    const adminContainer = document.getElementById('adminContainer');

    showAdminContainerButton.addEventListener('click', function() {
        if (adminContainer.style.display === 'none' || adminContainer.style.display === '') {
            adminContainer.style.display = 'block';
        } else {
            adminContainer.style.display = 'none';
        }
    });

    // Canvas Animation
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particlesArray = [];
    const numberOfParticles = 100;

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 5 + 1;
            this.speedX = Math.random() * 3 - 1.5;
            this.speedY = Math.random() * 3 - 1.5;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.size > 0.2) this.size -= 0.1;
        }
        draw() {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.closePath();
            ctx.fill();
        }
    }

    function init() {
        particlesArray = [];
        for (let i = 0; i < numberOfParticles; i++) {
            particlesArray.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particlesArray.length; i++) {
            particlesArray[i].update();
            particlesArray[i].draw();
        }
        requestAnimationFrame(animate);
    }

    init();
    animate();
</script>
</body>
</html>
