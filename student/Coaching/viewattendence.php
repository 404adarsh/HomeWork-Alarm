<?php
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['userid'])) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../db.php'; // Include the database connection file with the correct path

$userid = $_SESSION['userid']; // Get the student's ID from the session

// Fetch the current month and year
$month = date('m');
$year = date('Y');

// Get the number of days in the current month
$days_in_month = date('t', strtotime("$year-$month-01"));

// Initialize an empty array to store attendance data for each day
$attendance_data = [];

// Fetch attendance data for each day of the month
for ($day = 1; $day <= $days_in_month; $day++) {
    $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT); // Format the date as YYYY-MM-DD

    // Fetch attendance data for the current day
    $attendance_query = "SELECT present FROM attendance WHERE userid = '$userid' AND date = '$date'";
    $attendance_result = mysqli_query($conn, $attendance_query);

    // If attendance data exists for the current day, store it in the attendance_data array
    if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
        $attendance_data[$date] = mysqli_fetch_assoc($attendance_result)['present'];
    } else {
        // If no attendance data exists for the current day, set it as absent (0)
        $attendance_data[$date] = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="style.css"/>
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
    <?php require 'navbar.php'; ?>
<div class="container fade-in">
        <h2>View Attendance</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Present</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each day of the month
                for ($day = 1; $day <= $days_in_month; $day++) {
                    $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT); // Format the date as YYYY-MM-DD
                    echo "<tr>";
                    echo "<td>$date</td>";
                    // Check if attendance data exists for the current day and display it accordingly
                    echo "<td>" . ($attendance_data[$date] ? 'Present' : 'Absent') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="index.js"></script>
</html>
