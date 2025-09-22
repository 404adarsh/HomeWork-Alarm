<?php

$alert = FALSE;
$alertContent = '';


require 'db.php';
session_start(); // Start the session

// Check if the admin is logged in, redirect them to their destination page
if (isset($_SESSION['admin_username'])) {
    header("Location: admin/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}
elseif (isset($_SESSION['userid'])) {
    header("Location: student/Coaching/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}
elseif (isset($_SESSION['teacher_id'])) {
    header("Location: Teacher/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $class = $_POST['class'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $education = $_POST['education'];


    $sql = "INSERT INTO `enrolledstudent` (`name`, `class`, `mobile`, `email`, `education`, `subject`) VALUES ('$name', '$class', '$mobile','$email', '$subject', '$education');";

    $result = mysqli_query($conn, $sql);

    if($result){
        $alert = TRUE;  
        $strong = "Sent Successfull! ";
        $message = "We'll Contact You Soon...";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        // After 4 seconds, redirect to admin panel
        echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 4000);</script>";
        
    }
}


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/enroll.css">
</head>
<body>

<?php require 'singleNavbar.php'; 

//   <!-- Display the success message if the form was submitted successfully -->
   if ($alert) echo $alertContent; 

?>

<!-- New section for enrollment options -->
<div class="enrollment-options">
    <div class="container">
        <h3>Enrollment Options</h3>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary" onclick="toggleEnrollmentForm('coaching')">Coaching</button>
            </div>
            <div class="col">
                <button class="btn btn-primary" onclick="toggleEnrollmentForm('school')">School</button>
            </div>
        </div>
    </div>
</div>

<main>
    <!-- Enrollment form -->
    <div id="enrollmentForm" class="container enroll-form my-3">
        <!-- Default content -->
        <div id="defaultContent">
            <p class="font-bold">Please Select Coaching Or School To Enroll.</p>
        </div>

        <!-- Coaching form content -->
        <div id="coachingContent" style="display: none;">
                <h3 class="text-center" >Coaching Enrollment Form</h3>
                <form method="POST" action="enroll.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <select id="class" name="class" required>
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
            <div class="form-group">
                <label for="mobile">Phone Number</label>
                <input type="mobile" id="mobile" name="mobile" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                    <option value="maths">Maths</option>
                    <option value="science">Science</option>
                    <option value="computer">Computer</option>
                    <option value="english">English</option>
                    <option value="englishSpoken">English Spoken</option>
                    <option value="accounts">Accounts</option>
                    <option value="advanceComputer" onmouseover="showComputerOptions()" onclick="showComputerOptions()">Advance Computer</option>
                </select>
            </div>


            <div id="computerOptions" style="display: none;">
                <label for="computer">Advanced Computer Topics</label>
                <select id="computer" name="computerselect">
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP</option>
                    <option value="python">Python</option>
                    <option value="c">C</option>
                    <option value="mysql">MySQL</option>
                    <option value="reactjs">React.js</option>
                    <option value="nodejs">Node.js</option>
                    <option value="fullStack">Full Stack Web Development</option>
                    <option value="excel">Excel</option>
                    <option value="tally">Tally</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" value="For Coaching" name="education" readonly >
            </div>
            <button type="submit" class="btn btn-primary">Enroll Now</button>
        </form>
        </div>





























        <!-- School form content -->
        <div id="schoolContent" style="display: none;">
        <h2 class="text-center">School Enrollment Form</h2>
            <div class="container enroll-form my-3">
        <form method="post" action="enroll.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <select id="class" name="class" required>
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
            <div class="form-group">
                <label for="mobile">Phone Number</label>
                <input type="mobile" id="mobile" name="mobile" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
            <input type="text" value="Null" name="subject" readonly style="display: none;">
            </div>
            <div class="form-group">
                <input type="text" value="For School" name="education" readonly >
            </div>
            <button type="submit" class="btn btn-primary my-3">Enroll Now</button>
        </form>
        </div>
    </div>
</main>

<script>
    function toggleEnrollmentForm(option) {
        var defaultContent = document.getElementById('defaultContent');
        var coachingContent = document.getElementById('coachingContent');
        var schoolContent = document.getElementById('schoolContent');
        
        // Hide all content by default
        defaultContent.style.display = 'none';
        coachingContent.style.display = 'none';
        schoolContent.style.display = 'none';
        
        // Check the selected option and display the corresponding content
        if (option === 'coaching') {
            coachingContent.style.display = 'block';
        } else if (option === 'school') {
            schoolContent.style.display = 'block';
        }
    }
</script>
<script src="js/index.js"></script>
</body>
</html>
