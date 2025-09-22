<?php
session_start();

// Unauthorized users ko redirect karo
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$alert = FALSE;
$alertContent = '';
require_once '../db.php'; // Sahi path mein database connection file ko include karo

$CoachingId = isset($_COOKIE['CoachingId']) ? $_COOKIE['CoachingId'] : '';

// Current month aur year fetch karo
$month = date('m');
$year = date('Y');

// Form submit hua hai ya nahi check karo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form submission handle karo
    if (isset($_POST['class']) && isset($_POST['date']) && !empty($_POST['class']) && !empty($_POST['date'])) {
        $selected_class = $_POST['class'];
        $selected_date = $_POST['date'];

        // Selected class ke basis par students fetch karo
        $student_query = "SELECT * FROM students WHERE class = '$selected_class' AND CoachingId = $CoachingId";
        $student_result = mysqli_query($conn, $student_query);

        if (!$student_result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            // Attendance form display karo
            echo "<div class='container'>";
            echo "<h2>Manage Attendance</h2>";
            echo "<h3>Attendance for $selected_class - Date: $selected_date</h3>";
            echo "<form method='post'>";
            echo "<table class='table'>";
            echo "<thead><tr><th>Student Name</th><th>Attendance</th></tr></thead>";
            echo "<tbody>";
            while ($student = mysqli_fetch_assoc($student_result)) {
                $userid = $student['userid']; // Students table se userid fetch karo
                echo "<tr>";
                echo "<td>{$student['full_name']}</td>";
                echo "<td>";
                // Check karo ki student ki attendance available hai ya nahi
                $attendance_query = "SELECT present FROM attendance WHERE userid = '$userid' AND date = '$selected_date'";
                $attendance_result = mysqli_query($conn, $attendance_query);
                $attendance_data = mysqli_fetch_assoc($attendance_result);
                if ($attendance_data && $attendance_data['present'] == 1) {
                    echo "<input type='checkbox' name='attendance[$userid]' value='1' checked> Present";
                } else {
                    echo "<input type='checkbox' name='attendance[$userid]' value='1'> Present";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "<button type='submit' class='btn btn-primary'>Save Attendance</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<div class='container'>";
        echo "<div class='alert alert-danger' role='alert'>Please select class and date.</div>";
        echo "</div>";
    }

    // Check karo ki form se submit ki gayi attendance data hai ya nahi
    if (isset($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $userid => $attendance_value) {
            $attendance_value = isset($attendance_value) ? 1 : 0; // Checkbox value ko 1 ya 0 mein convert karo
            $attendance_query = "INSERT INTO attendance (userid, date, present) VALUES ('$userid', '$selected_date', '$attendance_value') ON DUPLICATE KEY UPDATE present = VALUES(present)";
            $result = mysqli_query($conn, $attendance_query);
            if (!$result) {
                echo "<div class='container'>";
                echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($conn) . "</div>";
                echo "</div>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/attendance.css">

    <style>
        /* Custom CSS styles yahan add karo */
        body {
            background-color: #f8f9fa;
            /* Light gray background */
        }

        .container {
            margin-top: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
        color: #007bff;
        /* Blue color for headings */
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        /* Blue color for primary button */
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Darker blue color on hover */
        border-color: #0056b3;
    }

    table {
        background-color: #fff;
        /* White background for tables */
    }

    th,
    td {
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #007bff;
        /* Blue background for table headers */
        color: #fff;
        /* White color for table header text */
    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
        /* Light gray background for even rows */
    }

    input[type="checkbox"] {
        transform: scale(1.5);
        /* Increase checkbox size */
    }

    .red-tick {
        color: red;
        /* Red color for tick */
    }

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
    <?php
    require 'navbar.php';

    require_once '../db.php'; // Sahi path mein database connection file ko include karo

// Current month aur year fetch karo
$month = date('m');
$year = date('Y');

// Database se classes fetch karo
$class_query = "SELECT DISTINCT class FROM students WHERE CoachingId = $CoachingId";
$class_result = mysqli_query($conn, $class_query);
?>

<div class="container">
<h2>Select Class and Date</h2>
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
<div class="form-group">
<label for="date">Select Date</label>
<input type="date" class="form-control" id="date" name="date" required>
</div>
<button type="submit" class="btn btn-primary">Show Attendance</button>
</form>
</div>
<?php
// Database connection ko close karo
mysqli_close($conn);
?>
<script src="js/canva.js"></script>
<script src="js/attendance.js"></script>
</body>
</html>
