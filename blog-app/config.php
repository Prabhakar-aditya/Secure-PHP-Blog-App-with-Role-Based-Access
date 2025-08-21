<?php
ini_set('session.use_strict_mode', 1);
session_start([
  'cookie_httponly' => true,
  'cookie_samesite' => 'Lax',
]);

require_once __DIR__ . '/db.php';

// Safe echo
function e($s) {
  return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// CSRF
function generate_csrf_token() {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}
function verify_csrf_token($token) {
  return !empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
