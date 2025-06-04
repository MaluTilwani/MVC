<?php
require_once "../model/User.php";
$userModel = new User();

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    header("Location: manage_users.php");
    exit;   
}

$userData = $userModel->getUserById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $updated = $userModel->updateUser($id, $name, $email);

    if ($updated) {
        echo "<script>
                alert('User updated successfully.');
                window.location.href = 'admin-dash.php?page=manage_user';
              </script>";
        exit;
    } else {
        $message = "Error updating user. Email might already exist.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
.form-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 25px;
    background: #fcfcfc; /* very light gray */
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #d7ccc8; /* soft light brown */
    background-color: #fff;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

input:focus, select:focus {
    border-color: #6d4c41; /* brown */
    outline: none;
    box-shadow: 0 0 5px rgba(109, 76, 65, 0.4);
}

button {
    width: 100%;
    padding: 12px;
    background-color:rgb(118, 84, 72); /* brown */
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color:rgb(116, 78, 67); /* darker brown */
}

.error {
    color: #c94f3a; /* reddish brown for error */
    text-align: center;
    font-weight: 600;
}

    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit User</h2>
    <?php if ($message): ?>
        <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php if ($userData): ?>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>
            <!-- <select name="role" required>
                <option value="admin" <?= $userData['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="teamleader" <?= $userData['role'] == 'teamleader' ? 'selected' : '' ?>>Team Leader</option>
                <option value="employee" <?= $userData['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
            </select> -->
            <button type="submit">Update User</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>
</body>
</html>
