<?php
// Start session for authentication
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog');
define('DB_USER', 'root');   // Default for XAMPP/WAMP
define('DB_PASS', '');       // Leave empty for XAMPP default

// Site configuration
define('BASE_URL', 'http://localhost/crud_app/');

// Connect to database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>