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


// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($stmt->execute()){
    echo"<script>alert('profile updated successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f3f2;
            margin: 0;
            padding: 40px;
        }

        .profile-container {
            width: 80%;
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cfc9;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #5d4037;
        }

        .profile-item {
            margin-bottom: 15px;
        }

        .profile-item label {
            display: block;
            font-weight: 600;
            color: #4e342e;
            margin-bottom: 6px;
        }

        .profile-item span {
            display: block;
            background-color: #f5f5f5;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #dcdcdc;
        }

        .profile-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .btn-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            background-color: #8d6e63;
            color: #fff;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #5d4037;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Your Profile</h2>

    <div class="profile-image">
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture">
        <?php else: ?>
            <img src="https://via.placeholder.com/120" alt="No Profile Picture">
        <?php endif; ?>
    </div>

    <div class="profile-item">
        <label>Full Name:</label>
        <span><?= htmlspecialchars($user['name']) ?></span>
    </div>

    <div class="profile-item">
        <label>Email Address:</label>
        <span><?= htmlspecialchars($user['email']) ?></span>
    </div>

    <div class="profile-item">
        <label>Phone Number:</label>
        <span><?= htmlspecialchars($user['phone']) ?></span>
    </div>

     <?php if (!$isAdmin): ?>
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">-- Select Role --</option>
            <option value="team member" <?= $user['role'] === 'team member' ? 'selected' : '' ?>>Team Member</option>
            <option value="employee" <?= $user['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
        </select>
    <?php endif; ?>
    
    <div class="profile-item">
        <label>Gender:</label>
        <span><?= ucfirst(htmlspecialchars($user['gender'])) ?></span>
    </div>

    <div class="profile-item">
        <label>Address:</label>
        <span><?= nl2br(htmlspecialchars($user['address'])) ?></span>
    </div>

    <div class="btn-container">
        <a class="btn" href="admin-dash.php?page=update_profile">Edit Profile</a>
    </div>
</div>

</body>
</html>
