<?php
require '../../db.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <h1>Announcements</h1>
        <div class="announcement-container">
            <?php
            $userid = $_SESSION['userid'];
            $sql = "SELECT `class` FROM `students` WHERE `userid` = $userid";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Something Went Wrong";
            } else {
                // Extract class information from the result
                $row = mysqli_fetch_assoc($result);
                $class = $row['class'];
                $sql = "SELECT * FROM `announcement` WHERE `message_for` = '$class'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each announcement
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="announcement">';
                        echo '<center class="bg-primary text-white">For Classes</center>';
                        echo '<h2> Seriol No - ' . htmlspecialchars($row['sno']) . '</h2>';
                        echo '<h2> Topic - ' . htmlspecialchars($row['topic']) . '</h2>';
                        echo '<h2> Message - ' . htmlspecialchars($row['message']) . '</h2>';
                        echo '<h2> Note: ' . htmlspecialchars($row['highlight']) . '</h2>';
                        echo '<h2> Sender - ' . htmlspecialchars($row['sent_by']) . '</h2>';
                        echo '<span class="timestamp">Posted on ' . date('F j, Y', strtotime($row['sent_at'])) . '</span>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No announcements available for your class.</p>';
                }
            }
            $sql = "SELECT * FROM `announcement` WHERE `message_for` = 'Every Class'";
            $result = mysqli_query($conn, $sql);
            
            // Check if there are any announcements
            if (mysqli_num_rows($result) > 0) {
                // Loop through each announcement
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="announcement">';
                    echo '<center class="bg-danger text-white">For Everyone</center>';
                    echo '<h2> Seriol No - ' . htmlspecialchars($row['sno']) . '</h2>';
                    echo '<h2> Topic - ' . htmlspecialchars($row['topic']) . '</h2>';
                    echo '<h2> Message - ' . htmlspecialchars($row['message']) . '</h2>';
                    echo '<h2> Note: ' . htmlspecialchars($row['highlight']) . '</h2>';
                    echo '<h2> Sender - ' . htmlspecialchars($row['sent_by']) . '</h2>';
                    echo '<span class="timestamp">Posted on ' . date('F j, Y', strtotime($row['sent_at'])) . '</span>';
                    echo '</div>';
                }
            } else {
                echo '<p>No announcements available.</p>';
            }
            ?>
        </div>
    </div>
</body>
<script src="index.js"></script>
</html>
