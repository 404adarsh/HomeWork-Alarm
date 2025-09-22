<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}

$alert = FALSE;
$alertContent = '';

require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $school = $_POST['school'];
    $alternate_number = $_POST['alternate_number'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $aadharNumber = $_POST['aadhar_number'];
    $bloodgroup = $_POST['blood_group'];
    $allergy = $_POST['allergy'];
    $password = $_POST['password'];
    $studentupdated = $_POST['studentupdated'];
    // Assuming $userid is the ID of the student you want to update
    $userid = $_SESSION['userid']; // You need to define this variable

    $sql = "UPDATE `students` SET 
            `father_name` = '$father_name', 
            `mother_name` = '$mother_name', 
            `school` = '$school', 
            `alternate_number` = '$alternate_number', 
            `address` = '$address', 
            `state` = '$state', 
            `city` = '$city', 
            `aadhar_number` = '$aadharNumber', 
            `blood_group` = '$bloodgroup', 
            `allergy` = '$allergy', 
            `password` = '$password', 
            `studentupdated` = '$studentupdated' 
            WHERE `userid` = $userid"; // Assuming `student_id` is the primary key of your table



    $result = mysqli_query($conn, $sql);

    if ($result) {
        $alert = TRUE;
        $strong = "Updated Successful!";
        $message = "Refreshing the page to see the changes.";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'editStudentProfile.php'; }, 2000);</script>";
    } else {
        $alert = TRUE;
        $strong = "Updated Unsuccessful!";
        $message = "Please Contact The Developer.";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'editStudentProfile.php'; }, 2000);</script>";
    }
}

$userid = $_SESSION['userid'];

$sql = "SELECT * FROM `students` WHERE `userid` = $userid";

$result = mysqli_query($conn, $sql);

if ($result) {
    // echo "Aagya Bhai Tumhara Result";
    $row = mysqli_fetch_assoc($result);
    $fullname = $row['full_name'];
    $class = $row['class'];
    $fathername = $row['father_name'];
    $mothername = $row['mother_name'];
    $school = $row['school'];
    $subject = $row['subject'];
    $aadharNumber = $row['aadhar_number'];
    $phonenumber = $row['phone_number'];
    $alternatenumber = $row['alternate_number'];
    $address = $row['address'];
    $state = $row['state'];
    $city = $row['city'];
    $bloodGroup = $row['blood_group'];
    $allergy = $row['allergy'];
    $userid = $row['userid'];
    $password = $row['password'];
} else {
    echo 'Unaable TO Fetch Result';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php require 'navbar.php'; ?>
    <div class="container my-5">
        <h2 class="text-center py-2">Edit Your Profile Student</h2>
        <form method="POST">
        <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="full_name" value="<?php echo $fullname; ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="fathername" class="form-label">Father's Name</label>
                <input type="text" class="form-control" id="fathername" name="father_name" value="<?php echo $fathername; ?>" required>
            </div>
            <div class="mb-3">
                <label for="mothername" class="form-label">Mother's Name</label>
                <input type="text" class="form-control" id="mothername" name="mother_name" value="<?php echo $mothername; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phonenumber" name="phone_number" value="<?php echo $phonenumber; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="alternatenumber" class="form-label">Alternate Phone Number</label>
                <input type="text" class="form-control" id="alternatenumber" name="alternate_number" value="<?php echo $alternatenumber; ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
            </div>
            <div class="mb-3 d-none">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" readonly>
            </div>
            <div class="mb-3 d-none">
                <label for="roll_no" class="form-label">Roll Number</label>
                <input type="text" class="form-control" id="roll_no" name="roll_no" value="<?php echo $roll_no; ?>" readonly>
            </div>
            <div class="mb-3 d-none">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $subject; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
            </div>
            <div class="mb-3">
                <label for="aadharNumber" class="form-label">Aadhar Number</label>
                <input type="text" class="form-control" id="aadhar_Number" name="aadhar_number" value="<?php echo $aadharNumber; ?>" required>
            </div>
            <div class="mb-3">
                <label for="allergy" class="form-label">Allergy</label>
                <input type="text" class="form-control" id="allergy" name="allergy" value="<?php echo $allergy; ?>">
            </div>
            <div class="mb-3">
                <label for="bloodGroup" class="form-label">Blood Group</label>
                <input type="text" class="form-control" id="blood_group" name="blood_group" value="<?php echo $bloodGroup; ?>" required>
            </div>
            <div class="mb-3">
                <label for="userid" class="form-label">User Id</label>
                <input type="text" class="form-control" id="userid" name="userid" value="<?php echo $userid; ?>" required readonly>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
            </div>

            <div class="mb-3 d-none">
                <label for="password" class="form-label">Student Updated</label>
                <input type="text" class="form-control" id="studentupdated" name="studentupdated" value="Yes" required readonly>
            </div>
            <button type="submit" class="btn btn-primary">Update Your Data</button>
        </form>
    </div>
</body>
<script src="index.js"></script>
</html>
