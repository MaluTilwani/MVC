<?php
session_start();

// Database connection
require_once '../config/database.php';

// User model
require_once '../app/Models/User.php';

$userModel = new Users($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userModel->users($email, $password)) {
        $role = $_SESSION['role'];
        switch ($role) {
            case 'Admin':
                header('Location: ../app/Views/admin_dashboard.php');
                exit;
            case 'TeamLeader':
                header('Location: ../app/Views/teamleader_dashboard.php');
                exit;
            case 'Employee':
                header('Location: ../app/Views/employee_dashboard.php');
                exit;
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Employment System</title>
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
