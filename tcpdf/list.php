<?php 
session_start(); // Start the session

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['sudo_username'])) {
    header("Location: index.php");
    exit();
}

// Check if the form for changing forget value is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-forget'])) {
    // Assuming you have already connected to your database
    require '../db.php';

    // Sanitize input
    $newForget = mysqli_real_escape_string($conn, $_POST['new-forget']);

    // Update forget value in the database
    $sql = "UPDATE `notify` SET `forget` = '$newForget'";
    if (mysqli_query($conn, $sql)) {
        echo "Forget value changed successfully!";
        exit(); // Stop further execution
    } else {
        echo "Error: " . mysqli_error($conn);
        exit(); // Stop further execution
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacker Zone</title>
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 100%;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-block;
        }

        .menu li {
            display: inline-block;
            margin-right: 20px;
        }

        .menu li a {
            color: #0f0;
            text-decoration: none;
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .menu li a:hover, button {
            background-color: #0f0;
            color: #000;
        }

        .warning {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #f00;
            font-size: 1.2rem;
            font-style: italic;
        }

        .warning:before {
            content: "WARNING: Unauthorized access detected!";
            animation: flicker 1s infinite alternate;
        }

        @keyframes flicker {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0.5;
            }
        }
        @media screen and (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .menu li {
                margin-right: 10px;
            }

            .menu li a {
                padding: 8px 16px;
            }
        }

        .alert {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Hacker Zone</h1>
        <ul class="menu">
            <li><a href="hackedstudent.php">Student Data</a></li>
            <li><a href="hackedteacher.php">Teacher Data</a></li>
            <li><a href="viewadmin.php">Admin Data</a></li>
            <li><a href="changePass.php">Change Password</a></li>
        </ul>

        <!-- Button to show/hide input field for changing forget value -->
        
        <button id="toggle-forget">Change Forget Value</button>

        <!-- Input field for changing forget value -->
        <br><br><br><br><br>
        <div class="change-forget" id="forget-container" style="display: none;">
            <label for="new-forget">Enter New Forget Value:</label>
            <input type="text" id="new-forget" name="new-forget" required>
            <button id="submit-forget">Submit</button>
        </div>
    </div>
    <div class="warning"></div>

    <!-- JavaScript to toggle visibility of input field and handle forget value update -->
    <script>
        document.getElementById('toggle-forget').addEventListener('click', function() {
            var forgetContainer = document.getElementById('forget-container');
            forgetContainer.style.display = (forgetContainer.style.display === 'none') ? 'block' : 'none';
        });

        document.getElementById('submit-forget').addEventListener('click', function() {
            var newForgetValue = document.getElementById('new-forget').value;
            // AJAX call to update forget value without page reload
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Display alert for 3 seconds
                    var alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'alert-success');
                    alertDiv.innerHTML = 'Forget value changed successfully!';
                    document.body.insertBefore(alertDiv, document.body.firstChild);
                    setTimeout(function() {
                        alertDiv.remove(); // Remove the alert after 3 seconds
                        location.reload(); // Refresh the page to reflect changes
                    }, 3000);
                }
            };
            xhr.send('new-forget=' + newForgetValue);
        });
    </script>
</body>
</html>
