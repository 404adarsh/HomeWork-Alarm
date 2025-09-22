<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit(); 
}

require '../../db.php';

// Retrieve fee details of the logged-in student from the database
$student_id = $_SESSION['userid'];

// Fetch the class of the logged-in student from the database
$asql = "SELECT `class` FROM students WHERE `userid` = '$student_id'";
$aresult = mysqli_query($conn, $asql);

// Check if the query was successful
if ($aresult) {
    // Fetch the row from the result set
    $row = mysqli_fetch_assoc($aresult);
    // Extract the class from the row
    $class = $row['class'];
} else {
    // Handle errors if the query fails
    echo "Error fetching class: " . mysqli_error($conn);
}

// GEtting Student Name
$bsql = "SELECT `full_name` FROM `students` WHERE `userid` = '$student_id'";
$bresult = mysqli_query($conn, $bsql);

// Check if the query was successful
if ($bresult) {
    // Fetch the row from the result set
    $row = mysqli_fetch_assoc($bresult);
    // Extract the full name from the row
    $student_name = $row['full_name'];
} else {
    // Handle errors if the query fails
    echo "Error fetching student name: " . mysqli_error($conn);
}

// Retrieve fee details based on student name and class
$sql = "SELECT * FROM `payments` WHERE `student_name` = '$student_name' AND `class` = '$class'";
$result = mysqli_query($conn, $sql);

// Check if there are any fee details
if ($result && mysqli_num_rows($result) > 0) {
    $fee_details = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $fee_details = [];
    echo "No fee details found for this student.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>My Fee Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>My Fee Details</h2>
        <?php 
        // Display the class and student name if needed
        echo "<p>Class: $class</p>";
        echo "<p>Student Name: $student_name</p>";
        ?>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Subject</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Download PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fee_details as $fee): ?>
                    <tr>
                        <td><?php echo $fee['month']; ?></td>
                        <td><?php echo $fee['subject']; ?></td>
                        <td><?php echo $fee['amount']; ?></td>
                        <td><?php echo $fee['payment_date']; ?></td>
                        <td><a href="download_fee_pdf.php?payment_id=<?php echo $fee['id']; ?>">Download</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<script src="index.js"></script>
</html>
