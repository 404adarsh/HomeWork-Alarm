<?php
session_start(); // Start the session

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['sudo_username'])) {
    header("Location: index.php");
    exit();
}

require '../db.php';

// Initialize the teachers array
$teachers = [];

// Check if the search form is submitted
if(isset($_POST['search'])) {
    // Retrieve the search term
    $search = $_POST['search'];

    // Prepare the SQL query with the search condition
    $query = "SELECT * FROM teachers WHERE 
                `name` LIKE '%$search%' OR 
                `phone_number` LIKE '%$search%' OR 
                `teacher_id` LIKE '%$search%'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch all teachers
        $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    // If search is not performed, fetch all teachers
    $query = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacked Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .form-control {
            background-color: #000;
            color: #0f0;
            border: 1px solid #0f0;
            border-radius: 5px;
            padding: 5px 10px;
            margin-right: 10px;
        }

        .btn {
            background-color: #0f0;
            color: #000;
            border: 1px solid #0f0;
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #000;
            color: #0f0;
            transition: 0.3s;
        }

        .text-strong {
            font-weight: bold;
        }

        .teacher-box {
            background-color: #111;
            border: 2px solid #0f0;
            border-radius: 10px;
            box-shadow: 0 0 20px #0f0;
            padding: 20px;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            .form-control {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container my-5">
        <h2 class="text-center mb-4">View Teachers</h2>

        <!-- Search form -->
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" placeholder="Search by name, phone number, or user ID" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>

        <div class="row">
            <?php
            // Loop through the fetched teachers and display them in boxes
            foreach ($teachers as $teacher) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='teacher-box'>";
                echo "<p><strong>Name:</strong> {$teacher['name']}</p>";
                echo "<p><strong>Phone Number:</strong> {$teacher['phone_number']}</p>";
                echo "<p><strong>Aadhar Number:</strong> {$teacher['aadhar_number']}</p>";
                echo "<p><strong>Email:</strong> {$teacher['email']}</p>";
                echo "<p><strong>Class:</strong> {$teacher['class']}</p>";
                echo "<p><strong>Role:</strong> " . ucfirst($teacher['role']) . "</p>";
                echo "<p><strong>Teacher ID:</strong> {$teacher['teacher_id']}</p>";
                echo "<p><strong>Teacher Password:</strong> {$teacher['password']}</p>";
                echo "<div class='edit-btn'><a href='delete_teacher.php?id={$teacher['id']}' class='btn btn-danger'>Delete</a></div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
