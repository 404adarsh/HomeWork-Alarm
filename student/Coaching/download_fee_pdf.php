<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit(); 
}

require '../../db.php';
require_once('../../tcpdf/tcpdf.php');

// Check if payment ID is provided in the URL
if (isset($_GET['payment_id'])) {
    // Retrieve payment ID from URL
    $payment_id = $_GET['payment_id'];

    // Fetch payment record from the database based on payment ID
    $sql = "SELECT * FROM payments WHERE id = $payment_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $payment = mysqli_fetch_assoc($result);

        // Fetch student ID from the payment record
        $student_id = $payment['student_id'];

        // Fetch student details based on student ID
        $sql_student = "SELECT * FROM students WHERE id = $student_id";
        $result_student = mysqli_query($conn, $sql_student);
        
        if ($result_student && mysqli_num_rows($result_student) > 0) {
            $student = mysqli_fetch_assoc($result_student);
            $student_name = $student['full_name'];
        } else {
            // Student not found
            $student_name = "Student Not Found";
        }

        // Continue with generating the PDF...
        // Create PDF object
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set watermark image paths (JPG format)
        $watermark_image1 = '../../img/watermark.jpg';
        $watermark_image2 = '../../img/accwatermark.jpg';

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

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add fee details to PDF
        $pdf->Cell(0, 10, 'Class: ' . $payment['class'] . 'th', 0, 1);
        $pdf->Cell(0, 10, 'Student Name: ' . $student_name, 0, 1);
        $pdf->Cell(0, 10, 'Month: ' . $payment['month'], 0, 1);
        $pdf->Cell(0, 10, 'Subject: ' . $payment['subject'], 0, 1);
        $pdf->Cell(0, 10, 'Amount: ' . $payment['amount'] . ' Rs', 0, 1);
        $pdf->Cell(0, 10, 'Payment Date: ' . $payment['payment_date'], 0, 1);

        // Output PDF as download
        $pdf->Output('fee_payment_' . $payment_id . '.pdf', 'D');
    } else {
        // Payment record not found
        echo "Payment record not found.";
    }
} else {
    // Payment ID not provided in the URL
    echo "Payment ID is required.";
}
?>
