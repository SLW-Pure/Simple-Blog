<?php
include 'includes/db.php';
include 'includes/header.php';

// Check if category ID is provided
$category_id = $_GET['id'] ?? null;
if (!$category_id) {
    die('<div class="alert alert-danger">Category not specified.</div>');
}

try {
    // Fetch category details
    $categoryStmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $categoryStmt->execute([$category_id]);
    $category = $categoryStmt->fetch();

    if (!$category) {
        die('<div class="alert alert-danger">Category not found.</div>');
    }

    // Fetch posts in this category
    $postsStmt = $pdo->prepare('SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC');
    $postsStmt->execute([$category_id]);
    $posts = $postsStmt->fetchAll();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching data: ' . $e->getMessage() . '</div>');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($category['name']) ?> - Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<div class="container-fluid" id="header">
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="./img/mlogo.png" alt="Logo" height="70"></a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
                <ul class="navbar-nav">
                    <?php foreach ($menuCategories as $menuCategory): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php?id=<?= htmlspecialchars($menuCategory['id']) ?>">
                                <?= htmlspecialchars($menuCategory['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Category Posts -->
<div class="container mt-5">
    <h2>Category: <?= htmlspecialchars($category['name']) ?></h2>
    <hr>
    <div class="row justify-content-center">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-xl-6 col-lg-12 text-center">
                    <a href="view.php?id=<?= htmlspecialchars($post['id']) ?>">
                        <div class="article-card">
                            <div class="article-meta text-left">
                                <h2><?= htmlspecialchars($post['title']) ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-lg-12 text-center">
                <p class="text-muted">No posts found in this category.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-5 py-4">
    <div class="container text-center">
        <p>&copy; <?= date("Y") ?> <?= htmlspecialchars($site_name ?? 'Default Site Name') ?>. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
