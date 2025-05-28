<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assign-task</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <form action="index.php?action=edit-task&id=<?= $task['id'] ?>" method="POST">
    <label>Task Title:</label>
    <input type="text" name="tasktitle" value="<?= $task['title'] ?>" required>

    <label>Task Description:</label>
    <textarea name="taskdescription" required><?= $task['description'] ?></textarea>

    <label>Due Date:</label>
    <input type="date" name="duedate" value="<?= $task['due_date'] ?>" required>

    <label>Assign To:</label>
    <select name="assignedto" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>" <?= $user['id'] == $task['assigned_to'] ? 'selected' : '' ?>>
                <?= $user['username'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Update Task</button>
</form>
</body>
</html>

