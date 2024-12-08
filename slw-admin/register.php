<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';
include '../includes/admin-header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        try {
            $stmt->execute([$username, $hashed_password]);
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            $error = 'Username already exists';
        }
    }
}
?>
<h2>Register New Admin</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>
<?php include '../includes/admin-footer.php'; ?>
