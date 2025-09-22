<?php
session_start();

$alert = FALSE;
$alertContent = '';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.html");
    exit();
}

require '../db.php';

// Delete message if delete button is clicked
if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];
    $sql_delete = "DELETE FROM `chat` WHERE `sno` = ?";
    $stmt = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt, "i", $message_id);
    $result_delete = mysqli_stmt_execute($stmt);
    if ($result_delete) {
        $alert = TRUE;
        $strong = "Message Deleted!";
        $message = "Refresh the page to see the changes.";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";

    } else {
        $alert = TRUE;
        $strong = "Error Deleting Message!";
        $message = "Please try again.";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";
    }
}

// Delete all messages if delete all button is clicked
if (isset($_POST['delete_all_messages'])) {
    $sql_delete_all = "DELETE FROM `chat`";
    $stmt = mysqli_prepare($conn, $sql_delete_all);
    $result_delete_all = mysqli_stmt_execute($stmt);
    if ($result_delete_all) {
        $alert = TRUE;
        $strong = "All Messages Deleted!";
        $message = "Refresh the page to see the changes.";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";

    } else {
        $alert = TRUE;
        $strong = "Error Deleting Messages!";
        $message = "Please try again.";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['delete_message'])) {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $userid = $_POST['userid'];
    $category = $_POST['category'];
    $sendMessage = $_POST['sendMessage'];

    // Check if the message is empty
    if (empty($sendMessage)) {
        $alert = TRUE;
        $strong = "Message Empty!";
        $message = "Please enter a message before sending.";
        // Constructing the error alert content
        $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";
    } else {
        $sql = "INSERT INTO `chat` (`name`, `class`, `userid`, `category`, `sendMessage`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiss", $name, $class, $userid, $category, $sendMessage);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $alert = TRUE;
            $strong = "Sent Successful!";
            $message = "Refresh the page to see your message.";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";
        } else {
            $alert = TRUE;
            $strong = "Sent Unsuccessful!";
            $message = "Please try again.";
            $Note = "Note: Don't Use This Symbol - ' ";
            // Constructing the error alert content
            $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . '<br>'.  $message . $Note;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            echo "<script>setTimeout(function() { window.location.href = 'chat.php'; }, 2000);</script>";
        }
    }
}

$username = $_SESSION['admin_username'];

$uname = $_SESSION["admin_username"];

$sql = "SELECT `name` FROM `owners` WHERE `username` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $uname);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $sendername = $row["name"];
}

$class = 'null';
$category = 'null';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACC - Ideal Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chat.css">
</head>

<body>
    <!-- Navbar -->
    <?php require 'navbar.php';  ?>
    <!-- Chat container -->
    <div id="chat-container">
        <!-- Chat header -->
        <div id="chat-header">
            <h1 class="text-white">Ideal Chat</h1>
        </div>
        <!-- Select All and Delete All buttons -->
        <div class="text-end mb-3">
            <form action="chat.php" method="post">
                <button type="submit" class="btn btn-danger me-2" name="delete_all_messages"><i class="fas fa-trash-alt"></i>Delete All</button>
            </form>
        </div>
        <!-- Chat messages -->
        <div id="chat-messages">
            <!-- PHP code to fetch and display messages -->
            <?php
            $sql = "SELECT * FROM `chat`";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $message_id = $row['sno'];
                    $name = $row['name'];
                    $class = $row['class'];
                    $sendMessage = $row['sendMessage'];
                    $datetime = $row['datetime'];
                    // Check if the message is from the current user or other user
                    if ($name == $sendername) {
                        // If it's from the current user, add 'me' class
                        echo '<div class="message-php me">';
                    } else {
                        // If it's from other user, add 'other' class
                        echo '<div class="message-php other">';
                    }
                    // Display message content and info
                    echo '<div class="message-content">';
                    echo '<div class="message-name text-big">' . $name . '</div>';
                    echo '<div class="message-text">' . $sendMessage . '</div>';
                    echo '</div>';
                    echo '<div class="message-info">';
                    echo '<p>' . $datetime . '</p>';
                    echo '<p>' . $class . '</p>';

                    // Admin Can Delete Anyone Message

                    echo '<form action="chat.php" method="post">';
                    echo '<button type="submit" class="delete-button" name="delete_message"><i class="fas fa-trash-alt"></i>Delete</button>';
                    echo '<input type="hidden" name="message_id" value="' . $message_id . '">';
                    echo '</form>';
                    echo '<br/>';

                    echo '</div>';
                    echo '</div>';
                    echo '<br/>';
                }
            }
            ?>
        </div>
        <!-- Chat input -->
        <div id="chat-input">
            <!-- Form for sending messages -->
            <form action="chat.php" method="post">
                <!-- Input field for typing message -->
                <div class="message d-flex">
                    <input type="text" id="message-input" name="sendMessage" placeholder="Type a message...">
                    <button id="send-button">Send</button>
                </div>
                <!-- Hidden inputs for additional data -->
                <input type="hidden" name="name" value="<?php echo $sendername; ?>">
                <input type="hidden" name="class" value="<?php echo $class; ?>">
                <input type="hidden" name="userid" value="<?php echo $uname; ?>">
                <input type="hidden" name="category" value="<?php echo $category; ?>">
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
