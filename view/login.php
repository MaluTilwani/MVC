<?php
require_once "../controller/AuthController.php";
$controller = new AuthController();
$controller->login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="js/validation.js" defer></script>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" onsubmit="return validateLoginForm();">
        <input type="email" name="email" placeholder="Email" id="email" required><br>
        <input type="password" name="password" placeholder="Password" id="password" required><br>
        <input type="submit" value="Login">
    </form>
    <p style="text-align: center;">You need to register first before logging in. Please<a href="register.php">Register here</a>.</p>
</body>
</html>
