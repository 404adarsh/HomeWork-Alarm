<?php

session_start();
if (!isset($_SESSION['sudo_username'])) {
    header("Location: admin_console.php");
    exit();
}


require '../db.php';

// Check if there's a delete message in the session
$delete_message = "";
if (isset($_SESSION['delete_message'])) {
    // Store the delete message
    $delete_message = $_SESSION['delete_message'];
    // Remove the delete message from the session
    unset($_SESSION['delete_message']);
}

// Initialize variables for search
$search = "";
$query = "SELECT * FROM `students`";
// Check if the search form is submitted
if(isset($_POST['search'])) {
    $search = $_POST['search'];
    // Modify the query to include the search condition using prepared statements
    $query = "SELECT * FROM `students` WHERE 
                `full_name` LIKE ? OR 
                `phone_number` LIKE ? OR 
                `userid` LIKE ? OR 
                `class` LIKE ?";
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    // Define search pattern
    $searchPattern = '%' . $search . '%';
    // Bind parameter
    mysqli_stmt_bind_param($stmt, "ssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern);
    // Execute the statement
    mysqli_stmt_execute($stmt);
    // Get result
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Fetch data from the database without search
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Hacked ACC</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
        }

        h2 {
            color: #0f0;
            text-align: center;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: #111;
            border: 2px solid #0f0;
            border-radius: 10px;
            box-shadow: 0 0 20px #0f0;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 0;
        }

        .card-text {
            margin: 0;
            padding: 5px 0;
            border-bottom: 1px solid #0f0;
        }

        .edit-btn {
            text-align: center;
            margin-top: 10px;
        }

        .edit-btn a {
            color: #0f0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .edit-btn a:hover {
            color: #f00;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #111;
            border: 1px solid #0f0;
            color: #0f0;
        }

        .btn-outline-secondary {
            border-color: #0f0;
            color: #0f0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #0f0;
            color: #000;
        }

        .alert {
            background-color: #111;
            border: 2px solid #0f0;
            color: #0f0;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .navbar {
            background-color: #000 !important;
        }

        .navbar-brand {
            color: #0f0 !important;
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>
    <canvas id="canvas"></canvas>

    <div class="container my-5">
        <h2 class="text-center mb-4">Student Data</h2>

        <!-- Delete message -->
        <?php if (!empty($delete_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $delete_message; ?>
        </div>
        <?php endif; ?>

     
    <!-- Search bar -->
    <form method="POST" action="" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search by name, phone number, or user ID" name="search" value="<?php echo $search; ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>


        <div class="row">
            <?php
            // Loop through the fetched records and display them in a vertical format
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<div class='text-white card-body'>";
                echo "<p class='card-text'><strong>Name:</strong> {$row['full_name']}</p>";
                echo "<p class='card-text'><strong>Class:</strong> {$row['class']}</p>";
                echo "<p class='card-text'><strong>Father Name:</strong> {$row['father_name']}</p>";
                echo "<p class='card-text'><strong>Mother Name:</strong> {$row['mother_name']}</p>";
                echo "<p class='card-text'><strong>Phone Number:</strong> {$row['phone_number']}</p>";
                echo "<p class='card-text'><strong>Alternate Phone Number:</strong> {$row['alternate_number']}</p>";
                echo "<p class='card-text'><strong>Address:</strong> {$row['address']}</p>";
                echo "<p class='card-text'><strong>Education In:</strong> {$row['category']}</p>";
                echo "<p class='card-text'><strong>School:</strong> {$row['school']}</p>";
                echo "<p class='card-text'><strong>State:</strong> {$row['state']}</p>";
                echo "<p class='card-text'><strong>City:</strong> {$row['city']}</p>";
                echo "<p class='card-text'><strong>City:</strong> {$row['school']}</p>";
                echo "<p class='card-text'><strong>Aadhar Number:</strong> {$row['aadhar_number']}</p>";
                echo "<p class='card-text'><strong>Allergy:</strong> {$row['allergy']}</p>";
                echo "<p class='card-text'><strong>Blood Group:</strong> {$row['blood_group']}</p>";
                echo "<p class='card-text'><strong>User ID:</strong> {$row['userid']}</p>";
                echo "<p class='card-text'><strong>Password:</strong> {$row['password']}</p>";
                echo "<p class='card-text'><strong>Added By:</strong> {$row['created_by']}</p>";
                echo "<div class='d-none edit-btn'><a href='edit_student.php?id={$row['id']}' class='btn btn-primary'>Edit</a></div>";
                echo "<div class='d-none edit-btn'><a href='delete_student.php?id={$row['id']}' class='btn btn-danger'>Delete</a></div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
