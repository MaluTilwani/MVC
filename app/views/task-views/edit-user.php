<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assign-task</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <form action="index.php?action=edit&id=<?= $user['id'] ?>" method="POST">
    <label>Username:</label>
    <input type="text" name="username" value="<?= $user['username'] ?>" required>
    <label>Email:</label>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <label>Role:</label>
    <select name="role" required>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="manager" <?= $user['role'] === 'manager' ? 'selected' : '' ?>>Manager</option>
        <option value="team member" <?= $user['role'] === 'team member' ? 'selected' : '' ?>>Team Member</option>
    </select>
    <button type="submit">Update User</button>
</form>
</body>
</html>


