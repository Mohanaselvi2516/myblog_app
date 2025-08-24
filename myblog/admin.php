<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    die("403 Forbidden - Admins only");
}
echo "Welcome Admin!";
?>