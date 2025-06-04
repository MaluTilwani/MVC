<?php
require_once "../controller/AuthController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $auth->registerUser();
}
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
    <form method="POST" action="">
  <input type="hidden" name="form_type" value="register">

    <form method="POST" action="index.php?controller=auth&action=register" onsubmit="return validateRegisterForm();">
        Enter Name:<input type="text" name="name" placeholder="Name" id="name" required><br>
        Enter email:<input type="email" name="email" placeholder="Email" id="email" required><br>
        Enter Password:<input type="password" name="password" placeholder="Password" id="password" required><br>
        <input type="submit" value="Register">
    </form>
    <p style="text-align: center;">Already have an account? <a href="login.php">Log in here</a>.</p>

</body>
</html>
