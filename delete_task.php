<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM Comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->execute();

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
