<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
require 'db.php';

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    header("Location: index.php");
} else {
    $result = $conn->query("SELECT * FROM posts WHERE id=$id");
    $post = $result->fetch_assoc();
}
?>
<form method="POST">
    Title: <input type="text" name="title" value="<?= $post['title'] ?>" required><br>
    Content: <textarea name="content" required><?= $post['content'] ?></textarea><br>
    <button type="submit">Update</button>
</form>