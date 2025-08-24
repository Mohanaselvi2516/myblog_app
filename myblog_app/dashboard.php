<?php
session_start();
include 'config.php';

// ✅ Protect page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Pagination settings
$posts_per_page = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// ✅ Search
$search = "";
$where = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
}

// ✅ Count total posts
$count_query = "SELECT COUNT(*) AS total FROM posts $where";
$count_result = mysqli_query($conn, $count_query);
$total_posts = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// ✅ Fetch posts
$query = "SELECT * FROM posts $where ORDER BY created_at DESC LIMIT $offset, $posts_per_page";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #f8f9fa);
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            border-bottom: 3px solid #1976d2;
        }
        .container {
            max-width: 1000px;
        }
        .post-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .post-card:hover {
            transform: translateY(-3px);
        }
        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">📖 My Blog Dashboard</span>
        <div class="text-white ms-auto">
            Welcome, <?php echo $_SESSION['username']; ?> | 
            <a href="logout.php" class="text-white text-decoration-none">Logout</a>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <?php if ($_SESSION['role'] === 'admin') { ?>
            <a href="create.php" class="btn btn-success shadow-sm">+ Create Post</a>
        <?php } ?>
        <form class="d-flex" method="GET" action="dashboard.php">
            <input class="form-control me-2" type="text" name="search" placeholder="Search posts..."
                   value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="row g-4">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6">
                <div class="card post-card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text text-muted">
                            <?php echo htmlspecialchars(substr($row['content'], 0, 120)) . '...'; ?>
                        </p>
                        <small class="text-secondary">📅 <?php echo $row['created_at']; ?></small>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between">
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <div>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure?')" 
                                   class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">No actions</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>