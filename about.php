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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/ShowFacilityBox.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/aboutmedia.css">
    <title>Agarwal Coaching Centre - About</title>
</head>
<body>


    <?php
    require 'Navbar.php';
    '<br/>';
    '<br/>';
    '<br/>';
    ?>
<div class="container">
<div class="kid-about">
    <div class="leftside">
<div class="slider-container">
  <div class="slider">
    <div class="slide slide1"></div>
    <div class="slide slide2"></div>
    <div class="slide slide3"></div>
  </div>
  <button class="prev" onclick="prevSlide()">&#10094;</button>
  <button class="next" onclick="nextSlide()">&#10095;</button>
</div>
    </div>
    <div class="rightside">
    <h1 class="ml-3">Our Leisure Time</h1>
    <br>
    <p class="ml-3">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.</p>
    
    <div class="uprightside">
        <span class="rightside-1 ml-3">Guitar Music Classes</span>
        <span class="rightside-2 ml-3">Out Door Games</span>
    </div>
    <br>    
    <div class="downrightside">
    <span class="leftside-1 ml-3">Guitar Music Classes</span>
        <span class="leftside-2 ml-3">Out Door Games</span>
    </div>
    </div>

</div>
<br><br>

<div class="founder-intro">
    <h1>Meet Our Founder</h1>
    <div class="box-quote">
    <p><span class="stringopen">“</span> Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias adipisci dignissimos, illo consequuntur modi aperiam ex, minus fugiat similique possimus eaque reiciendis magnam? Suscipit illum minus distinctio est optio rem.<span class="stringclose">”</span></p>
</div>
<br>
<div class="founder-image">
    <img src="img/dhherajbhaiya-removebg-preview.png" alt="Mr Dhheraj Agarwal">
    <div class="content ml-3">
    <h3>Dhheraj Agarwal</h3>
    <p>Founder - A One Star Public School</p>
    <p>Founder - Agarwal Coaching Centre</p>
    </div>
</div>
<br>
</div>

</div>

<?php
    require 'SubContent.php';
    '<br/>';
    '<br/>';
    '<br/>';
    require 'showFacility.php';

    '<br/>';
    '<br/>';
    '<br/>';
    require 'Footer.php';
    '<br/>';
    '<br/>';
    '<br/>';
    ?>
    <script src="js/index.js"></script>
</body>
<script src="js/about.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
