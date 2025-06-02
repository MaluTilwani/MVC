<?php
require_once "../model/Task.php";
require_once "../model/User.php";

$taskModel = new Task();
$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    if ($taskModel->addTask($title, $description, $assigned_to)) {
        echo "<script>alert('Task added successfully'); window.location.href='manage_tasks.php';</script>";
    } else {
        echo "<script>alert('Failed to add task');</script>";
    }
}

$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
   <style>
    body {
        background-color: #f9f6f4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        padding: 50px 0;
    }

    form {
        max-width: 400px;
        width: 100%;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px 50px;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #e0cfc8;
        margin-top: 7%;
    }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #8d6e63;
        }

    input, textarea, select {
        width: 100%;
        padding: 12px 15px;
        margin-top: 10px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #d7ccc8;
        background-color: #fefefe;
        font-size: 1rem;
    }

    input[type="submit"], button {
        width: 100%;
        background-color: #a1887f;
        color: #ffffff;
        padding: 14px 0;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover, button:hover {
        background-color: #8d6e63;
    }

    .message {
        margin-bottom: 15px;
        font-weight: 600;
        color: #388e3c;
        text-align: center;
    }

    .error {
        color: #d32f2f;
        text-align: center;
    }
</style>

</head>
<body>

<h2>Add Task</h2>

<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Description:</label>
    <textarea name="description" rows="4" required></textarea>

   <label>Assign To:</label>
<select name="assigned_to" required>
    <option value="">Select User</option>
    <?php foreach ($users as $user): ?>
        <?php if ($user['role'] !== 'admin'): ?>
            <option value="<?= htmlspecialchars($user['id']) ?>">
                <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
    <input type="submit" value="Add Task">
</form>

</body>
</html>
