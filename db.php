<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "snapcoursecoaching";
// $server = "localhost";
// $username = "root";
// $password = "";
// $dbname = "acc";

$conn = new mysqli("$server", "$username","$password", "$dbname");  // Connect to

if(!$conn){
    echo 'Something Went Wrong';
}
?>