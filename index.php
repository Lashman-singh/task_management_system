<?php
require('authenticate.php');
require('connect.php');
include('nav.php');

// Function to delete a task
function deleteTask($db, $task_id) {
    try {
        $query = "DELETE FROM task WHERE task_id = :task_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to delete a comment
function deleteComment($db, $comment_id) {
    try {
        $query = "DELETE FROM comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Check if the form is submitted for task deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_task'])) {
        $task_id = filter_input(INPUT_POST, 'delete_task_id', FILTER_SANITIZE_NUMBER_INT);
        deleteTask($db, $task_id);
        // Redirect back to index.php after deletion
        header('Location: index.php');
        exit();
    }
    if (isset($_POST['delete_comment'])) {
        $comment_id = filter_input(INPUT_POST, 'delete_comment_id', FILTER_SANITIZE_NUMBER_INT);
        deleteComment($db, $comment_id);
        // Redirect back to index.php after deletion
        header('Location: index.php');
        exit();
    }
}

// Fetch all tasks from the database
$query = "SELECT * FROM task";
$statement = $db->query($query);
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Employees Tasks</h1>

    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Category</th>
            <th>Assigned To</th>
            <th>Actions</th>
            <th>Comments</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= $task['title'] ?></td>
                <td><?= $task['description'] ?></td>
                <td><?= $task['priority'] ?></td>
                <td><?= $task['deadline'] ?></td>
                <td><?= $task['status'] ?></td>
                <td><?= $task['category_id'] ?></td>
                <td><?= $task['user_id'] ?></td>
                <td>
                    <a href="edit_task.php?id=<?= $task['task_id'] ?>">Edit</a> |
                    <form action="" method="POST" style="display: inline;">
                        <input type="hidden" name="delete_task_id" value="<?= $task['task_id'] ?>">
                        <button type="submit" name="delete_task" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                    </form>
                </td>
                <td>
                    <ul>
                        <?php
                        $task_id = $task['task_id'];
                        $comment_query = "SELECT * FROM comment WHERE task_id = :task_id";
                        $comment_statement = $db->prepare($comment_query);
                        $comment_statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
                        $comment_statement->execute();
                        $comments = $comment_statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($comments as $comment): ?>
                            <li><?= $comment['comment'] ?>
                                <form action="" method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_comment_id" value="<?= $comment['comment_id'] ?>">
                                    <button type="submit" name="delete_comment" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <form action="add_comment.php" method="POST">
                        <input type="hidden" name="task_id" value="<?= $task_id ?>">
                        <input type="text" name="comment" placeholder="Add a comment">
                        <button type="submit">Add Comment</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include('footer.php'); ?>
</body>
</html>
