<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
require 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM posts WHERE id=$id");
header("Location: index.php");
?>