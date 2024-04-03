<?php
session_start();

if (isset($_POST['switch_user']) && $_POST['switch_user'] === 'admin') {
    if ($_POST['username'] === 'wally' && $_POST['password'] === 'mypass') {
        $_SESSION['user_type'] = 'admin';
    } else {
        header("Location: {$_SERVER['HTTP_REFERER']}?error=1");
        exit;
    }
} elseif (isset($_POST['switch_user']) && $_POST['switch_user'] === 'simple') {
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
