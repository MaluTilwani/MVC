<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
        header('Location: login.php');
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Please log in to access this section.</p>";
        return;
    }
}

require_once "../model/User.php"; 
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone    = trim($_POST['phone'] ?? '');
    $role     = $_POST['role'] ?? '';
    $gender   = $_POST['gender'] ?? '';
    $address  = trim($_POST['address'] ?? '');

    $profilePicturePath = '';

    if ($name && $email && $password && $phone && $role && $gender && $address && isset($_FILES['profile_picture'])) {
        // File upload handling
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp  = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);
        $targetPath = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            $profilePicturePath = $targetPath;

            $userModel = new User();
            $success = $userModel->addUser($name, $email, $password, $phone, $role, $gender, $address, $profilePicturePath);

            $message = $success ? "User added successfully!" : "Error: Could not add user. Email might already exist.";
        } else {
            $message = "Failed to upload profile picture.";
        }
    } else {
        $message = "Please fill in all fields.";
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
            margin: 0;
            padding: 10px;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0cfc8;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 22px;
            color: #6d4c41;
        }

        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            color: #4e342e;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 0.95rem;
            border-radius: 5px;
            border: 1px solid #d7ccc8;
            background-color: #fcfcfc;
        }

        textarea {
            resize: none;
            height: 70px;
        }

        input[type="submit"] {
            background-color: #8d6e63;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
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
            margin-bottom: 15px;
            color: #388e3c;
        }

        .error {
            color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add New User</h2>

    <form method="POST" enctype="multipart/form-data" action="">
    <input type="hidden" name="form_type" value="add_user">

        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter full name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" placeholder="Enter email address" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" placeholder="Enter phone number" required>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">--Select Role--</option>
            <option value="employee">Employee</option>
            <option value="team">Team</option>
        </select>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="">--Select Gender--</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <label for="address">Address:</label>
        <textarea name="address" id="address" placeholder="Enter address" required></textarea>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*" required>

        <input type="submit" value="Add User">
    </form>
</div>
</body>
</html>
