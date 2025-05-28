<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create-task</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <form action="index.php?action=create-task" method="POST">
    <label for="taskName">Task Title:</label>
    <input type="text" name="title" id="tasktitle" required>

    <label for="taskDescription">Task Description:</label>
    <textarea name="description" id="taskdescription" required></textarea>

    <label for="dueDate">Due Date:</label>
    <input type="date" name="due_date" id="duedate" required>

    <label for="assignedTo">Assign To:</label>
    <select name="assigned_to" id="assignedto" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Create Task</button>
</form>
</body>
</html>



