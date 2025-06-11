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
    // Get and sanitize form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $role = $_POST['role'] ?? '';

    // Call update method
    $result = $userModel->updateUser($id, $name, $email, $phone, $gender, $address, $role);

    if ($result['status']) {
        echo "<script>
                alert('{$result['message']}');
                window.location.href = 'admin-dash.php?page=manage_user';
              </script>";
        exit;
    } else {
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
.form-container {
    width: 100%;
    max-width: 600px; 
    margin: 60px auto;
    padding: 30px 40px;
    background: #fcfcfc;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
    box-sizing: border-box;
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
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px; /* ensures space between address and role */
    border-radius: 6px;
    border: 1px solid #d7ccc8;
    background-color: #fff;
    font-size: 1rem;
    resize: vertical;
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
           Name:<input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>

            Email:<input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

            Phone:<input type="text" name="phone" value="<?= htmlspecialchars($userData['phone'] ?? '') ?>" >

             Gender:<select name="gender" >
             <option value="">Select Gender</option>
                <option value="male" <?= $userData['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= $userData['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                <option value="other" <?= $userData['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
            </select><br/>

             Address:<textarea name="address"><?= htmlspecialchars($userData['address'] ?? '') ?></textarea>

            Role:<select name="role">
                <option value="">Select Role</option>
                <option value="team" <?= $userData['role'] === 'team' ? 'selected' : '' ?>>Team</option>
                <option value="employee" <?= $userData['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
            </select>

             
            <button type="submit">Update User</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>
</body>
</html>
