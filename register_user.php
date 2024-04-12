<?php
session_start();
require('connect.php');
include('nav.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $error_message = '';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $department = $_POST['department'];
    
    $role = $_POST['role'];

    $image_filename = '';
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $temporary_image_path = $_FILES['image']['tmp_name'];

        $image_type = exif_imagetype($temporary_image_path);
        if ($image_type === IMAGETYPE_PNG) {
            
            $original_image = imagecreatefrompng($temporary_image_path);

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            $max_width = 500;
            $max_height = 500;
            $aspect_ratio = $original_width / $original_height;

            if ($original_width > $max_width || $original_height > $max_height) {
                if ($aspect_ratio > 1) {
                    $new_width = $max_width;
                    $new_height = $max_width / $aspect_ratio;
                } else {
                    $new_width = $max_height * $aspect_ratio;
                    $new_height = $max_height;
                }
            } else {
                $new_width = $original_width;
                $new_height = $original_height;
            }

            $resized_image = imagecreatetruecolor($new_width, $new_height);

            imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

            $image_filename = uniqid() . '.png';
            $new_image_path = 'uploads/' . $image_filename;
            imagepng($resized_image, $new_image_path);

            imagedestroy($original_image);
            imagedestroy($resized_image);
        } else {
            $error_message = "Uploaded file is not a PNG image. Please upload a valid PNG file.";
        }
    }

    if (empty($error_message)) {
        unset($error_message);

        $query = "INSERT INTO Employee (username, password, department, role, image_filename) VALUES (:username, :password, :department, :role, :image_filename)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':department', $department);
        $statement->bindValue(':role', $role);
        $statement->bindValue(':image_filename', $image_filename);
        $statement->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register An Employee</title>
    <link rel="stylesheet" href="register_user.css">
    <link rel="stylesheet" href="nav_footer.css">
</head>
<body>
    <h1>Register An Employee</h1>
    <?php if(isset($error_message)) echo $error_message; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Department:</label>
        <input type="text" name="department" required><br>
        <label>Role:</label>
        <input type="text" name="role" required><br>
        <div style="text-align: center;">
            <label for="image" style="display: block;">Upload Image:</label>
            <input type="file" name="image" id="image" style="display: inline-block;">
        </div>
        <br>
        <input type="submit" name="register" value="Register" id="register">
    </form>

    <?php include('footer.php'); ?> 
</body>
</html>
