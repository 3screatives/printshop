<?php
session_start();

// Make sure GD is available
if (!extension_loaded('gd')) {
    http_response_code(500);
    exit('GD extension not enabled');
}

header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// Generate captcha text
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha = '';
for ($i = 0; $i < 5; $i++) {
    $captcha .= $chars[random_int(0, strlen($chars) - 1)];
}

// Store captcha in session
$_SESSION['captcha_code'] = $captcha;

// Create image
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height);

// Colors
$bg = imagecolorallocate($image, 245, 245, 245);
$text = imagecolorallocate($image, 40, 40, 40);
$noise = imagecolorallocate($image, 180, 180, 180);

// Background
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Noise
for ($i = 0; $i < 80; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise);
}

// Text
$fontSize = 5;
$x = 15;
$y = 12;
imagestring($image, $fontSize, $x, $y, $captcha, $text);

// Output image
imagepng($image);

// Free memory (NOT deprecated)
imagedestroy($image);