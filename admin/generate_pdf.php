<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit(); 
}

require '../db.php';
require_once('../tcpdf/tcpdf.php');

$CoachingId = $_COOKIE['CoachingId'];


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class = $_POST["class"];
    $student_id = $_POST["student"];
    $subject = $_POST["subject"]; // Retrieve subject data
    $month = $_POST["month"];
    $amount = $_POST["amount"];
    $receiver = $_POST["receiver"];

    // Fetch student's name based on student ID
    $sql_student = "SELECT `full_name` FROM `students` WHERE `id` = '$student_id'";
    $result_student = mysqli_query($conn, $sql_student);
    if ($result_student && mysqli_num_rows($result_student) > 0) {
        $row_student = mysqli_fetch_assoc($result_student);
        $student_name = $row_student['full_name'];
    } else {
        $student_name = "Unknown";
    }

    // Insert payment data into the database
    $sql_payment = "INSERT INTO payments (class, student_id, student_name, month, subject, amount, receiver, CoachingId) VALUES ('$class', '$student_id', '$student_name', '$month', '$subject', '$amount', '$receiver', '$CoachingId')";
    if (mysqli_query($conn, $sql_payment)) {
        // Payment data inserted successfully
        // Optionally, you can redirect the user to a success page or display a success message
        
            // After 4 seconds, redirect to admin panel
            // echo "<script>setTimeout(function() { window.location.href = '../admin/send_announcement.php'; }, 2000);</script>"; 

        // Create PDF object
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set watermark image paths (JPG format)
        $watermark_image1 = '../img/watermark.jpg';
        $watermark_image2 = '../img/watermark.jpg';

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Calculate coordinates for positioning watermark images
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();
        $imageWidth = 210; // Assume watermark image width is 210 (A4 width)
        $imageHeight = 297; // Assume watermark image height is 297 (A4 height)
        $x1 = ($pageWidth - $imageWidth) / 4; // Calculate x coordinate for the first image
        $y1 = ($pageHeight - $imageHeight) / 4; // Calculate y coordinate for the first image
        $x2 = ($pageWidth - $imageWidth) / 4 * 3; // Calculate x coordinate for the second image
        $y2 = ($pageHeight - $imageHeight) / 4 * 3; // Calculate y coordinate for the second image

        // Add first watermark image
        $pdf->Image($watermark_image1, $x1, $y1, $imageWidth, $imageHeight, '', '', '', false, 300, '', false, false, 0);

        // Add second watermark image
        $pdf->Image($watermark_image2, $x2, $y2, $imageWidth, $imageHeight, '', '', '', false, 200, '', false, false, 0);

        // Add header
        $pdf->SetY(10);
        $pdf->Cell(0, 0, 'Agarwal Coaching Centre', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Add some impressive text about education
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->MultiCell(0, 10, "Unlock Your Potential with Quality Education", 0, 'C');

        // Add fee submission details
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Student Name: ' . $student_name, 0, 1);
        $pdf->Cell(0, 10, 'Class: ' . $class . 'th', 0, 1);
        $pdf->Cell(0, 10, 'Subject: ' . $subject, 0, 1); // Include subject here
        $pdf->Cell(0, 10, 'Month: ' . $month, 0, 1);
        $pdf->Cell(0, 10, 'Amount: ' . $amount .'Rs', 0, 1);
        $pdf->Cell(0, 10, 'Status: ' . 'Paid', 0, 1);

        // Add some impressive text about education
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'C', 20);
        $pdf->MultiCell(0, 10, "Thank You For Using Our Web Portal! Hope You'll Visit  Again Soon.", 0, 'C');

        // Add footer
        $pdf->SetY(-15);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'Agarwal Coaching Centre - Providing Quality Education Since 2000', 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // Output PDF as download
        $pdf->Output('watermarked_fee_submission_' . time() . '.pdf', 'D');

        // Display success alert after PDF generation
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
        $alert = TRUE;
        $strong = "Payment Successful!";
        $message = "File Is Downloading...";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
    } else {
        // Error handling: Display an error message or redirect to an error page
        echo "Error: " . $sql_payment . "<br>" . mysqli_error($conn);
    }
}
?>

