<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $comment_content = $_POST['comment'];
    $employee_id = $_SESSION['employee_id']; 

    $query = "INSERT INTO Comment (task_id, employee_id, comment) VALUES (:task_id, :employee_id, :comment_content)";
    $statement = $db->prepare($query);
    $statement->execute(array(':task_id' => $task_id, ':employee_id' => $employee_id, ':comment_content' => $comment_content));

    header('Location: index.php');
    exit();
}
?>

