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
        echo "<script>alert('Task added successfully'); window.location.href='manage_task.php';</script>";
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f6f4;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            width: 80%;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0cfc8;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #6d4c41;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #4e342e;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1px solid #d7ccc8;
            background-color: #fcfcfc;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #8d6e63;
            color: #fff;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #6d4c41;
        }

        @media (max-width: 768px) {
            .form-container {
                width: 95%;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Task</h2>
    <form method="POST">
        <label for="title">Task Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Task Description:</label>
        <textarea name="description" id="description" rows="3" required></textarea>

        <label for="assigned_to">Assign To:</label>
        <select name="assigned_to" id="assigned_to" required>
            <option value="">-- Select User --</option>
            <?php foreach ($users as $user): ?>
                <?php if (!isset($user['role']) || $user['role'] !== 'admin'): ?>
                    <option value="<?= htmlspecialchars($user['id']) ?>">
                        <?= htmlspecialchars($user['name']) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Add Task">
    </form>
</div>

</body>
</html>
