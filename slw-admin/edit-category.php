<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

$category_id = $_GET['id'] ?? null;

// Kategori ID kontrolü
if (!$category_id) {
    die('<div class="alert alert-danger">Category not specified.</div>');
}

// Mevcut kategoriyi veritabanından al
try {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$category_id]);
    $category = $stmt->fetch();

    if (!$category) {
        die('<div class="alert alert-danger">Category not found.</div>');
    }
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching category: ' . $e->getMessage() . '</div>');
}

// Kategori güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (empty($name)) {
        echo '<div class="alert alert-danger">Category name cannot be empty.</div>';
    } else {
        try {
            $updateStmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
            $updateStmt->execute([$name, $category_id]);
            header('Location: categories.php');
            exit();
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error updating category: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Category</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        <a href="categories.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Categories</a>
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
