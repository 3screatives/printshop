<?php
session_start();
require_once '../ps-admin/db_function.php';

$conn = db_connect();

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Fetch user
$user = select_query(
    $conn,
    "SELECT user_id, user_name, user_password, user_type
     FROM ps_users
     WHERE user_email = ?
     LIMIT 1",
    "s",
    $email
);

if (count($user) !== 1) {
    header("Location: login.php?error=User not found");
    exit;
}

$user = $user[0];

// ⚠️ Plain text check (upgrade later)
if ($password !== $user['user_password']) {
    header("Location: login.php?error=Invalid password");
    exit;
}

// Set sessions based on role
if (in_array($user['user_type'], ['admin', 'manager', 'viewer'], true)) {

    // 🔐 Admin session
    $_SESSION['admin_user_id']   = $user['user_id'];
    $_SESSION['admin_user_name'] = $user['user_name'];
    $_SESSION['admin_user_type'] = $user['user_type'];

    header("Location: ../ps-admin/index.php");
    exit;
}

// ✅ Client session
if ($user['user_type'] === 'client') {

    $_SESSION['client_user_id']   = $user['user_id'];
    $_SESSION['client_user_name'] = $user['user_name'];
    $_SESSION['client_user_type'] = $user['user_type'];

    header("Location: dashboard.php");
    exit;
}

// ❌ Unknown role
session_destroy();
header("Location: login.php?error=Invalid role");
exit;
