<?php
require('authenticate.php');
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_STRING);
    $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $assigned_to = filter_input(INPUT_POST, 'assigned_to', FILTER_SANITIZE_NUMBER_INT);

    $query = "INSERT INTO task (title, description, priority, deadline, status, category_id, assigned_to) 
              VALUES (:title, :description, :priority, :deadline, :status, :category_id, :assigned_to)";
    $statement = $db->prepare($query);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':priority', $priority);
    $statement->bindParam(':deadline', $deadline);
    $statement->bindParam(':status', $status);
    $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $statement->bindParam(':assigned_to', $assigned_to, PDO::PARAM_INT);

    if ($statement->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: Unable to create task.";
    }
}

header("Location: index.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Task Management System</title>
</head>
<body>
<header class="my-header">
    <div class="text-area">
        <h1>Task Management System</h1>
    </div>
</header>  

<?php include('nav.php');?>

<main class="recent-container" id="create-task">
    <form action="post.php" method="POST">
        <h2>New task!</h2>

        <div class="group-form">
            <label for="title">Title <br><br> </label>
            <input type="text" name="title" id="title" minlength="1" required>
        </div><br><br>

        <div class="group-form">
            <label for="description">Description </label><br><br>
            <textarea name="description" id="description" cols="70" rows="8" minlength="1" required></textarea>
        </div><br><br>

        <div class="group-form">
            <label for="priority">Priority</label><br><br>
            <input type="text" name="priority" id="priority" minlength="1" required>
        </div><br><br>

        <div class="group-form">
            <label for="deadline">Deadline</label><br><br>
            <input type="text" name="deadline" id="deadline" minlength="1" required>
        </div><br><br>

        <div class="group-form">
            <label for="status">Status</label><br><br>
            <input type="text" name="status" id="status" minlength="1" required>
        </div><br><br>

        <div class="group-form">
            <label for="category_id">Category ID</label><br><br>
            <input type="text" name="category_id" id="category_id" minlength="1" required>
        </div><br><br>

        <div class="group-form">
            <label for="assigned_to">Assigned To</label><br><br>
            <input type="text" name="assigned_to" id="assigned_to" minlength="1" required>
        </div><br><br>

        <button type="submit" class="primary-button">Submit!</button>
    </form>
</main> 

<?php include('footer.php'); ?>
</body>
</html>
