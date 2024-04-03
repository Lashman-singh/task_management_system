<nav>
    <a href="index.php">Home</a>
    <?php if(basename($_SERVER['PHP_SELF']) !== 'register_user.php'): ?>
        <a href="register_user.php">Register New User</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'add_task.php'): ?>
        <a href="add_task.php">Add New Task</a>
    <?php endif; ?>

    <form action="dashboard.php" method="POST" id="switch_form">
        <input type="hidden" name="switch_user" value="<?= ($_SESSION['user_type'] === 'admin') ? 'simple' : 'admin'; ?>">
        <?php if ($_SESSION['user_type'] === 'admin'): ?>
            <button type="submit">User</button>
        <?php else: ?>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Admin</button>
        <?php endif; ?>
    </form>
</nav>
