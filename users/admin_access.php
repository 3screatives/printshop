<?php
// Must be logged in
if (!isset($_SESSION['user_id'], $_SESSION['user_type'])) {
    header("Location: ../users/login.php");
    exit;
}

$allowed_ips = [
    '127.0.0.1',
    '::1',
    '192.168.1.96',
    '172.16.1.120'
];

// Admins: always allowed
if ($_SESSION['user_type'] === 'admin') {
    return;
}

// Managers & viewers: IP-restricted
if (in_array($_SESSION['user_type'], ['manager', 'viewer'], true)) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!in_array($ip, $allowed_ips, true)) {
        http_response_code(403);
        exit('Access denied (IP restricted)');
    }
    return;
}

// Clients or anything else → send to client dashboard
header("Location: ../users/dashboard.php");
exit;
