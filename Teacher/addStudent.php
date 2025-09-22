<?php

session_start();

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

$alert = FALSE;
$alertContent = '';

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userid = $_POST['userid'];

    $check_stmt = $conn->prepare("SELECT userid FROM students WHERE userid = ?");
    $check_stmt->bind_param("s", $userid);
    $check_stmt->execute();

    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // User ID already exists, display error message
        $alert = TRUE;
        $strong = "User ID Already Exists!";
        $message = "Please Choose A Different One...";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        // After 2 seconds, redirect to teacher panel
        echo "<script>setTimeout(function() { window.location.href = '../Teacher/addStudent.php'; }, 2000);</script>";

    } else {
        // User ID does not exist, proceed with inserting the new record
        $fullname = $_POST['full_name'];
        $class = $_POST['class'];
        $fathername = $_POST['father_name'];
        $mothername = $_POST['mother_name'];
        $school = $_POST['school'];
        $subject = $_POST['subject'];
        $aadharNumber = $_POST['aadhar_number'];
        $phonenumber = $_POST['phone_number'];
        $alternatenumber = $_POST['alternate_number'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $bloodGroup = $_POST['blood_group'];
        $allergy = $_POST['allergy'];
        $password = $_POST['password'];
        $created_by = $_SESSION['teacher_id'];

        $insert_stmt = $conn->prepare("INSERT INTO `students` (`full_name`, `class`, `father_name`, `mother_name`, `school`, `subject`, `aadhar_number`, `phone_number`, `alternate_number`, `address`, `state`, `city`, `allergy`, `blood_group`, `userid`, `password`, `created_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssssssssssssssss", $fullname, $class, $fathername, $mothername, $school, $subject, $aadharNumber, $phonenumber, $alternatenumber, $address, $state, $city, $allergy, $bloodGroup, $userid, $password, $created_by);
        $insert_stmt->execute();

        if ($insert_stmt->affected_rows > 0) {
            $alert = TRUE;
            $strong = "Added Successfully!";
            $message = "Refreshing The Page...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            // After 2 seconds, redirect to teacher panel
            echo "<script>setTimeout(function() { window.location.href = '../Teacher/addStudent.php'; }, 2000);</script>";

        } else {
            echo "Something Went Wrong: " . $conn->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}

?>  


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Add Student</title>
    <style>
       canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Prevent canvas from intercepting mouse events */
        }
    </style>
</head>
<body>

<?php require 'navbar.php'; ?>
<canvas id="canvas" style="position: absolute; top: 0; left: 0; pointer-events: none;"></canvas>

<div class="container my-5">
    <h2>Add Student</h2>
    <form action="addStudent.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class</label>
            <select class="form-select" id="class" name="class" required>
                <option value="">Select Class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
                <option value="Class 3">Class 3</option>
                <option value="Class 4">Class 4</option>
                <option value="Class 5">Class 5</option>
                <option value="Class 6">Class 6</option>
                <option value="Class 7">Class 7</option>
                <option value="Class 8">Class 8</option>
                <option value="Class 9">Class 9</option>
                <option value="Class 10">Class 10</option>
                <option value="Class 11">Class 11</option>
                <option value="Class 12">Class 12</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fathername" class="form-label">Father Name</label>
            <input type="text" class="form-control" id="fathername" name="father_name" required>
        </div>
        <div class="mb-3">
            <label for="mothername" class="form-label">Mother Name</label>
            <input type="text" class="form-control" id="mothername" name="mother_name" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input type="number" class="form-control" id="phone_number" name="phone_number" required>
        </div>

        <div class="mb-3">
            <label for="alternatenumber" class="form-label">Alternate Phone Number</label>
            <input type="number" class="form-control" id="alternate_number" name="alternate_number">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="school" class="form-label">School</label>
            <input type="text" class="form-control" id="school" name="school" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="mb-3">
            <label for="aadharNumber" class="form-label">Aadhar Number</label>
            <input type="text" class="form-control" id="aadhar_Number" name="aadhar_number" required>
        </div>
        <div class="mb-3">
            <label for="allergy" class="form-label">Allergy</label>
            <input type="text" class="form-control" id="allergy" name="allergy">
        </div>
        <div class="mb-3">
            <label for="bloodGroup" class="form-label">Blood Group</label>
            <input type="text" class="form-control" id="blood_group" name="blood_group" required>
        </div>
        <div class="mb-3">
            <label for="userid" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userid" name="userid" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3 d-none">
            <label for="creater" class="form-label">Creater</label>
            <input type="text" class="form-control" id="created_by" name="created_by" value="<?php
            echo $_SESSION['teacher_id'];
            ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>
<script src="js/canva.js"></script>
</body>
</html>
