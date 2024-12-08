<?php
include 'includes/db.php';
include 'includes/header.php';

// Error settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Visitor Counter
$visitorCountFile = 'visitor_count.txt';
$visitorCount = 1; // Default value
if (file_exists($visitorCountFile)) {
    $visitorCount = (int)file_get_contents($visitorCountFile) + 1;
}
file_put_contents($visitorCountFile, $visitorCount); // Save updated visitor count

// Fetch blog posts
try {
    $stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 10');
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching posts: ' . $e->getMessage() . '</div>');
}

// Fetch categories
try {
    $stmt = $pdo->query('SELECT * FROM categories ORDER BY name ASC');
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching categories: ' . $e->getMessage() . '</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | <?= htmlspecialchars($site_name ?? 'My Blog') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Visitor Activity -->
<div class="container my-5">
    <div class="card visitor-card">
        <h5 class="card-title text-center">
            Visitor Activity
            <span class="text-muted">(<?= number_format($visitorCount) ?> total visits)</span> <!-- Total visitor count -->
        </h5>
        <div class="contribution-grid">
            <?php for ($i = 0; $i < 365; $i++): ?>
                <div class="contribution-day" data-level="<?= ($i < $visitorCount) ? rand(1, 4) : 0 ?>"></div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="recent-posts">
        <h2 align="center">Recent Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Published Date</th>
                    <th>Views</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <a href="view.php?id=<?= htmlspecialchars($post['id']) ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </td>
                        <td>
                            <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?>
                        </td>
                        <td>
                            <?= date("M d, Y", strtotime($post['created_at'])) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($post['views'] ?? 0) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No recent posts available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
