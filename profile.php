<?php
session_start();
require('connect.php');
include('nav.php');

// Fetch all user data including images
$query = "SELECT * FROM User";
$statement = $db->query($query);
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profiles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>User Profiles</h1>

    <?php foreach ($users as $user): ?>
        <div class="user-profile">
            <h2><?php echo $user['username']; ?></h2>
            <p>Department: <?php echo $user['department']; ?></p>
            <p>Role: <?php echo $user['role']; ?></p>
            <?php if ($user['image_filename']): ?>
                <img src="uploads/<?php echo $user['image_filename']; ?>" alt="Profile Image">
                <!-- Form to remove image -->
                <form action="remove_image.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
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
