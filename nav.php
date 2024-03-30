<nav>
    <a href="index.php">Home</a>
    <a href="register_user.php">Register New User</a>

    <?php if ($_SESSION['user_type'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'add_task.php'): ?>
        <a href="add_task.php">Add New Task</a>
    <?php endif; ?>

    <form action="dashboard.php" method="POST">
        <input type="submit" name="switch_user" value="Switch to <?= ($_SESSION['user_type'] === 'admin') ? 'Simple' : 'Admin'; ?> User">
    </form>
</nav>
