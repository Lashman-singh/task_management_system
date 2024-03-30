<?php
require('authenticate.php');
require('connect.php');
include('nav.php');

$query = "SELECT * FROM task";

if ($_SESSION['user_type'] === 'admin' && isset($_POST['sort'])) {
    $sort = $_POST['sort'];
    switch ($sort) {
        case 'deadline':
        case 'status':
        case 'priority':
            $query .= " ORDER BY $sort";
            break;
        default:
            $query .= " ORDER BY task_id";
            break;
    }
}

$statement = $db->query($query);
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    <h1>Task Management System</h1>
    
    <?php if ($_SESSION['user_type'] === 'admin'): ?>
    <form method="POST" style="margin-bottom: 20px;">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
            <option value="priority">Priority</option>
            <option value="deadline">Deadline</option>
            <option value="status">Status</option>
        </select>
        <button type="submit">Sort</button>
    </form>
<?php endif; ?>


    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Category</th>
            <th>Assigned To</th>
            <?php if ($_SESSION['user_type'] === 'admin'): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><a href="task_details.php?id=<?= $task['task_id'] ?>"><?= $task['title'] ?></a></td>
                <td><?= $task['description'] ?></td>
                <td><?= $task['priority'] ?></td>
                <td><?= $task['deadline'] ?></td>
                <td><?= $task['status'] ?></td>
                <td><?= $task['category_id'] ?></td>
                <td><?= $task['user_id'] ?></td>
                <?php if ($_SESSION['user_type'] === 'admin'): ?>
                    <td class="actions">
                        <a href="edit_task.php?id=<?= $task['task_id'] ?>">Edit</a>
                        <form action="delete_task.php" method="POST" style="display: inline;">
                            <input type="hidden" name="task_id" value="<?= $task['task_id'] ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include('footer.php'); ?>
</body>
</html>
