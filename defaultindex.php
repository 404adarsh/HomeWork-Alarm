<?php 

session_start(); // Start the session

// Check if the admin is logged in, redirect them to their destination page
if (isset($_SESSION['admin_username'])) {
    header("Location: admin/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}
elseif (isset($_SESSION['userid'])) {
    header("Location: student/Coaching/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}
elseif (isset($_SESSION['teacher_id'])) {
    header("Location: Teacher/index.php"); // Change "destination_page.php" to the page where the admin should be redirected
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="img/websitefacility.gif" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta
    name="description"
    content="Web site created using create-react-app"
    />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/ShowFacilityBox.css">
    <title>Agarwal Coaching Centre</title>
  </head>
  <body>
    <?php
    require 'Navbar.php';

?>

<main>

<div class="full-container">
            <div class="pop-up-box">
                    <span>Quallity Learning </span>
                    <br />
                    <span>For Every Child</span>
                    <button class="btn btn-sm btn-pop"><a href="Contact.php">Contact Us</a></button>
            </div>
        </div>
        <br><br>
        <?php
    require 'showFacility.php';
    '<br/>';
    '<br/>';
    '<br/>';
    require 'SubContent.php';
    '<br/>';

        ?>
            '<br/>';

'<br/>';

'<br/>';
'<br/>';

</main>







<?php
require 'Footer.php';

?>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="js/index.js"></script>
</html>
