<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $comment_content = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO comment (task_id, user_id, comment) VALUES (:task_id, :user_id, :comment_content)";
    $statement = $db->prepare($query);
    $statement->execute(array(':task_id' => $task_id, ':user_id' => $user_id, ':comment_content' => $comment_content));

    header('Location: index.php');
    exit();
}
?>
