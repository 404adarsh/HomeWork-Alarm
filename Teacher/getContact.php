<?php
$alert = FALSE;
$alertContent = '';

session_start();

// Redirect unauthorized users

if (!isset($_SESSION['admin_username']) && !isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../db.php';



// Fetch contact form submissions from the database
$sql = "SELECT * FROM contact";

$result = mysqli_query($conn, $sql);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sno = $_POST['sno_id'];

    $delete_sql = "DELETE FROM `contact` WHERE `sno` = $sno";

    $delete_result = mysqli_query($conn, $delete_sql);

    if($delete_result){
        $alert = TRUE;  
        $strong = "Deleted Successfull! ";
        $message = "Refreshing The Page";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        // After 4 seconds, redirect to admin panel
        echo $alertContent;
        echo "<script>setTimeout(function() { window.location.href = 'getContact.php'; }, 4000);</script>";
    
    }
    else{
        echo 'Something Went Wrong';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'Navbar.php'; ?>


<div class="container my-5">
    <h2 class="text-center mb-4">Contact Request</h2>

    <?php
    // Check if there are any submissions
    if ($result->num_rows > 0) {
        // Loop through the fetched records and display them in a card-like layout
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                    <p class="card-text"><strong>Phone Number:</strong> <?php echo $row["phoneNumber"]; ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo $row["email"]; ?></p>
                    <p class="card-text"><strong>Category:</strong> <?php echo $row["category"]; ?></p>
                    <p class="card-text"><strong>Reason:</strong> <?php echo $row["reason"]; ?></p>
                    <p class="card-text"><strong>Message:</strong> <?php echo $row["Message"]; ?></p>
                    <!-- Add a delete button -->
                    <form method="post">
                        <input type="hidden" name="sno_id" value="<?php echo $row['sno']; ?>"> <!-- Use 'id' instead of 'sno' -->
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No contact form submissions found.</p>";
    }

    // Close the database connection
    
    ?>
</div>

</body>
</html>
