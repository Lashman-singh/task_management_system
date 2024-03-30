<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        try {
            $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
            $query = "DELETE FROM Task WHERE task_id = :task_id";
            $statement = $db->prepare($query);
            $statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                header("Location: index.php");
                exit;
            } else {
                echo "Error: Task not found or already deleted.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "You are not authorized to perform this action.";
    }
} else {
    echo "<p>No task selected.</p>";
}
?>
