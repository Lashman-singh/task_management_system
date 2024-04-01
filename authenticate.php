<?php
session_start();

define('ADMIN_LOGIN', 'wally');
define('ADMIN_PASSWORD', 'mypass');

if (!isset($_SESSION['username']) || !isset($_SESSION['user_type'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Task Management System"');
    exit("Access Denied: Username and password required.");
} else {
    if ($_SESSION['username'] === ADMIN_LOGIN && $_SESSION['user_type'] === 'admin') {
    }
}
?>
