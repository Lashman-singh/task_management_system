<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_task.css">
    <title>Edit Task</title>
    <script src="https://cdn.tiny.cloud/1/399lhfg7ylluxpdnohjauznz6287n1z2pqrc4araoshqz5zd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });
    </script>
</head>
<body>
<?php
require('authenticate.php');
require('connect.php');
require('nav.php');

if ($_SESSION['user_type'] !== 'admin') {
    echo "You are not authorized to access this page.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    if ($_POST['command'] === 'Update Task' && isset($_POST['task_id'])) {
        try {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $description = $_POST['description']; 
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
    <h1>Edit Task</h1>
    <form action="" method="POST">
        <label>Title: </label><input type="text" name="title" value="<?= $task['title'] ?>"><br>
        <label>Description: </label><textarea id="description" name="description" rows="4" cols="50"><?= $task['description'] ?></textarea><br>
        <label>Priority:</label><br>
        <select name="priority" required>
            <option value="High">High Priority</option>
            <option value="Medium">Medium Priority</option>
            <option value="Low">Low Priority</option>
            <option value="Not Priority">Not a Priority</option>
        </select><br>
        <label>Deadline: </label><input type="date" name="deadline" value="<?= $task['deadline'] ?>"><br>
        <label>Status: </label><input type="text" name="status" value="<?= $task['status'] ?>"><br>
        <label>Category ID: </label><input type="number" name="category_id" value="<?= $task['category_id'] ?>"><br>
        <input type="hidden" name="task_id" value="<?= $task_id ?>">
        <button type="submit" name="command" value="Update Task">Update Task</button>
        <button type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
    </form>
    <?php include('footer.php'); ?>
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
