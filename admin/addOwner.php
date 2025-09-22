<?php

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

require '../db.php';




if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Prepare and execute the SQL statement to insert data into the database
    $sql = "INSERT INTO owners (`username`, `password`, `phone_number`, `date_of_birth`, `name`, `age`, `gender`, `created_at`) 
            VALUES ('$username', '$password', '$phone_number', '$date_of_birth', '$name', '$age', '$gender', CURRENT_TIMESTAMP)";
    
    $result = mysqli_query($conn, $sql);

    if($result){
        echo 'Added Successfully';
    }
    else{
        echo 'Something went wrong';
    }
}
?>


<!-- add_owner.php -->
<!-- add_owner.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
    require 'navbar.php';
?>
    <div class="container">
        <h2 class="mt-5 mb-4">Add Owner</h2>
        <form  method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option selected disabled>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Owner</button>
        </form>
    </div>
</body>
</html>
