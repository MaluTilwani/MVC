<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assign-task</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <h2>Task List</h2>
<a href="index.php?action=create-task">Create Task</a>
<table border="1">
    <tr>
        <th>ID</th><th>Title</th><th>Description</th><th>Due Date</th><th>Assigned To</th><th>Actions</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
    <tr>
        <td><?= $task['id'] ?></td>
        <td><?= $task['title'] ?></td>
        <td><?= $task['description'] ?></td>
        <td><?= $task['due_date'] ?></td>
        <td><?= $task['username'] ?></td>
        <td>
            <a href="index.php?action=edit-task&id=<?= $task['id'] ?>">Edit</a> |
            <a href="index.php?action=delete-task&id=<?= $task['id'] ?>" onclick="return confirm('Delete this task?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

