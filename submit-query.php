<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.php');
    exit;
}

// Sanitize inputs
$full_name     = trim($_POST['full_name'] ?? '');
$email         = trim($_POST['email'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$business_name = trim($_POST['business_name'] ?? '');
$query         = trim($_POST['query'] ?? '');
$captcha       = trim($_POST['captcha'] ?? '');

// Validate captcha
if (empty($_SESSION['captcha_code']) || strcasecmp($captcha, $_SESSION['captcha_code']) !== 0) {
    $_SESSION['form_error'] = 'Invalid captcha. Please try again.';
    header('Location: form.php');
    exit;
}

// Clear captcha
unset($_SESSION['captcha_code']);

// Email
$to = 'info@stmaprinting.com';
$subject = 'New Website Query';
$headers = "From: {$full_name} <{$email}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

$message = "
Full Name: $full_name
Email: $email
Phone: $phone
Business Name: $business_name

Query:
$query
";

mail($to, $subject, $message, $headers);

// ✅ Set success flag
$_SESSION['form_success'] = true;

// Redirect back to form page
header('Location: get-a-quote.php');
exit;