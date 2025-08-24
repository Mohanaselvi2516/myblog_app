<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Post</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }
    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #444;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
      min-height: 120px;
    }
    .form-actions {
      text-align: center;
    }
    button {
      background: #4CAF50;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #45a049;
    }
    .cancel-link {
      margin-left: 15px;
      text-decoration: none;
      color: #555;
      font-size: 14px;
    }
    .cancel-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Create New Post</h2>
    <form method="POST">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" id="title" name="title" placeholder="Enter post title" required>
      </div>

      <div class="form-group">
        <label for="content">Post Content</label>
        <textarea id="content" name="content" placeholder="Write your content here..." required></textarea>
      </div>

      <div class="form-actions">
        <button type="submit">Publish</button>
        <a href="index.php" class="cancel-link">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
