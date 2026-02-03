<?php
// Must be logged in as admin-type user
if (
    !isset($_SESSION['admin_user_id'], $_SESSION['admin_user_type'])
) {
    header("Location: users/login.php");
    exit;
}

$allowed_ips = [
    '127.0.0.1',
    '::1',
    '192.168.1.96',
    '172.16.1.120'
];

$userType = $_SESSION['admin_user_type'];

// ✅ Admin → always allowed
if ($userType === 'admin') {
    return;
}

// 🔒 Manager & Viewer → IP restricted
if (in_array($userType, ['manager', 'viewer'], true)) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if (!in_array($ip, $allowed_ips, true)) {
        http_response_code(403);
        exit('Access denied (IP restricted)');
    }
    return;
}

// ❌ Anything else (client, unknown role)
header("Location: ../users/dashboard.php");
exit;
