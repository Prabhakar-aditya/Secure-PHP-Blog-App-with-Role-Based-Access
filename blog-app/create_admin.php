<?php
require_once __DIR__ . '/config.php';

$username = 'admin';
$password = 'Admin@123'; // your admin password
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->execute([$username, $hash]);

echo "Admin user created: $username / $password";
