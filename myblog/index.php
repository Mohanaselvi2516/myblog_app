<?php
$host = "localhost";
$db   = "apex_blog";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // true = unsafe
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>