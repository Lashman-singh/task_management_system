<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $comment_content = $_POST['comment']; // Adjusted variable name
    $user_id = $_SESSION['user_id']; // Assuming you store user ID in the session

    // Insert the comment into the database
    $query = "INSERT INTO comment (task_id, user_id, comment) VALUES (:task_id, :user_id, :comment_content)"; // Adjusted table name and variable name
    $statement = $db->prepare($query);
    $statement->execute(array(':task_id' => $task_id, ':user_id' => $user_id, ':comment_content' => $comment_content)); // Adjusted variable name

    // Redirect back to the task page after adding the comment
    header('Location: index.php');
    exit();
}
?>
