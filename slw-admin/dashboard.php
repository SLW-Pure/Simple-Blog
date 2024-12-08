<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Veritabanı özet bilgileri
try {
    $postCount = $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    $categoryCount = $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    $mediaCount = $pdo->query('SELECT COUNT(*) FROM posts WHERE image IS NOT NULL')->fetchColumn(); // Medya dosyalarını çek
    $userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();

    // Veritabanı boyutunu al
    $dbSizeStmt = $pdo->query('SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size FROM information_schema.tables WHERE table_schema = DATABASE()');
    $dbSize = $dbSizeStmt->fetchColumn();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching data: ' . $e->getMessage() . '</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">
                            <i class="fas fa-edit"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Database Summary -->
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-edit"></i> Total Posts</h5>
                            <p class="card-text"><?= htmlspecialchars($postCount) ?> posts</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-tags"></i> Total Categories</h5>
                            <p class="card-text"><?= htmlspecialchars($categoryCount) ?> categories</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-images"></i> Total Media</h5>
                            <p class="card-text"><?= htmlspecialchars($mediaCount) ?> media files</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                            <p class="card-text"><?= htmlspecialchars($userCount) ?> users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-database"></i> Database Size</h5>
                            <p class="card-text"><?= htmlspecialchars($dbSize) ?> MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full Database Backup -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="backup.php" class="btn btn-primary">
                        <i class="fas fa-download"></i> Full Database Backup
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
