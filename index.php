<?php

session_start();

require_once 'config/database.php';
require_once 'app/models/User.php';

$userModel = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userModel->login($email, $password)) {
        $role = $_SESSION['role'];
        if ($role == 'Admin') {
            header('Location: /ems-system/app/Views/admin_dashboard.php');
        } elseif ($role == 'TeamLeader') {
            header('Location:/ems-system/app/Views/teamleader_dashboard.php');
        } elseif ($role == 'Employee') {
            header('Location: /ems-system/app/Views/employee_dashboard.php');
        }
    } else {
        $error = 'Invalid login credentials';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
