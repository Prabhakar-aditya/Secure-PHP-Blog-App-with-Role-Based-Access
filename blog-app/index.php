<?php
require_once __DIR__ . '/config.php';

$stmt = $pdo->query("SELECT posts.*, users.username 
                     FROM posts 
                     JOIN users ON posts.author_id = users.id 
                     ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h1>Blog</h1>
  <?php if (isset($_SESSION['user_id'])): ?>
    <p>Welcome, <?= e($_SESSION['username']) ?> (<?= e($_SESSION['role']) ?>) |
      <a href="add_post.php">Add Post</a> |
      <a href="logout.php">Logout</a>
    </p>
  <?php else: ?>
    <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
  <?php endif; ?>

  <?php foreach ($posts as $post): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h4><?= e($post['title']) ?></h4>
        <p><?= nl2br(e($post['content'])) ?></p>
        <small>By <?= e($post['username']) ?> on <?= $post['created_at'] ?></small>
        <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'admin' || $_SESSION['user_id'] == $post['author_id'])): ?>
          <br>
          <a href="edit_post.php?id=<?= $post['id'] ?>">Edit</a> |
          <a href="delete_post.php?id=<?= $post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
