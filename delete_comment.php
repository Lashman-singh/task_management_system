<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        try {
            $comment_id = filter_input(INPUT_POST, 'delete_comment_id', FILTER_SANITIZE_NUMBER_INT);
            $task_id = $_POST['task_id'];

            $query = "DELETE FROM Comment WHERE comment_id = :comment_id";
            $statement = $db->prepare($query);
            $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                header("Location: task_details.php?id=$task_id");
                exit();
            } else {
                echo "Error: Comment not found or already deleted.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "You are not authorized to perform this action.";
    }
} else {
    echo "<p>No comment selected.</p>";
}
?>
