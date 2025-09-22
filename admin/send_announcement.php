<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$alert = FALSE;
$alertContent = '';

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['topic']) && isset($_POST['message_for']) && isset($_POST['message']) && isset($_POST['highlight']) && isset($_POST['sent_by'])) {
        $topic = mysqli_real_escape_string($conn, $_POST['topic']);
        $message_for = mysqli_real_escape_string($conn, $_POST['message_for']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $highlight = mysqli_real_escape_string($conn, $_POST['highlight']);
        $sent_by = mysqli_real_escape_string($conn, $_POST['sent_by']);

        $sql = "INSERT INTO `announcement`(`topic`, `message_for`, `message`, `highlight`, `sent_by`) VALUES ('$topic','$message_for','$message','$highlight', '$sent_by')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $alert = TRUE;
            $strong = "Sent Successful!";
            $message = "Refreshing The Page...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            // After 4 seconds, redirect to admin panel
            echo "<script>setTimeout(function() { window.location.href = '../admin/send_announcement.php'; }, 2000);</script>";
        } else {
            $alert = TRUE;
            $strong = "Sent Unsuccessful!";
            $message = "Please Contact Developer...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            // After 4 seconds, redirect to admin panel
            echo "<script>setTimeout(function() { window.location.href = 'admin/send_announcement.php'; }, 2000);</script>";
        }
    } else {
        // Handle the case when one or more POST variables are not set
        echo "Please fill out all the fields.";
    }
}

$uname = $_SESSION["admin_username"];

$sql = "SELECT `name` FROM `owners` WHERE `username` = '$uname'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $sendername = $row["name"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Send Announcement</title>
    <style>
       canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Prevent canvas from intercepting mouse events */
        }
    </style>
    <link rel="stylesheet" href="css/send_announcement.css">
</head>

<body>
    <?php require 'navbar.php';
    
    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['delete'])) {
        $announcement_id = mysqli_real_escape_string($conn, $_GET['delete']);
        $sql_delete = "DELETE FROM `announcement` WHERE `announcement`.`sno` = $announcement_id"; 
        $result_delete = mysqli_query($conn, $sql_delete);
        if ($result_delete) {
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>Deleted Successful!</strong> Refreshing The Page...';
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
        
            // After 4 seconds, redirect to admin panel
            echo "<script>setTimeout(function() { window.location.href = '../admin/send_announcement.php'; }, 4000);</script>";
            exit();
        } else {
            echo "Failed to delete announcement. Please try again.";
        }
        
    }
    
    ?>
<canvas id="canvas"></canvas>

    <br><br>
    <div class="container my-4">
        <h2>Insert Data</h2>
        <form method="POST">
            <label for="topic">Topic:</label><br>
            <input type="text" id="topic" name="topic" required><br>

            <label for="message_for">Message For:</label><br>
            <select id="message_for" name="message_for" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="Every Class">Every Class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
                <option value="Class 3">Class 3</option>
                <option value="Class 4">Class 4</option>
                <option value="Class 5">Class 5</option>
                <option value="Class 6">Class 6</option>
                <option value="Class 7">Class 7</option>
                <option value="Class 8">Class 8</option>
                <option value="Class 9">Class 9</option>
                <option value="Class 10">Class 10</option>
                <option value="Class 11">Class 11</option>
                <option value="Class 12">Class 12</option>
                <!-- Add more options as needed -->
            </select><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>

            <label for="highlight">Highlight:</label><br>
            <input type="text" id="highlight" name="highlight" style="font-weight: 900;" required><br>
            <div class="sendby">
                <label for="sent_by">Sent By:</label><br>
                <input type="text" id="sent_by" name="sent_by" value="<?php echo $sendername; ?>" readonly><br>
            </div>

            <input type="submit" value="Submit">
        </form>

        <br><br><br><br><br><br><br>

        <div class="announcement-container" style="margin-top: 4rem;">
            <?php
            $sql = "SELECT * FROM `announcement`";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="announcement">';
                    echo '<h2> Seriol No - ' . htmlspecialchars($row['sno']) . '</h2>';
                    echo '<h2> Topic - ' . htmlspecialchars($row['topic']) . '</h2>';
                    echo '<h2> Message - ' . htmlspecialchars($row['message']) . '</h2>';
                    echo '<h2> Message For - ' . htmlspecialchars($row['message_for']) . '</h2>';
                    echo '<h2> Note: ' . htmlspecialchars($row['highlight']) . '</h2>';
                    echo '<h2> Sender - ' . htmlspecialchars($row['sent_by']) . '</h2>';
                    echo '<span class="timestamp">Posted on ' . date('F j, Y', strtotime($row['sent_at'])) . '</span>';
                    echo '<form method="GET"> <input type="hidden" name="delete" value="' . htmlspecialchars($row['sno']) . '"><button type="submit" class="btn btn-danger">Delete</button></form></div>';
                }
            } else {
                echo '<p>No announcements available.</p>';
            }
            ?>
        </div>
    </div>
</body>
<script src="js/canva.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
