<?php
require_once __DIR__ . '/guards.php';
requireRole(['admin','editor','user']);

$id = (int)($_GET['id'] ?? 0);

// Fetch post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    exit("Post not found");
}

// Only allow owner (or admin)
if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $post['author_id']) {
    exit("Forbidden: You can only edit your own posts.");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("Invalid CSRF token");
    }

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
  <h2>Edit Post</h2>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" value="<?= e($post['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Content</label>
      <textarea name="content" class="form-control" rows="6" required><?= e($post['content']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
</body>
</html>
