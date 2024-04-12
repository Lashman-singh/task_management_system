<?php
session_start();
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $user_id = $_POST['user_id'];

    $query = "SELECT image_filename FROM User WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':user_id', $user_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $image_filename = $result['image_filename'];

    if ($image_filename) {
        $update_query = "UPDATE User SET image_filename = NULL WHERE user_id = :user_id";
        $update_statement = $db->prepare($update_query);
        $update_statement->bindParam(':user_id', $user_id);
        $update_statement->execute();

        $image_path = 'uploads/' . $image_filename;
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        header("Location: profile.php");
        exit;
    } else {
        echo "No image found for this user.";
    }
} else {
    header("Location: profile.php");
    exit;
}
?>
