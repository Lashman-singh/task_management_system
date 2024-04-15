<?php
session_start();
require('connect.php');
include('nav.php');

if(isset($_POST['comment'])) {
    if ($_POST['captcha'] !== $_SESSION['captcha']) {
        $error = "Incorrect CAPTCHA. Please try again.";
    } else {
        $new_comment = $_POST['comment'];
        $employee_id = $_SESSION['employee_id'];
        $task_id = $_GET['id'];

        $insert_query = "INSERT INTO Comment (task_id, employee_id, comment) VALUES (:task_id, :employee_id, :comment)";
        $insert_statement = $db->prepare($insert_query);
        $insert_statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
        $insert_statement->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $insert_statement->bindParam(':comment', $new_comment, PDO::PARAM_STR);
        $insert_statement->execute();

        header("Location: task_details.php?id=$task_id");
        exit();
    }
}

if(isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $query = "SELECT Task.*, Employee.username AS assigned_to, Categories.category_name AS category 
              FROM Task 
              LEFT JOIN Employee ON Task.employee_id = Employee.employee_id 
              LEFT JOIN Categories ON Task.category_id = Categories.category_id 
              WHERE Task.task_id = :task_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $statement->execute();
    $task = $statement->fetch(PDO::FETCH_ASSOC);

    $comment_query = "SELECT * FROM Comment WHERE task_id = :task_id";
    $comment_statement = $db->prepare($comment_query);
    $comment_statement->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $comment_statement->execute();
    $comments = $comment_statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Task ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="task_details.css">
</head>
<body>
    <div class="container">
        <div class="center-align">
            <h1>Task Details</h1>
        </div>
        <p><strong>Title:</strong> <?php echo $task['title']; ?></p>
        <p><strong>Description:</strong> <?php echo $task['description']; ?></p>
        <p><strong>Priority:</strong> <?php echo $task['priority']; ?></p>
        <p><strong>Deadline:</strong> <?php echo $task['deadline']; ?></p>
        <p><strong>Status:</strong> <?php echo $task['status']; ?></p>

        <div class="center-align">
            <h2>Comments</h2>
        </div>
        <?php if(count($comments) > 0): ?>
            <ul class="comments-list">
                <?php foreach($comments as $comment): ?>
                    <li>
                        <div class="comment-content">
                            <?= $comment['comment'] ?>
                        </div>
                        <?php if ($_SESSION['user_type'] === 'admin'): ?>
                            <form action="delete_comment.php" method="post" class="delete-comment-form">
                                <input type="hidden" name="delete_comment_id" value="<?= $comment['comment_id'] ?>">
                                <input type="hidden" name="task_id" value="<?= $task_id ?>">
                                <button type="submit" name="delete_comment" class="delete-btn">Delete</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments found for this task.</p>
        <?php endif; ?>

        <div class="center-align">
            <h2>Add Comment</h2>
        </div>
        <form action="task_details.php?id=<?= $task_id ?>" method="post">
            <textarea name="comment" rows="4" cols="50" required></textarea><br>
            <label for="captcha">Enter CAPTCHA: </label>
            <input type="text" name="captcha" id="captcha" required>
            <img src="captcha_image.php" alt="CAPTCHA Image">
            <button type="submit">Add Comment</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
