<?php
session_start();

function generateCaptcha($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

$_SESSION['captcha'] = generateCaptcha();

function generateCaptchaImage($captcha) {
    $image = imagecreate(150, 50);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, 50, 20, $captcha, $text_color);
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
}

generateCaptchaImage($_SESSION['captcha']);
?>
