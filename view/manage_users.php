<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


require_once "../model/User.php";
$userModel = new User();
$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
 body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f9f6f4;
    padding: 40px;
    color: #3e2723;
}

h2 {
    text-align: center;
    color: #6d4c41;
}

.table-container {
    max-width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling if needed */
    margin: 20px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    border: 1px solid #e0cfc8;
}

table {
    min-width: 950px; /* Adjust depending on expected column size */
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

th, td {
    text-align: left;
    padding: 12px 15px;
    border-bottom: 1px solid #e0cfc8;
    white-space: nowrap; /* Prevents breaking long text */
}

th {
    background-color: #8d6e63;
    color: white;
    position: sticky;   /* Optional: Sticky header on scroll */
    top: 0;
    z-index: 2;
}

tr:hover {
    background-color: #f1ebe8;
}

a {
    text-decoration: none;
    color: #6d4c41;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
    color: #5a382e;
}

.action-buttons a {
    margin-right: 10px;
}

    </style>
</head>
<body>

<div class="table-container">
    <h2>Manage Users</h2>
    <table>
        <tr>
             <th>id</th><th>Name</th><th>Email</th><th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td class="action-buttons">
                <a href="admin-dash.php?page=edit_user&id=<?= $user['id'] ?>">Edit</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
