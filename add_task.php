<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_task.css">
    <title>Add New Task</title>
    <script src="https://cdn.tiny.cloud/1/um1ud57t4xzcel5dep4c6pjsvbkwwlcfn3462pdbbfd71qkn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea[name=description]',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name'
        });
    </script>
</head>
<body>
    <?php
    require('authenticate.php');
    require('connect.php');
    include('nav.php');

    $query = "SELECT * FROM Categories";
    $statement = $db->query($query);
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT MAX(task_id) AS max_id FROM Task";
    $statement = $db->query($query);
    $maxIdResult = $statement->fetch();
    $nextAvailableId = $maxIdResult['max_id'] + 1;

    if ($_SESSION['user_type'] !== 'admin') {
        echo "You are not authorized to access this page.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        $status = $_POST['status'];
        $category_id = $_POST['category_id'];
        $employee_id = $_POST['employee_id']; 

        $query = "INSERT INTO Task (task_id, title, description, priority, deadline, status, category_id, employee_id) 
                  VALUES (:task_id, :title, :description, :priority, :deadline, :status, :category_id, :employee_id)"; 
        $statement = $db->prepare($query);
        $statement->bindParam(':task_id', $nextAvailableId);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':priority', $priority);
        $statement->bindParam(':deadline', $deadline);
        $statement->bindParam(':status', $status);
        $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $statement->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: Unable to create task.";
        }
    }
    ?>
    <h1>Add New Task</h1>
    <form action="add_task.php" method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" required><br>
        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="50"></textarea><br>
        <label>Priority:</label><br>
        <select name="priority" required>
            <option value="High">High Priority</option>
            <option value="Medium">Medium Priority</option>
            <option value="Low">Low Priority</option>
            <option value="Not Priority">Not a Priority</option>
        </select><br>
        <label>Deadline:</label><br>
        <input type="date" name="deadline" required><br>
        <label>Status:</label><br>
        <input type="text" name="status" required><br>
        <label>Category:</label><br>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Assigned To (Employee ID): 1-10</label><br> 
        <input type="number" name="employee_id" required><br> 
        <button id="add_task" type="submit">Add Task</button>
    </form>
    <?php include('footer.php'); ?>
</body>
</html>
