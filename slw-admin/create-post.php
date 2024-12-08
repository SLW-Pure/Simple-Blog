<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Hata gösterimi etkinleştirildi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PDO hata modu etkinleştirildi
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Kategorileri çek
$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

// Form gönderildiğinde işlem yap
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = $_POST['category_id'] ?? null;
    $new_category = trim($_POST['new_category'] ?? '');
    $image = null;
    $error = null;

    // Form alanlarının doluluğunu kontrol et
    if (empty($title)) {
        $error = 'Title is required.';
    } elseif (empty($content)) {
        $error = 'Content is required.';
    }

    // Yeni kategori ekle
    if (!empty($new_category) && !$error) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $new_category)));
        try {
            $stmt = $pdo->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
            $stmt->execute([$new_category, $slug]);
            $category_id = $pdo->lastInsertId();
        } catch (PDOException $e) {
            $error = 'Failed to add new category: ' . $e->getMessage();
        }
    }

    // Kategori ID doğrula
    if (empty($category_id) && !$error) {
        $error = 'Please select a category or add a new one.';
    } elseif (!$error) {
        $stmt = $pdo->prepare('SELECT id FROM categories WHERE id = ?');
        $stmt->execute([$category_id]);
        if ($stmt->rowCount() === 0) {
            $error = 'Invalid category selected.';
        }
    }

    // Dosya yükleme işlemi
    if (!isset($error) && !empty($_FILES['image']['name'])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            $error = 'Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.';
        } else {
            $randomName = bin2hex(random_bytes(5)) . '.' . $ext;
            $image = 'data/uploads/' . $randomName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image)) {
                $error = 'Failed to upload image.';
            }
        }
    }

    // Post kaydet
    if (!isset($error)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO posts (title, content, image, category_id) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $content, $image, $category_id]);
            header('Location: posts.php');
            exit();
        } catch (PDOException $e) {
            $error = 'Failed to save post: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="posts.php">
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
                <h1 class="h2">Create Post</h1>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" name="content" id="content" rows="10" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Select Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Select Existing Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="new_category" class="form-label">Or Add New Category</label>
                    <input type="text" class="form-control" name="new_category" id="new_category" placeholder="Enter new category name">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image (optional)</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE({
        element: document.getElementById("content"),
        spellChecker: false,
        placeholder: "Write your post content in Markdown...",
        forceSync: true
    });

    // Form doğrulama
    document.querySelector("form").addEventListener("submit", function(event) {
        if (!simplemde.value().trim()) {
            alert("Content is required.");
            event.preventDefault();
            simplemde.codemirror.focus();
        }
    });
</script>

</body>
</html>
