<?php
session_start();

require_once "../model/User.php";
$userModel = new User();

$totalEmployees = $userModel->countUsersByRole('employee');
$totalTeamLeaders = $userModel->countUsersByRole('team');

$adminName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Admin';

$page = isset($_GET['page']) ? $_GET['page'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Team-Leader Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/dash.css" />
</head>
<body>
  <div class="sidebar">
    <div class="profile">
      <h2>Welcome Team-Leader<br><span><h2><?php echo htmlspecialchars($adminName); ?></span></h2>
    </div>
    <ul class="menu">
      <li class="active" href="team-dash.php?page=manage_user"><i class="fas fa-tachometer-alt"> Team-Leader Dashboard</i></li>
       <li><a href="team-dash.php?page=add_user"><i class="fas fa-user-plus"> Add User</i></a></li>
      <li><a href="team-dash.php?page=add_task"><i class="fas fa-tasks"> Add Task</i></a></li>
      <li><a href="team-dash.php?page=manage_task"><i class="fas fa-tasks"> Manage Tasks</i></a></li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h1>Team Leader Dashboard</h1>
      <ul class="header-actions">
        <li><a href="team-dash.php?page=update_profile" class="profile">Change Profile</a></li>
        
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </header>

    <div class="dashboard-cards">
      <?php
        if ($page === 'add_user') {
            include 'add_users.php'; 
        }
        elseif ($page === 'add_task') {
            include 'add_task.php';
        }elseif ($page === 'filter_view') {
            include 'filter_view.php';
        }
        elseif ($page === 'manage_task') {
            include 'manage_task.php';
        }
        elseif ($page === 'update_profile') {
            include 'update_profile.php';
        }elseif ($page === 'task_edit' && isset($_GET['id'])) {
            include 'task_edit.php';
        }else {
            ?>
            <div class="card">
              <h3>Total Employees</h3>
              <p><?= $totalEmployees ?></p>
            </div>
            <div class="card">
              <h3>Total Team Leaders</h3>
              <p><?= $totalTeamLeaders ?></p>
            </div>
            <?php
        }
      ?>
    </div>
  </div>
</body>
</html>
