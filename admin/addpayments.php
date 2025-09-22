<?php
session_start();

$alert = FALSE;
$alertContent = '';

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

$CoachingId = $_COOKIE['CoachingId'];
require '../db.php';

// Check if class is provided via GET request
if (isset($_GET['class'])) {
    $class = $_GET['class'];

    // Fetch students based on the selected class
    $sql = "SELECT * FROM students WHERE class = '$class' AND CoachingId = '$CoachingId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Return the student data as JSON
        echo json_encode($students);
    } else {
        // Handle errors
        echo json_encode(['error' => 'Failed to fetch students']);
    }
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class = $_POST["class"];
    $student_name = $_POST["student_name"]; // Assuming this is the user_id from the students table
    $month = $_POST["month"];
    $subject = $_POST["subject"];
    $amount = $_POST["amount"];
    $receiver = $_POST['receiver'];
    $CoachingId = $_POST['CoachingId'];


    $sql = "INSERT INTO `payments` (`class`, `student_name`, `month`, `subject`, `amount`, `receiver`, `CoachingId`) VALUES ('$class', '$student_name', '$month', '$subject', '$amount', '$receiver', '$CoachingId')";


    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Payment data inserted successfully
        // Redirect or show success message
        echo "Added Successfull";

        header("Location: generate_pdf.php?class=$class&student_userid=$student_name&month=$month&subject=$subject&amount=$amount&receiver=$receiver");
        exit();
    } else {
        // Error handling
        $alert = TRUE;
        $alertContent = "Error: " . mysqli_error($conn);
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch distinct classes from database
$sql = "SELECT DISTINCT class FROM students WHERE CoachingId = '$CoachingId'";
$result = mysqli_query($conn, $sql);
$classes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch logged-in user's name
$uname = $_SESSION["admin_username"];

$sql = "SELECT `name` FROM `owners` WHERE `username` = '$uname'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $sendername = $row["name"];
} else {
    $alert = TRUE;
    $strong = "Can't Get Your Details!";
    $message = "Please Contact Developer...";
    // Constructing the success alert content
    $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
    $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    $alertContent .= '</div>';
    echo $alertContent;
    // After 4 seconds, redirect to admin panel
    echo "<script>setTimeout(function() { window.location.href = '../index.php'; }, 2000);</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/attendence.css">
    <title>Add Fee Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            top: 14%;
            position: absolute;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: auto;
        }
        .container form{
            margin: auto;    
            justify-content: center;
            align-items: center
        }

        .d-none {
            display: none;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input {
            width: calc(100% - 22px);
            /* Adjust for padding and border */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .paymentbtn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
        }
        

        .paymentbtn:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }
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
    <canvas id="canvas"></canvas>
    <div class="container">
        <h1>Add Fee Payment</h1>
        <form method="POST" action="generate_pdf.php">
            <div class="mb-3">
                <label for="class">Select Class:</label>
                <select id="class" name="class" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class) : ?>
                        <option value="<?php echo $class['class']; ?>"><?php echo $class['class']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="student">Select Student:</label>
                <select id="student" name="student" required>
                    <option value="">Select Class First</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="month">Month:</label>
                <select id="month" name="month" required>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="subject">Subject:</label>
                <select id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                    <option value="Maths">Maths</option>
                    <option value="Science">Science</option>
                    <option value="English">English</option>
                    <option value="Computer">Computer</option>
                    <option value="SST">SST</option>
                    <option value="English Spoken">English Spoken</option>
                    <!-- Add more subjects as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="receiver">Receiver:</label>
                <input type="text" id="receiver" name="receiver" value="<?php echo $uname; ?>" readonly required>
            </div>
            <input type="text" id="CoachingId" name="CoachingId" value="<?php echo $CoachingId; ?>" readonly required>
            <button class="paymentbtn" type="submit">Add Payment</button>
        </form>
    </div>

    <script src="js/canva.js"></script>
    <script>
        document.getElementById('class').addEventListener('change', function() {
            var classSelected = this.value;
            var studentSelect = document.getElementById('student');
            // Clear previous options
            studentSelect.innerHTML = '<option value="">Select Student</option>';
            // Fetch students based on selected class
            fetch('?class=' + classSelected)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    data.forEach(student => {
                        var option = document.createElement('option');
                        option.value = student.id;
                        option.textContent = student.full_name;
                        studentSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching students:', error);
                    alert('Error fetching students. Please try again later.');
                });
        });
    </script>
    </body>

</html>