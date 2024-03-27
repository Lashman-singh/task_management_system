<?php
session_start();
define('ADMIN_LOGIN', 'wally');
define('ADMIN_PASSWORD', 'mypass');

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
    || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Task Management System"');
    exit("Access Denied: Username and password required.");
}
?>
