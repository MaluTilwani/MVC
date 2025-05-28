<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create-user</title>
    <link rel="stylesheet" href="/ems-system/public/css/forms.css">
</head>
<body>
  <h2>User List</h2>
<a href="index.php?action=create">Add User</a>
<table border="1">
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><?= $user['role'] ?></td>
        <td>
            <a href="index.php?action=edit&id=<?= $user['id'] ?>">Edit</a> |
            <a href="index.php?action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

