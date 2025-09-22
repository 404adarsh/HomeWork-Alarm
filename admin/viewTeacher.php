<?php

session_start(); // Start the session

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

$CoachingId = $_COOKIE['CoachingId'];
require '../db.php';

// Initialize the teachers array
$teachers = [];

// Check if the search form is submitted
if(isset($_POST['search'])) {
    $search = $_POST['search'];
    // Modify the query to include the search condition using prepared statements
    // Modify the query to include the search condition using prepared statements
$query = "SELECT * FROM `teachers` WHERE CoachingId = ? AND
(`name` LIKE ? OR 
`phone_number` LIKE ? OR 
`aadhar_number` LIKE ? OR 
`email` LIKE ? OR 
`teacher_id` LIKE ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
// Define search pattern
$searchPattern = '%' . $search . '%';
// Bind parameters
mysqli_stmt_bind_param($stmt, "ssssss", $CoachingId, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern);
// Execute the statement
mysqli_stmt_execute($stmt);
// Get result
$result = mysqli_stmt_get_result($stmt);
} else {
// If statement preparation fails, handle the error
echo "Error: " . mysqli_error($conn);
exit();
}
// Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch all teachers
        $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    // If search is not performed, fetch all teachers
    $query = "SELECT * FROM teachers WHERE CoachingId = '$CoachingId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            /* Prevent canvas from intercepting mouse events */
        }
    </style>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <canvas id="canvas"></canvas>

    <main>
        <div class="container admin-container">
            <form method="POST" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by name, phone number, or user ID"
                        name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
            <h1 class="text-strong">View Teachers</h1>
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($teachers)): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Aadhar Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teacher ID</th>
                                    <th scope="col">Teacher Password</th>
                                    <th scope="col">Actions</th> <!-- New column for actions -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teachers as $teacher): ?>
                                    <tr>
                                        <th scope="row"><?php echo $teacher['id']; ?></th>
                                        <td><?php echo $teacher['name']; ?></td>
                                        <td><?php echo $teacher['phone_number']; ?></td>
                                        <td><?php echo $teacher['aadhar_number']; ?></td>
                                        <td><?php echo $teacher['email']; ?></td>
                                        <td><?php echo $teacher['teacher_id']; ?></td>
                                        <td><?php echo $teacher['password']; ?></td>
                                        <td> <!-- Actions column -->
                                            <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>"
                                                class="btn btn-primary">Edit</a>
                                            <a href="delete_teacher.php?id=<?php echo $teacher['id']; ?>"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No teachers found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <script src="js/canva.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>