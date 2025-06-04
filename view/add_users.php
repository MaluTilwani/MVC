<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // If accessed directly without login, redirect to login
    if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
        header('Location: login.php');
        exit;
    } else {
        // If included inside another page, just stop rendering
        echo "<p style='color:red; text-align:center;'>Please log in to access this section.</p>";
        return;
    }
}
require_once "../model/User.php"; 
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        $userModel = new User();
        $success = $userModel->register ($name, $email, $password);
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
    <title>Add User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f6f4;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            width: 80%;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0cfc8;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #6d4c41;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #4e342e;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1px solid #d7ccc8;
            background-color: #fcfcfc;
        }

        input[type="submit"] {
            background-color: #8d6e63;
            color: #fff;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #6d4c41;
        }

        .message {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            color: #388e3c;
        }

        .error {
            color: #d32f2f;
        }

        @media (max-width: 768px) {
            .form-container {
                width: 95%;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New User</h2>

    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter full name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" placeholder="Enter email address" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password" required>

        <input type="submit" value="Add User">
    </form>
</div>
</body>
</html>