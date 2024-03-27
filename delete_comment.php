<?php
require('authenticate.php');
require('connect.php');

$query = "SELECT * FROM comments";
$statement = $db->query($query);
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
</head>
<body>
    <h1>Comments</h1>
    <table>
        <tr>
            <th>Commenter Name</th>
            <th>Comment Content</th>
            <th>Page ID</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment['commenter_name'] ?></td>
                <td><?= $comment['comment_content'] ?></td>
                <td><?= $comment['page_id'] ?></td>
                <td><?= $comment['created_at'] ?></td>
                <td>
                    <a href="delete_comment.php?id=<?= $comment['id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this comment?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
