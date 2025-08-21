<?php
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

function requireRole($roles = []) {
    if (!in_array($_SESSION['role'], $roles)) {
        http_response_code(403);
        exit("Forbidden");
    }
}
