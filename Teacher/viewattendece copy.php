<?php
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <?php
    require 'navbar.php';
    require_once '../db.php'; // Include the database connection file with the correct path

    // Fetch classes from the database
    $class_query = "SELECT DISTINCT class FROM students";
    $class_result = mysqli_query($conn, $class_query);
    ?>

    <div class="container fade-in">
        <h2>View Attendance</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                <label for="month">Select Month</label>
                <input type="month" id="month" name="month" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">View Attendance</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission to view attendance
            $selected_class = $_POST['class'];
            $selected_month = $_POST['month'];

            // Convert selected month to year-month format (YYYY-MM)
            $year_month = date('Y-m', strtotime($selected_month));

            // Fetch students of the selected class from the database
            $students_query = "SELECT * FROM students WHERE class = '$selected_class'";
            $students_result = mysqli_query($conn, $students_query);

            if (!$students_result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                echo "<h3>Attendance for $selected_class - $year_month</h3>";
                echo "<form method='post' action='{$_SERVER['PHP_SELF']}'>";
                echo "<input type='hidden' name='class' value='$selected_class'>";
                echo "<input type='hidden' name='month' value='$year_month'>";
                echo "<table class='table'>";
                echo "<thead><tr><th>Student Name</th>";
                $days_in_month = date('t', strtotime($selected_month));
                for ($day = 1; $day <= $days_in_month; $day++) {
                    echo "<th>$day</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                while ($student = mysqli_fetch_assoc($students_result)) {
                    $student_id = $student['id'];
                    $student_name = $student['full_name'];
                    echo "<tr><td>$student_name</td>";
                    for ($day = 1; $day <= $days_in_month; $day++) {
                        $date = date('Y-m-d', strtotime("$year_month-$day"));
                        $attendance_query = "SELECT present FROM attendance WHERE student_id = '$student_id' AND date = '$date'";
                        $attendance_result = mysqli_query($conn, $attendance_query);
                        $attendance_data = mysqli_fetch_assoc($attendance_result);
                        $checked = ($attendance_data && $attendance_data['present'] == 1) ? 'checked' : '';
                        echo "<td><input type='checkbox' name='attendance[$student_id][$day]' $checked></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<button type='submit' class='btn btn-primary'>Save Attendance</button>";
                echo "</form>";
            }
        }
        ?>
    </div>

    <script src="js/attendance.js"></script>
</body>

</html>
