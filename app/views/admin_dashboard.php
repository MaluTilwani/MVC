<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header('Location: ../../public/index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
         .dashboard h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .dashboard a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .dashboard a:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome Admin</h1>
        <a href="/ems-system/app/views/task-views/create-task.php" class="button">Create Task</a>
        <a href="/ems-system/app/views/task-views/task-list.php" class="button">Manage Tasks</a>
        <a href="/ems-system/app/views/task-views/create_user.php" class="button">Create Users</a>
        <a href="/ems-system/app/views/task-views/display.php" class="button">Manage Users</a>
        <a href="/ems-system/app/views/logout.php">Logout</a>
    </div>
</body>
</html>