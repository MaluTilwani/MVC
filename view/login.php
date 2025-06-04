<?php
require_once "../controller/AuthController.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $auth->login();
}
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
       Enter Email:<input type="email" name="email" placeholder="Email" id="email" required><br>
        Enter Password:<input type="password" name="password" placeholder="Password" id="password" required><br>
        <input type="submit" value="Login">
    </form>
    <p style="text-align: center;">You need to register first before logging in. Please<a href="register.php">Register here</a>.</p>
</body>
</html>
