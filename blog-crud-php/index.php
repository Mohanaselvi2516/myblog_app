<?php
session_start();
require 'db.php';
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

echo "<a href='create.php'>Create Post</a> | ";
if (isset($_SESSION['username'])) {
    echo "Welcome, " . $_SESSION['username'] . " | <a href='logout.php'>Logout</a>";
} else {
    echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
}
echo "<hr>";

while ($row = $result->fetch_assoc()) {
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>" . $row['content'] . "</p>";
    if (isset($_SESSION['username'])) {
        echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
    }
    echo "<hr>";
}
?>