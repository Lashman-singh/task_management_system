<?php
session_start();
require('connect.php');
include('nav.php');

if ($_SESSION['user_type'] !== 'admin') {
    echo "<h2 style='text-align: center;'>Only admin can view this page</h2>";
    include('footer.php');
    exit;
}

$query = "SELECT * FROM Employee"; 
$statement = $db->query($query);
$employees = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profiles</title>
    <link rel="stylesheet" href="nav_footer.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <h1 style="text-align: center;">Registered Employees</h1>

    <?php foreach ($employees as $employee): ?> 
        <div class="user-profile">
            <h2><?php echo $employee['username']; ?></h2> 
            <p><b>Department:</b> <?php echo $employee['department']; ?></p>
            <p><b>Role:</b> <?php echo $employee['role']; ?></p>
            <?php if ($employee['image_filename']): ?>
                <img src="uploads/<?php echo $employee['image_filename']; ?>" alt="Profile Image">
                <form action="remove_image.php" method="POST">
                    <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>"> 
                    <button type="submit" name="delete_image">Delete Image</button>
                </form>
            <?php else: ?>
                <p>No profile picture available.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <?php include('footer.php'); ?>
</body>
</html>
