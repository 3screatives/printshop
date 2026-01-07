<?php
$allowed_ips = [
    '127.0.0.1',
    '::1',          // IPv6 localhost
    '192.168.1.96',
    '172.16.1.120'
];

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if (!$is_admin) {
    if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips, true)) {
        http_response_code(403);
        exit('Access denied');
    }
}