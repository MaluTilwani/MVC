<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config/config.php";

$db = new Database();
$conn = $db->connect();

// Redirect if not logged in
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../view/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$isAdmin = $_SESSION['user']['is_admin'] ?? 0;

// Fetch user data
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fieldsToUpdate = [];
    $params = [];
    $types = '';

    // Optional fields
    if (!empty(trim($_POST['name']))) {
        $fieldsToUpdate[] = "name = ?";
        $params[] = trim($_POST['name']);
        $types .= 's';
    }

    if (!empty(trim($_POST['email']))) {
        $fieldsToUpdate[] = "email = ?";
        $params[] = trim($_POST['email']);
        $types .= 's';
    }

    if (!empty(trim($_POST['phone']))) {
        $fieldsToUpdate[] = "phone = ?";
        $params[] = trim($_POST['phone']);
        $types .= 's';
    }

    if (!$isAdmin && !empty($_POST['role'])) {
        $fieldsToUpdate[] = "role = ?";
        $params[] = $_POST['role'];
        $types .= 's';
    }

    if (!empty($_POST['gender'])) {
        $fieldsToUpdate[] = "gender = ?";
        $params[] = $_POST['gender'];
        $types .= 's';
    }

    if (!empty(trim($_POST['address']))) {
        $fieldsToUpdate[] = "address = ?";
        $params[] = trim($_POST['address']);
        $types .= 's';
    }

    // Handle profile picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $tmpName = $_FILES['profile_picture']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $fieldsToUpdate[] = "profile_picture = ?";
            $params[] = $targetPath;
            $types .= 's';
        }
    }

    if (!empty($fieldsToUpdate)) {
        $query = "UPDATE users SET " . implode(', ', $fieldsToUpdate) . " WHERE id = ?";
        $params[] = $userId;
        $types .= 'i';

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
    foreach ($fieldsToUpdate as $index => $field) {
        $key = trim(explode('=', $field)[0]);
        $_SESSION['user'][$key] = $params[$index];
    }

    header("Location: admin-dash.php?page=view_profile");
    exit;
} else {
           echo "<script>alert('Update failed. Try again.');</script>";

        }
    } else {
           echo "<script>alert('No changes detected..');</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f6f4;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
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
        input[type="email"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1px solid #d7ccc8;
            background-color: #fcfcfc;
        }

        button {
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

        button:hover {
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
    <h2>Update Profile</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label <div class="form-container">
    <h2>Update Profile</h2>


    <form method="POST" enctype="multipart/form-data">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <?php if (!$isAdmin): ?>
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">-- Select Role --</option>
            <option value="team member" <?= $user['role'] === 'team member' ? 'selected' : '' ?>>Team Member</option>
            <option value="employee" <?= $user['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
        </select>
    <?php endif; ?>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="">--Select Gender--</option>
            <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
            <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
        </select>

        <label for="address">Address:</label>
        <textarea name="address" required><?= htmlspecialchars($user['address']) ?></textarea>

        <label for="profile_picture">Change Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*">

        <?php if (!empty($user['profile_picture'])): ?>
            <p>Current Image:</p>
            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" style="width:100px;height:auto;border-radius:6px;margin-bottom:15px;">
        <?php endif; ?>

        <button type="submit" href="admin-dash.php?page=view_profile">Update Profile</button>
    </form>
</div>

</body>
</html>
