<?php
session_start();
require_once "../model/Task.php";
require_once "../model/User.php";

$taskModel = new Task();
$userModel = new User();

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    header("Location: manage_task.php");
    exit;
}

$taskData = $taskModel->getById($id);
$users = $userModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $assigned_to = $_POST['assigned_to'];

    $updated = $taskModel->update($id, $title, $description, $assigned_to);

    if ($updated) {
        echo "<script>
                alert('Task updated successfully.');
                window.location.href = 'manage_task.php';
              </script>";
        exit;
    } else {
        $message = "Error updating task.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 25px;
            background: #fcfcfc;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
            font-family: Arial, sans-serif;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #d7ccc8;
            background-color: #fff;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #6d4c41;
            outline: none;
            box-shadow: 0 0 5px rgba(109, 76, 65, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: rgb(118, 84, 72);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: rgb(116, 78, 67);
        }

        .error {
            color: #c94f3a;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit Task</h2>
    <?php if ($message): ?>
        <div class="error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($taskData): ?>
        <form method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($taskData['title']) ?>" required>
            <textarea name="description" rows="4" required><?= htmlspecialchars($taskData['description']) ?></textarea>
            <select name="assigned_to" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $taskData['assigned_to'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Update Task</button>
        </form>
    <?php else: ?>
        <p>Task not found.</p>
    <?php endif; ?>
</div>
</body>
</html>
