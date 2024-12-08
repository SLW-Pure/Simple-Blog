<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Hata ayıklama modunu etkinleştirme
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: posts.php');
    exit();
}

// Postu veritabanından çek
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: posts.php');
    exit();
}

// Tüm kategorileri çek
$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $image = $post['image'];

    // Kategori kontrolü
    $categoryCheck = $pdo->prepare('SELECT id FROM categories WHERE id = ?');
    $categoryCheck->execute([$category_id]);
    if ($categoryCheck->rowCount() === 0) {
        $error = 'Invalid category selected.';
    } else {
        // Yeni görsel yüklendiyse
        if (!empty($_FILES['image']['name'])) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // Eski görseli sil
            if ($post['image'] && file_exists('../' . $post['image'])) {
                unlink('../' . $post['image']);
            }

            // Yeni dosya adı oluştur ve yükle
            $randomName = bin2hex(random_bytes(5)) . '.' . $ext;
            $image = 'data/uploads/' . $randomName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image)) {
                $error = 'Failed to upload image.';
            }
        }

        if (!isset($error)) {
            $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ?, image = ?, category_id = ? WHERE id = ?');
            if ($stmt->execute([$title, $content, $image, $category_id, $id])) {
                header('Location: posts.php');
                exit();
            } else {
                $error = 'An error occurred while updating the post.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
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
                <h1 class="h2">Edit Post</h1>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($post['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" name="content" id="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image (optional)</label>
                    <input type="file" class="form-control" name="image" id="image">
                    <?php if ($post['image']): ?>
                        <p class="mt-2">Current Image:</p>
                        <img src="../<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-thumbnail mb-3" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    var easyMDE = new EasyMDE({ 
        element: document.getElementById("content"),
        spellChecker: false,
        placeholder: "Edit your post content in Markdown..."
    });
</script>
</body>
</html>
