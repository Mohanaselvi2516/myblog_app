<?php
$host = "localhost";
$user = "root";   // default in XAMPP
$pass = "";       // default is empty in XAMPP
$dbname = "apex_blog";  // use your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
