<?php
session_start();
require('connect.php');
include('nav.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_message = '';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    $image_filename = '';
    $image_data = '';
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_filename = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path = 'uploads/' . $image_filename;

        $allowed_image_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
        $image_info = getimagesize($temporary_image_path);
        if ($image_info !== false && in_array($image_info[2], $allowed_image_types)) {
            if (move_uploaded_file($temporary_image_path, $new_image_path)) {
                $image_data = file_get_contents($new_image_path);
            } else {
                $error_message = "Image upload failed. Please try again.";
            }
        } else {
            $error_message = "Uploaded file is not a supported image type. Please upload a JPEG, PNG, or GIF file.";
        }
    } else {
        $error_message = "No file uploaded or an error occurred during file upload.";
    }

    if (empty($error_message)) {
        unset($error_message);

        $query = "INSERT INTO User (username, password, department, role, image_filename, image_data) VALUES (:username, :password, :department, :role, :image_filename, :image_data)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':department', $department);
        $statement->bindValue(':role', $role);
        $statement->bindValue(':image_filename', $image_filename);
        $statement->bindValue(':image_data', $image_data, PDO::PARAM_LOB);
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
    <title>Register new employee</title>
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
        <input type="submit" value="Register" id="register">
    </form>
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function() {
            document.getElementById('file_name').textContent = this.files[0].name;
        });
    </script>
    <?php include('footer.php'); ?> 
</body>
</html>
