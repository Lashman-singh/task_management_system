<?php
session_start();
require('connect.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 

    if ($password !== $confirm_password) {
        $signup_error = "Passwords do not match. Please try again.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM User WHERE username = :username OR email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $existing_user = $statement->fetch();

        if ($existing_user) {
            $signup_error = "Username or email already exists. Please choose different credentials.";
        } else {
            $query = "INSERT INTO User (username, email, password) VALUES (:username, :email, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $hashed_password); 
            $statement->execute();

            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <h2>Sign Up</h2>
            <?php if(isset($signup_error)) echo "<p class='error'>$signup_error</p>"; ?>
            <form action="" method="POST">
                <label for="new_username">Username:</label>
                <input type="text" id="new_username" name="username" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="password" required><br><br>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                <input type="submit" name="signup" value="Sign Up">
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
