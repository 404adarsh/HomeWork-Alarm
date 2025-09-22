<?php
require 'db.php';

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
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/Contact.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php require 'Navbar.php'; 


$alert = FALSE;
$alertContent = '';


if($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['name'];
  $phoneNumber = $_POST['phoneNumber'];
  $email = $_POST['email'];
  $category = $_POST['category'];
  $reason = $_POST['reason'];
  $Message = $_POST['Message'];

// $sql = "INSERT INTO `contact`(`name`, `phoneNumber`, `email`, `category`, `reason`, `Message`) VALUES ('$name','$phoneNumber','$e','$category','$reason','$Message');";
$sql = "INSERT INTO `contact` (`name`, `phoneNumber`, `email`, `category`, `reason`, `Message`) VALUES ('$name', '$phoneNumber', '$email', '$category', '$reason', '$Message');";


$result = mysqli_query($conn, $sql);

if($result){
    $alert = TRUE;  
    $strong = "Sent Successfull! ";
    $message = "We'll Contact You Soon...";
        // Constructing the success alert content
    $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
    $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    $alertContent .= '</div>';
    // After 4 seconds, redirect to admin panel
    echo $alertContent;
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 4000);</script>";

}
else{
  echo "Something Went Wrong";
}


}

?>

    <section>
        <div class="contact-form contact-section container mt-3">
            <h1 class="text-center">Contact Us</h1>
            <!-- Display alert if form is submitted successfully -->
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert" style="display: none;">
                <strong>Form Submitted Successfully!</strong> We'll get back to you shortly.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
             <form id="contactForm" method="POST"> <!--onsubmit="submitForm(event)" -->
                <div class="form-group mb-3">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" style="width: 100%;">
                    <span class="error" id="nameErr"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" style="width: 100%;">
                    <span class="error" id="phoneNumberErr"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" style="width: 100%;">
                    <span class="error" id="emailErr"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-control" style="width: 100%;">
                        <option value="">-- Select --</option>
                        <option value="School">School</option>
                        <option value="Coaching">Coaching</option>
                        <option value="Other">Other</option>
                    </select>
                    <span class="error" id="categoryErr"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="reason">Reason:</label>
                    <select id="reason" name="reason" class="form-control" style="width: 100%;">
                        <option value="">-- Select --</option>
                        <option value="Admission">Admission</option>
                        <option value="Complaint">Complaint</option>
                        <option value="Enquiry">Enquiry</option>
                    </select>
                    <span class="error" id="reasonErr"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="message">Message:</label>
                    <textarea id="message" name="Message" class="form-control" style="width: 100%; height: 150px;"></textarea>
                    <span class="error" id="messageErr"></span>
                </div>
                <input type="submit" value="Submit" class="btn btn-purple" />
            </form>
        </div>
    </section>
    <div class="give-space my-3"></div>
    <footer>
        Agarwal Coaching Centre &copy; 2024. All rights reserved.
    </footer> 

    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function submitForm(event) {
            event.preventDefault(); // Prevent form submission

            // Reset previous error messages
            document.querySelectorAll('.error').forEach(function(element) {
                element.textContent = '';
            });

            // Retrieve form data
            let name = document.getElementById('name').value.trim();
            let phoneNumber = document.getElementById('phoneNumber').value.trim();
            let email = document.getElementById('email').value.trim();
            let category = document.getElementById('category').value.trim();
            let reason = document.getElementById('reason').value.trim();
            let message = document.getElementById('message').value.trim();

            // Validate form data
            let isValid = true;
            if (name === '') {
                document.getElementById('nameErr').textContent = 'Name is required';
                isValid = false;
            }
            // Add validation for other fields if needed

            // If form data is valid, display success message
            if (isValid) {
                document.getElementById('contactForm').reset(); // Reset form fields
                document.getElementById('alert').style.display = 'block'; // Display success alert
            }
        }
    </script>
</body>
</html>
