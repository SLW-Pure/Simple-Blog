<?php
// Include essential files
include 'includes/db.php';
include 'includes/header.php';
include 'includes/Parsedown.php'; // Include Parsedown for Markdown parsing

// Error reporting settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the post ID is provided
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='container my-5'><h2 class='text-danger text-center'>Invalid Post ID</h2></div>";
    include 'includes/footer.php';
    exit();
}

// Fetch the blog post by ID
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) {
    echo "<div class='container my-5'><h2 class='text-danger text-center'>Post Not Found</h2></div>";
    include 'includes/footer.php';
    exit();
}

// Initialize Markdown parser
$Parsedown = new Parsedown();

// Fetch all categories for the menu
try {
    $stmt = $pdo->query('SELECT * FROM categories ORDER BY name ASC');
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching categories: ' . $e->getMessage() . '</div>');
}

// Increment the view counter for the post
$updateStmt = $pdo->prepare('UPDATE posts SET views = views + 1 WHERE id = ?');
$updateStmt->execute([$id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> | <?= htmlspecialchars($site_name ?? 'My Blog') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Blog Post -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Hero Section -->
            <div class="hero-img">
                <img src="./<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid">
            </div>
            <div class="hero-title">
                <h1><?= htmlspecialchars($post['title']) ?></h1>
            </div>
            <div class="hero-meta">
                <span>Published on <?= date('F j, Y', strtotime($post['created_at'])) ?></span>
            </div>

            <!-- Post Content -->
            <div class="post-content my-4">
                <?= $Parsedown->text($post['content']); ?>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    <div class="related-posts">
        <h3>Related Posts</h3>
        <div class="row">
            <?php
            $relatedStmt = $pdo->prepare('SELECT * FROM posts WHERE id != ? ORDER BY created_at DESC LIMIT 2');
            $relatedStmt->execute([$id]);
            $relatedPosts = $relatedStmt->fetchAll();
            foreach ($relatedPosts as $related): ?>
                <div class="col-lg-6">
                    <div class="related-post-item">
                        <a href="./view.php?id=<?= $related['id'] ?>">
                            <img src="./data/uploads/<?= htmlspecialchars($related['image']) ?>" alt="Related Post Image" class="img-fluid">
                            <h5><?= htmlspecialchars($related['title']) ?></h5>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
