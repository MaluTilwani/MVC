<?php
require_once "../controller/AuthController.php";
$controller = new AuthController();
$controller->register();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="js/validation.js" defer></script>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" onsubmit="return validateRegisterForm();">
        <input type="text" name="name" placeholder="Name" id="name" required><br>
        <input type="email" name="email" placeholder="Email" id="email" required><br>
        <input type="password" name="password" placeholder="Password" id="password" required><br>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="teamleader">Team Leader</option>
            <option value="employee">Employee</option>
        </select><br>
        <input type="submit" value="Register">
    </form>
    <p style="text-align: center;">Already have an account? <a href="login.php">Log in here</a>.</p>

</body>
</html>
