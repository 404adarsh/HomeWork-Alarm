<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit(); 
}

require '../db.php';
$CoachingId = $_COOKIE['CoachingId'];

// Retrieve payments from the database
$sql = "SELECT * FROM payments WHERE CoachingId = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $CoachingId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if there are any payments
if (mysqli_num_rows($result) > 0) {
    $payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $payments = [];
}

// Handle search functionality
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify the SQL query to search for payments with the given name, class, or month
    $searchTerm = "%$search%";
    $sql = "SELECT * FROM payments WHERE CoachingId = ? AND (student_name LIKE ? OR class LIKE ? OR month LIKE ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $CoachingId, $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $payments = []; // Reset payments if no results found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link rel="stylesheet" href="css/viewpayments.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <canvas id="canvas"></canvas>

    <div class="container">
        <h2 class="my-4">View Payments</h2>
        <!-- Add a search form -->
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search by name, class, or month" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
            </div>
        </form>
        <?php if (!empty($payments)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Student Name</th>
                        <th>Month</th>
                        <th>Subject</th>
                        <th>Amount</th>
                        <th>Payment Done By</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['class']; ?></td>
                            <td><?php echo $payment['student_name']; ?></td>
                            <td><?php echo $payment['month']; ?></td>
                            <td><?php echo $payment['subject']; ?></td>
                            <td><?php echo $payment['amount']; ?></td>
                            <td><?php echo $payment['receiver']; ?></td>
                            <td><?php echo $payment['payment_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No payments found.</p>
        <?php endif; ?>
    </div>
</body>
<script src="js/canva.js"></script>
</html>
