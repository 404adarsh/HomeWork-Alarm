<?php
session_start(); // Start the session

// Check if the admin is not logged in, redirect them to the login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';

// Initialize variables to store form data
$name = $phone_number = $aadhar_number = $email = $teacher_id = '';

// Fetch Coaching Id from the cookie if it's set
$CoachingId = isset($_COOKIE['CoachingId']) ? $_COOKIE['CoachingId'] : '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $aadhar_number = $_POST['aadhar_number'];
    $email = $_POST['email'];
    $CoachingId = $_POST['CoachingId'];
    $teacher_id = $_POST['teacher_id'];
    $password = $_POST['password']; // Note: Password should be hashed before storing in the database (not implemented here for simplicity)

    // Check if password length is greater than 8 characters
    if (strlen($password) > 8) {
        // Prepare and execute the SQL statement to insert data into the database
        $sql = "INSERT INTO teachers (`name`, `phone_number`, `aadhar_number`, `email`, `CoachingId`, `teacher_id`, `password`) 
                VALUES ('$name', '$phone_number', '$aadhar_number', '$email', '$CoachingId', '$teacher_id', '$password')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<div class="alert alert-success" role="alert">Teacher added successfully!</div>';
            // Clear form data after successful submission
            $name = $phone_number = $aadhar_number = $email = $teacher_id = '';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to add teacher. Please try again.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Password must be at least 8 characters long.</div>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            /* Prevent canvas from intercepting mouse events */
        }
    </style>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <canvas id="canvas"></canvas>

    <main class="container">
        <h1 class="text-strong">Add Teacher</h1>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="aadhar_number" class="form-label">Aadhar Number</label>
                <input type="text" class="form-control" id="aadhar_number" name="aadhar_number">
            </div>
            <input type="hidden" id="CoachingId" name="CoachingId" value="<?php echo $CoachingId; ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher ID</label>
                <input type="text" class="form-control" id="teacher_id" name="teacher_id" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Teacher</button>
        </form>
    </main>
    <script src="js/canva.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
