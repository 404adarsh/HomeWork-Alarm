<?php
session_start(); // Session start karo

// Agar admin login hai, toh unko admin panel pe redirect karo
if (isset($_SESSION['admin_username'])) {
    header("Location: admin/index.php");
    exit();
} elseif (isset($_SESSION['userid'])) {
    header("Location: student/Coaching/index.php");
    exit();
} elseif (isset($_SESSION['teacher_id'])) {
    header("Location: Teacher/index.php");
    exit();
}

require './db.php';

$alert = FALSE;
$alertContent = '';

// Check karne ke liye ki user ne galat password kitni baar try kiya hai
if (isset($_COOKIE['wrong_password_attempts'])) {
    $wrong_attempts = $_COOKIE['wrong_password_attempts'];
    // Agar attempts 6 se zyada hain, toh user ko block kar do
    if ($wrong_attempts >= 6) {
        // Cookie ko set karo jismein block ka message ho
        setcookie('login_block', 'true', time() + (24 * 3600)); // 24 hours ke liye
        // Aur user ko redirect karo login page par
        header("Location: teacher-login.php");
        exit();
    }
} else {
    // Agar cookie nahi hai ya value empty hai, toh 0 set karo
    $wrong_attempts = 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $teacher_password = $_POST['teacher_password'];
    $CoachingId = $_POST['CoachingId']; // Fetch Coaching Id from the form

    // Prepared statement ka istemal karke SQL query ko secure karo
    $sql = "SELECT * FROM `teachers` WHERE `teacher_id`=? AND `password`=? AND `CoachingId`=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Error: " . mysqli_error($conn);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $teacher_id, $teacher_password, $CoachingId); // Bind Coaching Id to the query
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        } else {
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['teacher_id'] = $teacher_id;
                $alert = TRUE;
                $strong = "Login Successful!";
                $message = "Redirecting to teacher panel...";
                setcookie('CoachingId', $CoachingId, time() + (86400 * 30), "/"); // 30 days ke liye
                $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
                $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo "<script>setTimeout(function() { window.location.href = 'Teacher/index.php'; }, 4000);</script>";
            } else {
                $alert = TRUE;
                $strong = "Invalid Credentials!";
                $message = "Please Check Your Id Or Password";
                $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
                $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                // Galat password ka count increment karo
                $wrong_attempts++;
                // Cookie mein count store karo
                setcookie('wrong_password_attempts', $wrong_attempts, time() + (24 * 3600)); // 24 hours ke liye

                // Agar attempts 6 se zyada hai, toh block ka message dikhao
                if ($wrong_attempts >= 6) {
                    $alertContent = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $alertContent .= 'अब कुछ नहीं हो सकता कृपा करके अब सो जाये \', लिट्टी चोखा खाये और कल आये';
                    $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agarwal Coaching Centre - Teacher Login</title>
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/portal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #f8f9fa;
        }

        main {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: auto;
            width: fit-content;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'singleNavbar.php'; ?>
    <br><br>

    <?php
    //
    if ($alert) {
        echo $alertContent;
    }
    ?>
    <main>
        <h2>Teacher Login</h2>
        <form action="teacher-login.php" method="post">
            <label for="CoachingId">Enter Your Coaching Id:</label>
            <input type="text" id="CoachingId" name="CoachingId" required><br>
            <label for="teacher_username">Teacher Id:</label>
            <input type="text" id="teacher_id" name="teacher_id" required><br>
            <label for="teacher_password">Password:</label>
            <input type="password" id="teacher_password" name="teacher_password" required><br>
            <button type="submit">Login</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
    <script src="js/Portal.js"></script>
</body>

</html>
