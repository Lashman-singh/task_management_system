<?php
session_start();
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $employee_id = $_POST['employee_id'];

    $query = "SELECT image_filename FROM Employee WHERE employee_id = :employee_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':employee_id', $employee_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $image_filename = $result['image_filename'];

    if ($image_filename) {
        $image_path = 'uploads/' . $image_filename;
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $update_query = "UPDATE Employee SET image_filename = NULL WHERE employee_id = :employee_id";
        $update_statement = $db->prepare($update_query);
        $update_statement->bindParam(':employee_id', $employee_id);
        $update_statement->execute();

        $delete_query = "DELETE FROM images WHERE filename = :image_filename";
        $delete_statement = $db->prepare($delete_query);
        $delete_statement->bindParam(':image_filename', $image_filename);
        $delete_statement->execute();

        header("Location: profile.php");
        exit;
    } else {
        echo "No image found for this employee.";
    }
} else {
    header("Location: profile.php");
    exit;
}
?>
