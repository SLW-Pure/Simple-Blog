<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Ayarları Veritabanından Çekme
try {
    $stmt = $pdo->query('SELECT name, value FROM settings');
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching settings: ' . $e->getMessage() . '</div>');
}

// Ayarları Güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key === 'site_logo' && !empty($_FILES['site_logo']['name'])) {
            // Logo Dosyasını Yükleme
            $ext = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowedExtensions)) {
                echo '<div class="alert alert-danger">Invalid file type for logo.</div>';
                continue;
            }
            $logoName = 'logo_' . time() . '.' . $ext;
            $logoPath = '../data/uploads/' . $logoName;
            move_uploaded_file($_FILES['site_logo']['tmp_name'], $logoPath);
            $value = 'data/uploads/' . $logoName;
        }

        // Ayarı Güncelle
        $updateStmt = $pdo->prepare('UPDATE settings SET value = ? WHERE name = ?');
        $updateStmt->execute([trim($value), $key]);
    }

    header('Location: settings.php?success=1');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
                        <a class="nav-link" href="dashboard.php">
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
                        <a class="nav-link active" href="settings.php">
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
                <h1 class="h2">Settings</h1>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Settings updated successfully!</div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <!-- General Settings -->
                <div class="mb-4">
                    <h4>General Settings</h4>
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control" name="site_name" id="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="site_desc" class="form-label">Site Description</label>
                        <textarea class="form-control" name="site_desc" id="site_desc" rows="3"><?= htmlspecialchars($settings['site_desc'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="site_keywords" class="form-label">Site Keywords</label>
                        <textarea class="form-control" name="site_keywords" id="site_keywords" rows="2"><?= htmlspecialchars($settings['site_keywords'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="site_url" class="form-label">Site URL</label>
                        <input type="url" class="form-control" name="site_url" id="site_url" value="<?= htmlspecialchars($settings['site_url'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="site_logo" class="form-label">Site Logo</label>
                        <input type="file" class="form-control" name="site_logo" id="site_logo">
                        <?php if (!empty($settings['site_logo'])): ?>
                            <img src="../<?= htmlspecialchars($settings['site_logo']) ?>" alt="Site Logo" class="img-thumbnail mt-2" style="max-height: 100px;">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mb-4">
                    <h4>Social Media</h4>
                    <div class="mb-3">
                        <label for="social_facebook" class="form-label">Facebook</label>
                        <input type="url" class="form-control" name="social_facebook" id="social_facebook" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="social_twitter" class="form-label">Twitter</label>
                        <input type="url" class="form-control" name="social_twitter" id="social_twitter" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="social_instagram" class="form-label">Instagram</label>
                        <input type="url" class="form-control" name="social_instagram" id="social_instagram" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>">
                    </div>
                </div>

                <!-- Content Settings -->
                <div class="mb-4">
                    <h4>Content Settings</h4>
                    <div class="mb-3">
                        <label for="homepage_post_count" class="form-label">Homepage Post Count</label>
                        <input type="number" class="form-control" name="homepage_post_count" id="homepage_post_count" value="<?= htmlspecialchars($settings['homepage_post_count'] ?? '10') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="homepage_excluded_categories" class="form-label">Excluded Categories (Comma Separated IDs)</label>
                        <input type="text" class="form-control" name="homepage_excluded_categories" id="homepage_excluded_categories" value="<?= htmlspecialchars($settings['homepage_excluded_categories'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="homepage_sticky_post" class="form-label">Sticky Post ID</label>
                        <input type="number" class="form-control" name="homepage_sticky_post" id="homepage_sticky_post" value="<?= htmlspecialchars($settings['homepage_sticky_post'] ?? '') ?>">
                    </div>
                </div>

                <!-- Footer -->
                <div class="mb-4">
                    <h4>Footer</h4>
                    <div class="mb-3">
                        <label for="footer_brand" class="form-label">Footer Brand</label>
                        <input type="text" class="form-control" name="footer_brand" id="footer_brand" value="<?= htmlspecialchars($settings['footer_brand'] ?? '') ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
