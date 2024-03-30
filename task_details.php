<?php
require('connect.php');

if(isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $query = "SELECT * FROM task WHERE task_id = :task_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $statement->execute();
    $task = $statement->fetch(PDO::FETCH_ASSOC);

    $comment_query = "SELECT * FROM comment WHERE task_id = :task_id";
    $comment_statement = $db->prepare($comment_query);
    $comment_statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $comment_statement->execute();
    $comments = $comment_statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Task ID not provided.";
    exit();
}

if(isset($_POST['comment'])) {
    $new_comment = $_POST['comment'];
    $user_id = 1;

    $insert_query = "INSERT INTO comment (task_id, user_id, comment) VALUES (:task_id, :user_id, :comment)";
    $insert_statement = $db->prepare($insert_query);
    $insert_statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $insert_statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $insert_statement->bindParam(':comment', $new_comment, PDO::PARAM_STR);
    $insert_statement->execute();

    header("Location: task_details.php?id=$task_id");
    exit();
}

if(isset($_POST['delete_comment']) && isset($_POST['delete_comment_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        $comment_id = $_POST['delete_comment_id'];

        $delete_query = "DELETE FROM comment WHERE comment_id = :comment_id";
        $delete_statement = $db->prepare($delete_query);
        $delete_statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $delete_statement->execute();

        header("Location: task_details.php?id=$task_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
</head>
<body>
    <a href="index.php">Home</a>
    <h1>Task Details</h1>
    <h2><?= $task['title'] ?></h2>
    <p>Description: <?= $task['description'] ?></p>
    <p>Priority: <?= $task['priority'] ?></p>
    <p>Deadline: <?= $task['deadline'] ?></p>
    <p>Status: <?= $task['status'] ?></p>

    <h2>Add Comment</h2>
    <form action="" method="post">
        <textarea name="comment" rows="4" cols="50" required></textarea><br>
        <button type="submit">Add Comment</button>
    </form>

    <h2>Comments</h2>
    <?php if(count($comments) > 0): ?>
        <ul>
            <?php foreach($comments as $comment): ?>
                <li>
                    <?= $comment['comment'] ?>
                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="delete_comment_id" value="<?= $comment['comment_id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No comments found for this task.</p>
    <?php endif; ?>
</body>
</html>
