<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    $query = "INSERT INTO User (username, password, department, role) VALUES (:username, :password, :department, :role)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':department', $department);
    $statement->bindValue(':role', $role);
    $statement->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register new employee</title>
</head>
<body>
    <h1>Register An Employee</h1>
    <form action="" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Department:</label>
        <input type="text" name="department" required><br>
        <label>Role:</label>
        <input type="text" name="role" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
