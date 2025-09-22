

<!-- add_owner.php -->
<!-- add_owner.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    require 'Navbar.php';




require 'db.php';
session_start();
$alert = FALSE;
$alertContent = '';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Generate a random 6-digit OTP
    $otp = rand(100000, 999999);

    // Retrieve form data
    $CoachingName = $_POST['CoachingName'];
    $CoachingId = $_POST['CoachingId'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $CompleteAddress = $_POST['CompleteAddress'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Store form data and OTP in session variables temporarily
    $_SESSION['form_data'] = $_POST;
    $_SESSION['otp'] = $otp;

    // Send OTP email to the user
    $mail = new PHPMailer(true);
    try {
       $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com';                   // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'Your Email';             // SMTP username
                $mail->Password   = 'Your Password';                   // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS also available
                $mail->Port       = 587;   
        // Sender and recipient settings
        $mail->setFrom('Your Email', 'HomeWorkAlarm');
        $mail->addAddress($email);

        // Email subject and body
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Email Verification';
        $mail->Body = "<h3>Your OTP is: $otp</h3> <br/ By SnapCourse>";

        $mail->send();
        echo 'OTP has been sent to your email.';

        // Redirect to the OTP verification page
        header("Location: verify_otp.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!-- Your existing form in add_owner.php -->


    <div class="container">
        <h2 class="mt-5 mb-4">Fill The Details To Make Your Coaching</h2>
        <h4 class="mt-5 mb-4">Remeber Your Deatils For Login</h4>
        <form method="post">

            <div class="mb-3">
                <label for="CoachingName" class="form-label">Coaching Name</label>
                <input type="text" class="form-control" id="CoachingName" name="CoachingName" required>
            </div>
            <div class="mb-3">
                <label for="Coaching Unique Id" class="form-label">Coaching Unique Number</label>
                <input type="text" class="form-control" id="CoachingName" name="CoachingId" placeholder="Please Add A Unique Number For Your Coaching" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Complete Address</label>
                <input type="address" class="form-control" id="CompleteAddress" name="CompleteAddress">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option selected disabled>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Let's Go</button>
        </form>
    </div>
</body>

</html>