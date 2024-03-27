<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_type'])) {
    $_SESSION['user_type'] = ($_SESSION['user_type'] === 'admin') ? 'simple' : 'admin';
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <form action="" method="POST">
        <input type="submit" name="user_type" value="Switch to <?php echo ($_SESSION['user_type'] === 'admin') ? 'Simple' : 'Admin'; ?> User">
    </form>
</body>
</html>
