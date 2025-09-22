<?php

session_start();
if(isset($_SESSION["username"])){
    $login = true;
}
else{
    header("Location: ../index.php");
}

// Database connection
$conn = new mysqli("localhost", "u200853583_luckysite", "Hiluckysite@10100", "u200853583_mysite");


// Function to sanitize data for CSV
function sanitizeForCSV($data) {
    if (strpos($data, ',') !== false || strpos($data, '"') !== false) {
        return '"' . str_replace('"', '""', $data) . '"';
    }
    return $data;
}

// Function to output CSV data to browser
function outputCSV($data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="course_buyers.csv"');
    $output = fopen('php://output', 'w');
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}

// Fetch all data from the 'coursebuyer' table
$sql = "SELECT * FROM coursebuyer";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $csv_data = array();
    $csv_data[] = array('ID', 'Name', 'Email', 'Phone', 'Amount', 'Address', 'Order ID', 'Datetime');
    while ($row = mysqli_fetch_assoc($result)) {
        $csv_row = array(
            $row['id'],
            sanitizeForCSV($row['name']),
            sanitizeForCSV($row['email']),
            sanitizeForCSV($row['phone']),
            sanitizeForCSV($row['amount']),
            sanitizeForCSV($row['address']),
            sanitizeForCSV($row['order_id']),
            sanitizeForCSV($row['datetime'])
        );
        $csv_data[] = $csv_row;
    }

    // Output CSV data to browser
    outputCSV($csv_data);
} else {
    echo "No records found.";
}

// Close database connection
mysqli_close($conn);
?>
