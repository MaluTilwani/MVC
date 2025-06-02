<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once "../model/User.php"; 
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($name && $email && $password && $role) {
        $userModel = new User();
        $success = $userModel->register ($name, $email, $password, $role);
        if ($success) {
            $message = "User added successfully!";
        } else {
            $message = "Error: Could not add user. Email might already exist.";
        }
    } else {
        $message = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Add User</title>
<style>
body {
    background-color: #f9f6f4;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    padding: 50px 0;
}

.form-container {
    background: #ffffff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    width: 350px;
    border: 1px solid #e0cfc8;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #8d6e63;
}

input,
select {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #d7ccc8;
    background-color: #fefefe;
    font-size: 1rem;
}

button {
    width: 100%;
    background-color: #a1887f;
    color: #ffffff;
    padding: 14px 0;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #8d6e63;
}

.message {
    margin-bottom: 15px;
    font-weight: 600;
    color: #388e3c;
    text-align: center;
}

.error {
    color: #d32f2f;
    text-align: center;
}

</style>
</head>
<body>
    <div class="form-container">
        <h2>Add New User</h2>
        <?php if($message): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="teamleader">Team Leader</option>
                <option value="employee">Employee</option>
            </select>
            <button type="submit">Add User</button>
        </form>
    </div>
</body>
</html>
