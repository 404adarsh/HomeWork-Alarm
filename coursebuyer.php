<?php

session_start();
if (isset($_SESSION["username"])) {
    $login = true;
} else {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacker Theme - Course Buyers</title>
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            color: #0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #0f0;
            background-color: #222;
            color: #0f0;
        }

        input[type="submit"] {
            background-color: #0f0;
            color: #000;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #090;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #0f0;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0f0;
        }

        tr:nth-child(even) {
            background-color: #222;
        }

        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0f0;
            color: #000;
            text-decoration: none;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .download-btn:hover {
            background-color: #090;
        }
    </style>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <h2>Welcome, Hacker! Course Buyers Details:</h2>
        <form method="post">
            <input type="text" name="search_query" placeholder="Search by Name, Email, Phone, Address, or Order ID">
            <input type="submit" value="Search">
        </form>
        <br>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Amount</th>
                <th>Address</th>
                <th>Password</th>
                <th>Order ID</th>
                <th>Ip Address</th>
                <th>Datetime</th>
            </tr>
            <?php
            $conn = new mysqli("localhost", "u200853583_luckysite", "Hiluckysite@10100", "u200853583_mysite");
            require '../db.php'; // Database connection file
            
            // Check if form submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize search query
                $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);

                // Fetch data based on search query
                $sql = "SELECT * FROM coursebuyer WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR phone LIKE '%$search_query%' OR address LIKE '%$search_query%' OR order_id LIKE '%$search_query%'";
                $result = mysqli_query($conn, $sql);

                // Check if there are any records
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>";
                        echo "<td>" . $row["order_id"] . "</td>";
                        echo "<td>" . $row["ip_address"] . "</td>";
                        echo "<td>" . $row["datetime"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found.</td></tr>";
                }
            } else {
                // Fetch all data from the 'coursebuyer' table
                $sql = "SELECT * FROM coursebuyer";
                $result = mysqli_query($conn, $sql);

                // Check if there are any records
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>";
                        echo "<td>" . $row["order_id"] . "</td>";
                        echo "<td>" . $row["ip_address"] . "</td>";
                        echo "<td>" . $row["datetime"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found.</td></tr>";
                }
            }

            // Close database connection
            mysqli_close($conn);

            ?>
        </table>
    </div>
    <a href="download.php" class="download-btn">Download All Data as CSV</a>

</body>

</html>     