<?php
session_start();


$alert = FALSE;
$alertContent = '';



if (!isset($_SESSION['admin_username']) && !isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}



require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $deleterow = $_POST['delete_id'];

    $sql = "DELETE FROM enrolledstudent WHERE `enrolledstudent`.`id` = $deleterow ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['admin_username'] = $admin_username;
        $alert = TRUE;  
        $strong = "Login Successful!";
        $message = "Redirecting to admin panel...";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        // After 4 seconds, redirect to admin panel
        echo "<script>setTimeout(function() { window.location.href = 'admin/index.php'; }, 4000);</script>";
  
        exit; // Stop execution to prevent the rest of the page from loading
    } else {
        echo 'Failed to delete'; // Notify if deletion fails
        exit; // Stop execution to prevent the rest of the page from loading
    }
}

$sql = "SELECT * FROM `enrolledstudent`";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo 'Failed to fetch data'; // Notify if fetching data fails
    exit; // Stop execution to prevent the rest of the page from loading
}

$row = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
    canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Prevent canvas from intercepting mouse events */
        }
        </style>
       
    
    <title>Enrolled Student</title>
</head>

<body>


    <?php require 'navbar.php'; ?>
    <canvas id="canvas"></canvas>

    <h2 class="mt-5">Enrolled Students</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Education</th>
                <th>Class</th>
                <th>Education</th>
                <th>Enrollment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($row > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . $row['subject'] . "</td>";
                    echo "<td>" . $row['class'] . "</td>";
                    echo "<td>" . $row['education'] . "</td>";
                    echo "<td>" . $row['enrollment_date'] . "</td>";
                    echo "<td>
                            <form id='deleteForm' method='POST' onsubmit='deleteRow(event)'>
                                <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-danger'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>

<script>
function deleteRow(event) {
    event.preventDefault(); // Prevent default form submission

    let form = event.target;
    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log(data); // Log the response from the server
        // You can update the UI here if needed
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors here if needed
    });
}
</script>

</body>
<script src="js/canva.js"></script>
</html>
