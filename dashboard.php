<?php
session_start();

if (isset($_POST['switch_user'])) {
    $_SESSION['user_type'] = ($_SESSION['user_type'] === 'admin') ? 'simple' : 'admin';
}

if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
