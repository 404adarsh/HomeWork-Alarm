<?php

$server = "127.0.0.1:3306   ";
$username = "u200853583_unrootdbacc";
$password = "Adarsh@1988@";
$dbname = "u200853583_accdb";

$conn = new mysqli("$server", "$username","$password", "$dbname");  // Connect to

if(!$conn){
    echo 'Something Went Wrong';
}
?>