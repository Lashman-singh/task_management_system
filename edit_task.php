<?php
require('authenticate.php');
require('connect.php');

if ($_SESSION['user_type'] !== 'admin') {
    echo "You are not authorized to access this page.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    if ($_POST['command'] === 'Update Task' && isset($_POST['task_id'])) {
        try {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_STRING);
            $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);

            $query = "UPDATE task SET title = :title, description = :description, priority = :priority, 
                      deadline = :deadline, status = :status, category_id = :category_id
                      WHERE task_id = :task_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':priority', $priority);
            $statement->bindValue(':deadline', $deadline);
            $statement->bindValue(':status', $status);
            $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statement->bindValue(':task_id', $task_id, PDO::PARAM_INT);
            $statement->execute();
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif ($_POST['command'] === 'Delete' && isset($_POST['task_id'])) {
        try {
            $task_id = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_NUMBER_INT);
            $query = "DELETE FROM task WHERE task_id = :task_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':task_id', $task_id, PDO::PARAM_INT);
            $statement->execute();
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif ($_POST['command'] === 'Add Task') {
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM task WHERE task_id = :task_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id, PDO::PARAM_INT);
        $statement->execute();
        $task = $statement->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task</h1>
    <form action="" method="POST">
        <label>Title: </label><input type="text" name="title" value="<?= $task['title'] ?>"><br>
        <label>Description: </label><input type="text" name="description" value="<?= $task['description'] ?>"><br>
        <label>Priority: </label>
        <select name="priority">
            <option value="High" <?= ($task['priority'] === 'High') ? 'selected' : ''; ?>>High Priority</option>
            <option value="Medium" <?= ($task['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium Priority</option>
            <option value="Low" <?= ($task['priority'] === 'Low') ? 'selected' : ''; ?>>Low Priority</option>
            <option value="Not Priority" <?= ($task['priority'] === 'Not Priority') ? 'selected' : ''; ?>>Not a Priority</option>
        </select><br>
        <label>Deadline: </label><input type="date" name="deadline" value="<?= $task['deadline'] ?>"><br>
        <label>Status: </label><input type="text" name="status" value="<?= $task['status'] ?>"><br>
        <label>Category ID: </label><input type="number" name="category_id" value="<?= $task['category_id'] ?>"><br>
        <input type="hidden" name="task_id" value="<?= $task_id ?>">
        <input type="submit" name="command" value="Update Task">
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you want to delete this task?')">
    </form>
</body>
</html>
<?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>No task selected.</p>";
}
?>
