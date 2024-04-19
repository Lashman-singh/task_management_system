<nav style="background: linear-gradient(to right, #4e54c8, #8f94fb); padding: 20px 0; text-align: center;">
    <a href="index.php" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 18px;">Home</a>
    <?php if(basename($_SERVER['PHP_SELF']) !== 'register_user.php'): ?>
        <a href="register_user.php" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 18px;">Register New User</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'add_task.php'): ?>
        <a href="add_task.php" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 18px;">Add New Task</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
        <a href="profile.php" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 18px;">Profile</a> 
    <?php endif; ?>
    
    <?php if ($_SESSION['logged_in']): ?>
    <a href="logout.php" style="color: #fff; text-decoration: none; margin: 0 10px; font-size: 18px;">Logout</a>
    <?php endif; ?>

    <form action="dashboard.php" method="POST" id="switch_form" style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
        <input type="hidden" name="switch_user" value="<?= ($_SESSION['user_type'] === 'admin') ? 'simple' : 'admin'; ?>">
        <?php if ($_SESSION['user_type'] === 'admin'): ?>
            <button type="submit" style="padding: 8px 20px; background-color: #4e54c8; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; margin: 0 auto;">User</button>
        <?php else: ?>
            <label for="username" style="font-weight: bold;">Username:</label>
            <input type="text" id="username" name="username" required style="padding: 8px; margin: 0 5px; border: 1px solid #ccc; border-radius: 5px;">
            <label for="password" style="font-weight: bold;">Password:</label>
            <input type="password" id="password" name="password" required style="padding: 8px; margin: 0 5px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="padding: 8px 20px; background-color: #4e54c8; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Admin</button>
        <?php endif; ?>
    </form>
</nav>
