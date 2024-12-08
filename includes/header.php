<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

try {
    $stmt = $pdo->prepare("SELECT value FROM settings WHERE name = 'site_name' LIMIT 1");
    $stmt->execute();
    $setting = $stmt->fetch();
    $site_name = $setting['value'] ?? 'Default Site Name';

    $stmt = $pdo->prepare("SELECT value FROM settings WHERE name = 'site_url' LIMIT 1");
    $stmt->execute();
    $setting = $stmt->fetch();
    $site_url = $setting['value'] ?? '/';
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

try {
    $menuCategories = $pdo->query('SELECT * FROM categories ORDER BY name ASC')->fetchAll();
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Error fetching categories: ' . $e->getMessage() . '</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
        background-color: #24292e;
        color: #24292e;
    }

    .navbar, .footer {
        background-color: #fafafa;
    }

    .navbar a, .footer a {
        color: #ffffff;
        text-decoration: none;
    }

    .navbar a:hover, .footer a:hover {
        text-decoration: underline;
    }

    .recent-posts {
        margin-top: 30px;
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 6px;
        padding: 20px;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .recent-posts h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0366d6;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table thead {
        background-color: #f6f8fa;
        text-align: left;
        border-bottom: 2px solid #e1e4e8;
    }

    table thead th {
        padding: 10px;
        font-weight: 600;
        color: #24292e;
    }

    table tbody tr {
        border-bottom: 1px solid #e1e4e8;
    }

    table tbody tr:last-child {
        border-bottom: none;
    }

    table td {
        padding: 10px;
        font-size: 14px;
        color: #586069;
    }

    table td a {
        color: #0366d6;
        text-decoration: none;
    }

    table td a:hover {
        text-decoration: underline;
    }
      .visitor-card {
      width: 100%;
      background-color: #f8f8f8;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .contribution-grid {
      display: grid;
      grid-template-columns: repeat(52, 1fr); /* 52 hafta */
      gap: 2px;
      margin-top: 20px;
    }

    .contribution-day {
      width: 12px;
      height: 12px;
      background-color: #ebedf0; /* Varsayılan renk */
      border-radius: 2px;
      transition: background-color 0.3s ease;
    }

    /* Renk Skalası */
    .contribution-day[data-level="1"] {
      background-color: #c6e48b;
    }
    .contribution-day[data-level="2"] {
      background-color: #7bc96f;
    }
    .contribution-day[data-level="3"] {
      background-color: #239a3b;
    }
    .contribution-day[data-level="4"] {
      background-color: #196127;
    }
  .footer {
    position: relative; /* Varsayılan konum için */
    bottom: 0;
    width: 100%; /* Tüm genişliği kapsar */
    background-color: #161b22; /* Arka plan rengi */
    color: #ffffff; /* Metin rengi */
    text-align: center; /* Metni ortalar */
    padding: 20px 0; /* Üst-alt boşluk */
    font-size: 14px; /* Yazı boyutu */
    border-top: 1px solid #30363d; /* Üst kenarlık */
    margin-top: 30px; /* İçerikten boşluk */
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; 
}

.container {
    flex: 1; 
}

</style>

</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="<?= htmlspecialchars($site_url) ?>">
        <img src="https://m-dns.org/blog/img/mlogo.png" alt="Logo" height="40">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto">
          <?php foreach ($menuCategories as $category): ?>
            <li class="nav-item">
              <a class="nav-link" href="category.php?id=<?= htmlspecialchars($category['id']) ?>">
                <?= htmlspecialchars($category['name']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
