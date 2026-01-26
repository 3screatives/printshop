<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request');
}

// Sanitize inputs
$fullName = trim($_POST['full_name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$business = trim($_POST['business_name'] ?? '');
$query    = trim($_POST['query'] ?? '');
$captcha  = trim($_POST['captcha'] ?? '');

// Basic validation
if ($fullName === '' || $email === '' || $phone === '' || $query === '') {
    die('Please fill in all required fields.');
}

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}

// CAPTCHA validation (case-insensitive)
if (strcasecmp($captcha, $_SESSION['img_number'] ?? '') !== 0) {
    die('Invalid captcha.');
}

// Clear captcha after use
unset($_SESSION['img_number']);

// ============================
// EMAIL SETUP
// ============================
$to = "info@stmaprinting.com";
$subject = "New Website Query – STMA Printing";

$message = "
New query received from the website:

Full Name: {$fullName}
Email: {$email}
Phone: {$phone}
Business Name: {$business}

Query:
{$query}
";

$headers = [
    "From: STMA Printing Website <no-reply@stmaprinting.com>",
    "Reply-To: {$email}",
    "Content-Type: text/plain; charset=UTF-8"
];

// Send email
$sent = mail($to, $subject, $message, implode("\r\n", $headers));

if ($sent) {
    echo "Thank you! Your message has been sent successfully.";
} else {
    echo "Sorry, something went wrong. Please try again later.";
}
