<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    try {
        // Delete task
        $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
        $query = "DELETE FROM task WHERE task_id = :task_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id, PDO::PARAM_INT);

        // Execute the deletion query
        $statement->execute();

        // Check if any rows were affected
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
    echo "<p>No task selected.</p>";
}
?>
