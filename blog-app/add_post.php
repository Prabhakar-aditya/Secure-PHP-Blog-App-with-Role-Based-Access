<?php
require_once __DIR__ . '/guards.php';
requireRole(['admin','editor','user']);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) die("Invalid CSRF token");

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $_SESSION['user_id']]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
  <h2>Add Post</h2>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Content</label>
      <textarea name="content" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Post</button>
  </form>
</div>
</body>
</html>
