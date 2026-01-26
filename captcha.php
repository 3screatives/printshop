<?php
session_start();

header("Content-Type: image/png");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

$chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
$captcha = "";

for ($i = 0; $i < 5; $i++) {
    $captcha .= $chars[random_int(0, strlen($chars) - 1)];
}

$image = imagecreate(120, 40);
$bg    = imagecolorallocate($image, 102, 102, 153);
$text  = imagecolorallocate($image, 255, 255, 255);

imagestring($image, 5, 22, 12, $captcha, $text);

imagepng($image);
imagedestroy($image);

$_SESSION['img_number'] = $captcha;
exit;
