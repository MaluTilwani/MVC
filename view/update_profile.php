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

// Fetch current user data from DB
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name && $email) {
        $updateQuery = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssi", $name, $email, $userId);
        if ($updateStmt->execute()) {
            $message = "Profile updated successfully!";
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $user['name'] = $name;
            $user['email'] = $email;
        } else {
            $message = "Update failed. Try again.";
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
    <title>Update Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f6f4;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            width: 80%;
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

    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'failed') !== false || strpos($message, 'fill') !== false ? 'error' : ''; ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
