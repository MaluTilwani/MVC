<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assign-task</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <form action="?action=assignTask" method="POST">
    <label for="taskId">Task ID:</label>
    <input type="number" name="taskId" id="taskId" required>
    
    <label for="userId">User ID:</label>
    <input type="number" name="userId" id="userId" required>
    
    <button type="submit">Assign Task</button>
</form>
</body>
</html>

