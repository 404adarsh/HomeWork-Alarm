<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../Portal.php");
    exit(); 
}

require '../db.php';

// Retrieve payments from the database
$sql = "SELECT * FROM payments";
$result = mysqli_query($conn, $sql);

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
    $sql = "SELECT * FROM payments WHERE student_name LIKE '%$search%' OR class LIKE '%$search%' OR month LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
</head>
<body>
<?php require 'Navbar.php'; ?>

    <div class="container">
        <h2>View Payments</h2>
        <!-- Add a search form -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by name, class, or month">
            <button type="submit">Search</button>
        </form>
        <table>
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
    </div>
</body>
</html>
