<?php
session_start();
require 'db.php';

// Check if session variables are set, otherwise redirect to addOwner.php
if (!isset($_SESSION['form_data']) || !isset($_SESSION['otp'])) {
    header('Location: addOwner.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    // Check if the entered OTP matches the one stored in the session
    if ($entered_otp == $_SESSION['otp']) {
        // If OTP matches, insert data into the database
        $form_data = $_SESSION['form_data'];

        $CoachingName = $form_data['CoachingName'];
        $CoachingId = $form_data['CoachingId'];
        $username = $form_data['username'];
        $password = $form_data['password'];
        $email = $form_data['email'];
        $phone_number = $form_data['phone_number'];
        $date_of_birth = $form_data['date_of_birth'];
        $CompleteAddress = $form_data['CompleteAddress'];
        $name = $form_data['name'];
        $age = $form_data['age'];
        $gender = $form_data['gender'];

        // SQL query to insert the data into owners table
        $sql = "INSERT INTO owners (`CoachingName`, `CoachingId`, `username`, `password`, `email`, `phone_number`, `date_of_birth`, `CompleteAddress`, `name`, `age`, `gender`, `created_at`) 
                VALUES ('$CoachingName', '$CoachingId', '$username', '$password', '$email', '$phone_number', '$date_of_birth', '$CompleteAddress', '$name', '$age', '$gender', CURRENT_TIMESTAMP)";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "You have been successfully registered.";
            unset($_SESSION['otp'], $_SESSION['form_data']); // Clear session data after successful registration
            
            // Redirect to student-login.php after 5 seconds
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'student-login.php';
                    }, 5000);
                  </script>";
        } else {
            echo 'Something went wrong.';
        }
    } else {
        echo 'Invalid OTP. Please try again.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f7f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px;
                width: 100%;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter OTP sent to your email</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
    </div>
</body>
</html>
