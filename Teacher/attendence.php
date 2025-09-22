<?php
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

$CoachingId = $_COOKIE['CoachingId'];

require_once '../db.php'; // Include the database connection file with the correct path

// Fetch the current month and year
$month = date('m');
$year = date('Y');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    // Check if the 'attendance' post variable is set before looping through it
    if (isset($_POST['attendance'])) {
        // Loop through the attendance data submitted via the form
        foreach ($_POST['attendance'] as $userid => $attendance_array) {
            foreach ($attendance_array as $day => $present) {
                // Insert or update an attendance record in the database
                $date = date('Y-m-d', strtotime("$year-$month-$day"));
                $present = isset($present) ? 1 : 0; // Convert checkbox value to 1 or 0
                $attendance_query = "INSERT INTO attendance (userid, date, present) VALUES ('$userid', '$date', '$present') ON DUPLICATE KEY UPDATE present = VALUES(present)";
                mysqli_query($conn, $attendance_query);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/attendance.css">
    
    <style>
        /* Add your custom CSS styles here */
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        .container {
            margin-top: 50px;
            background-color: #fff; /* White background for container */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for container */
            animation: fadeIn 0.5s ease; /* Fade-in animation */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h2 {
            color: #007bff; /* Blue color for headings */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff; /* Blue color for primary button */
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue color on hover */
            border-color: #0056b3;
        }

        table {
            background-color: #fff; /* White background for tables */
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff; /* Blue background for table headers */
            color: #fff; /* White color for table header text */
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray background for even rows */
        }

        input[type="checkbox"] {
            transform: scale(1.5); /* Increase checkbox size */
        }

        .blue-tick {
            color: #007bff; /* Blue color for tick */
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
    <?php
    require 'navbar.php';
    
    require_once '../db.php'; // Include the database connection file with the correct path

    // Fetch the current month and year
    $month = date('m');
    $year = date('Y');

    // Fetching classes from the database
    $class_query = "SELECT DISTINCT class FROM students WHERE CoachingId = $CoachingId";
    $class_result = mysqli_query($conn, $class_query);
    ?>
<canvas id="canvas"></canvas>

    <div class="container">
        <h2>Attendance Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="class">Select Class</label>
                <select class="form-select" id="class" name="class" required>
                    <option value="">Select Class</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($class_result)) {
                        echo "<option value='{$row['class']}'>{$row['class']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Show Class</button>
        </form>

        <?php
        // Display students and attendance form if class is selected
        if (isset($_POST['class']) && !empty($_POST['class'])) {
            $selected_class = $_POST['class'];

            // Fetch students based on the selected class
            $student_query = "SELECT * FROM students WHERE class = '$selected_class' AND CoachingId = '$CoachingId'";
            $student_result = mysqli_query($conn, $student_query);

            if (!$student_result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                echo "<h3>Attendance for $selected_class</h3>";
                echo "<form method='post'>";
                echo "<table class='table'>";
                echo "<thead><tr><th>Student Name</th>";
                // Dynamically generate date columns for the current month
                $days_in_month = date('t', strtotime("$year-$month-01"));
                for ($i = 1; $i <= $days_in_month; $i++) {
                    echo "<th>$i</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                while ($student = mysqli_fetch_assoc($student_result)) {
                    $userid = $student['userid']; // Fetching the userid from the students table
                    echo "<tr>";
                    echo "<td>{$student['full_name']}</td>";
                    for ($day = 1; $day <= $days_in_month; $day++) {
                        $date = date('Y-m-d', strtotime("$year-$month-$day"));
                        $attendance_query = "SELECT present FROM attendance WHERE userid = '$userid' AND date = '$date'";
                        $attendance_result = mysqli_query($conn, $attendance_query);
                        $attendance_data = mysqli_fetch_assoc($attendance_result);

                        // Check if attendance data exists for the current day
                        $checked = '';
                        if ($attendance_data && $attendance_data['present'] == 1) {
                            // If the student is present, mark the checkbox with a blue tick
                            $checked = 'checked';
                        }

                        echo "<td><input type='checkbox' name='attendance[{$student['userid']}][$day]' value='1' $checked></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "<button type='submit' class='btn btn-primary'>Save Attendance</button>";
                echo "</form>";
            }
        }
        ?>
    </div>

    <?php
    // Close database connection
    mysqli_close($conn);
    ?>
    <script src="js/canva.js"></script>

    <script src="js/attendance.js"></script>
</body>

</html>
