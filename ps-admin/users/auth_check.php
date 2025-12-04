<?php
session_start();

// If no session → block
if (!isset($_SESSION['user_type'])) {
    die("Access denied.");
}

// ===================== ADMIN ACCESS =====================
if ($_SESSION['user_type'] === 'admin') {
    // Admin has full access to everything — no redirects
    return;
}

// ===================== NON-ADMIN ACCESS ONLY =====================
$current_page = basename($_SERVER['PHP_SELF']);

// Only allow edit_user.php for non-admin
if ($current_page !== 'edit_user.php') {
    header("Location: edit_user.php?id=" . $_SESSION['user_id']);
    exit();
}

// Non-admin cannot edit another user
if (isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    header("Location: edit_user.php?id=" . $_SESSION['user_id']);
    exit();
}
