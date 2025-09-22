<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';

// Initialize variables
$id = $name = $phone_number = $aadhar_number = $email = $class = $role = $students_id = "";

// Check if students ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: viewstudents.php");
    exit();
}

$students_id = $_GET['id'];

// Fetch students details using provided ID
$sql = "SELECT * FROM students WHERE `id` = $students_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Redirect to view studentss page if students with given ID is not found
    header("Location: viewstudents.php");
    exit();
}

$students = mysqli_fetch_assoc($result);

// Check if form is submitted for updating students details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated details from the form
    $fullname = $_POST['full_name'];
    $class = $_POST['class'];
    $fathername = $_POST['father_name'];
    $mothername = $_POST['mother_name'];
    $school = $_POST['school'];
    $category = $_POST['category']; // New field
    $roll_no = $_POST['roll_no']; // New field
    $subject = $_POST['subject'];
    $aadharNumber = $_POST['aadhar_number'];
    $phonenumber = $_POST['phone_number'];
    $alternatenumber = $_POST['alternate_number'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $bloodGroup = $_POST['blood_group'];
    $allergy = $_POST['allergy'];
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $created_by = $_POST['created_by'];

    // Update students details in the database
    $update_query = "UPDATE studentss SET name='$name', phone_number='$phone_number', aadhar_number='$aadhar_number', email='$email', class='$class', role='$role', students_id='$students_id' WHERE id=$students_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Redirect to view studentss page after successful update
        header("Location: viewstudents.php?success=1");
        exit();
    } else {
        $error_message = "Failed to update students details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'navbar.php'; ?>
<main>
    <div class="container admin-container">
        <h1 class="text-strong">Edit Students</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" value="<?php $full_name ?>" name="full_name" required>
        </div>
        <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <select class="form-select" id="class" name="class" required>
                <option value="">Select Class</option>
                        <option value="1">Kg</option>
                        <option value="2">LKG</option>
                        <option value="3">UKG</option>
                        <option value="4">Class 1</option>
                        <option value="5">Class 2</option>
                        <option value="6">Class 3</option>
                        <option value="8">Class 4</option>
                        <option value="9">Class 5</option>
                        <option value="10">Class 6</option>
                        <option value="11">Class 7</option>
                        <option value="12">Class 8</option>
                        <option value="13">Class 9</option>
                        <option value="14">Class 10</option>
                        <option value="15">Class 11</option>
                        <option value="16">Class 12</option>
                    </select>
            </div>        
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="School">School</option>
                    <option value="Coaching">Coaching</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="roll_no" class="form-label">Roll no</label>
            <input type="text" class="form-control" id="roll_no" value="<?php $roll_no ?>" name="roll_no" required>
        </div>
            <div class="mb-3">
            <label for="fathername" class="form-label">Father Name</label>
            <input type="text" class="form-control" id="fathername" value="<?php $father_name ?>" name="father_name" required>
        </div>
        <div class="mb-3">
            <label for="mothername" class="form-label">Mother Name</label>
            <input type="text" class="form-control" value="<?php $mother_name ?>" id="mothername" name="mother_name" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>

        <div class="mb-3">
            <label for="alternatenumber" class="form-label">Alternate Phone Number</label>
            <input type="text" class="form-control" id="alternate_number" name="alternate_number">
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
            echo $_SESSION['admin_username'];
            ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Update students</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
