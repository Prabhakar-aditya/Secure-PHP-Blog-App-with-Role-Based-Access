<?php
require_once __DIR__ . '/config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("Invalid CSRF token");
    }

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (strlen($username) < 3 || strlen($password) < 6) {
        $error = "Username must be ≥3 chars, password ≥6 chars.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hash]);
            header("Location: login.php");
            exit;
        } catch (Exception $e) {
            $error = "Username already taken.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 400px;">
  <h2>Register</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Register</button>
  </form>
</div>
</body>
</html>
