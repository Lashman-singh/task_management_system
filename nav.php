<nav>
    <a href="index.php">Home</a>
    <?php if(basename($_SERVER['PHP_SELF']) !== 'register_user.php'): ?>
        <a href="register_user.php">Register New User</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'add_task.php'): ?>
        <a href="add_task.php">Add New Task</a>
    <?php endif; ?>

    <form action="dashboard.php" method="POST" id="switch_form">
        <input type="submit" id="switch_user" name="switch_user" value="Switch to <?= ($_SESSION['user_type'] === 'admin') ? 'Simple' : 'Admin'; ?> User">
    </form>
</nav>
