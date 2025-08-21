<?php
require_once __DIR__ . '/guards.php';
requireRole(['admin','editor','user']);

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    exit("Post not found");
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $post['author_id']) {
    exit("Forbidden");
}

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
