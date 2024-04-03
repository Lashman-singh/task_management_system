<?php
session_start();

define('ADMIN_LOGIN', 'wally');
define('ADMIN_PASSWORD', 'mypass');

if (!isset($_SESSION['username']) || !isset($_SESSION['user_type'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user_type'] !== 'admin') {
    $restricted_pages = array('add_task.php', 'dashboard.php');
    if (in_array(basename($_SERVER['PHP_SELF']), $restricted_pages)) {
        header('HTTP/1.1 403 Forbidden');
        exit("Forbidden: You don't have permission to access this page.");
    }
}
?>
