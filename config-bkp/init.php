<?php
// init.php - include at top of pages that need sessions/auth helpers
// start secure session settings

// Force secure cookie settings (adjust for your environment)
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'; // true if HTTPS
$httponly = true;

// Start session with custom params to reduce session fixation risks
session_set_cookie_params([
    'lifetime' => 0,           // session cookie until browser close
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $secure,
    'httponly' => $httponly,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID on new session to prevent fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

/**
 * Helper to require login (redirects to login.php)
 */
function require_login()
{
    if (empty($_SESSION['customer_id'])) {
        // optionally pass return URL
        header('Location: login.php');
        exit;
    }
}

/**
 * Helper to get logged in user's name (if loaded into session)
 */
function current_user_name()
{
    return $_SESSION['customer_name'] ?? null;
}
