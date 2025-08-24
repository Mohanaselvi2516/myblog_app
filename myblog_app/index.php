<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: posts.php");
} else {
    header("Location: login.php");
}
exit();
?>
