<?php
$adminName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Teamleader';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Team Leader Dashboard</title>
<style>
 :root {
    --light-brown: #f3e5f5;
    --brown: #a1887f;
    --gray: #fafafa;
    --dark-gray: #8d6e63;
    --text: #3e2723;
    --white: #ffffff;
    --hover-brown: #8d6e63;
    --logout-red: #ff8a80;
    --logout-hover: #e57373;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: var(--gray);
    color: var(--text);
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 700px;
    margin: 50px auto;
    padding: 30px;
    background-color: var(--white);
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
    text-align: center;
    border: 1px solid var(--light-brown);
}

.dashboard-container h2 {
    color: var(--brown);
    margin-bottom: 20px;
}

.welcome-msg {
    font-size: 18px;
    color: var(--dark-gray);
    margin-bottom: 30px;
}

.btn {
    display: inline-block;
    margin: 10px 8px;
    padding: 10px 22px;
    background-color: var(--brown);
    color: var(--white);
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: var(--hover-brown);
}

.btn.logout {
    background-color: var(--logout-red);
}

.btn.logout:hover {
    background-color: var(--logout-hover);
}
</style>
</head>
<body>
    <div class="dashboard-container">
    <h2>Welcome Team Leader</h2>
    <div class="welcome-msg">Welcome Team Leader <strong><?php echo htmlspecialchars ($adminName); ?></strong></div>
    <a href="add_users.php" class="btn">Add User</a>
    <a href="add_task.php" class="btn">Add Task</a>
    <a href="manage_task.php" class="btn">Manage Tasks</a>
    <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
