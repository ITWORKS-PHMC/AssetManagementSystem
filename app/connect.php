<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "assetmanagement";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_errno) {
    die("Conn Failed: " . $conn->connect_error);
} 
?>