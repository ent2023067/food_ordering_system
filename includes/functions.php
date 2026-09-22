<?php
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: auth/login.php");
        exit;
    }
}
function require_admin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../auth/login.php");
        exit;
    }
}
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>