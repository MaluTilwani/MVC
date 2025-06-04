<?php
session_start();
$adminName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Admin';

$page = isset($_GET['page']) ? $_GET['page'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/dash.css" />
</head>
<body>
  <div class="sidebar">
    <div class="profile">
      <h2>Welcome Admin,<br><span><h2><?php echo htmlspecialchars($adminName); ?></span></h2>
    </div>
    <ul class="menu">
      <li class="active">Admin Dashboard</li>
       <li><a href="admin-dash.php?page=add_user">Add User</a></li>
      <li><a href="admin-dash.php?page=add_task">Add Task</a></li>
      <li><a href="admin-dash.php?page=manage_user">Manage Users</a></li>
      <li><a href="admin-dash.php?page=manage_task">Manage Tasks</a></li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h1>Admin Dashboard</h1>
      <ul class="header-actions">
        <li><a href="admin-dash.php?page=update_profile" class="profile">Change Profile</a></li>
        
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </header>

    <div class="dashboard-cards">
      <?php
        if ($page === 'add_user') {
            include 'add_users.php'; 
        }
        elseif ($page === 'manage_user') {
            include 'manage_users.php';
        }
        elseif ($page === 'add_task') {
            include 'add_task.php';
        }
        elseif ($page === 'manage_task') {
            include 'manage_task.php';
        }elseif ($page === 'edit_user' && isset($_GET['id'])) {
            include 'edit_user.php';
        }elseif ($page === 'update_profile') {
            include 'update_profile.php';
        }elseif ($page === 'task_edit' && isset($_GET['id'])) {
            include 'task_edit.php';
        }else {
            ?>
            <div class="card">
              <h3>Total Employees</h3>
            </div>
            <div class="card">
              <h3>Total Team Leaders</h3>
            </div>
            <?php
        }
      ?>
    </div>
  </div>
</body>
</html>
