<?php
require_once '../config/config.php';
require_once '../model/User.php';

$userModel = new User();
$conn = (new Database())->connect();

$filter = $_GET['filter'] ?? '';
$keyword = $_GET['keyword'] ?? '';

$validFilters = ['name', 'email', 'role'];
$params = [];
$types = '';
$sql = "SELECT * FROM users";

if (!empty($filter) && in_array($filter, $validFilters) && !empty($keyword)) {
    $sql .= " WHERE $filter LIKE ?";
    $params[] = '%' . $keyword . '%';
    $types .= 's';
}

$sql .= " ORDER BY id ASC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Filter Users</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .filter-form {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-form select, .filter-form input, .filter-form button, .filter-form a {
            padding: 8px 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #d7ccc8;
        }

        .filter-form button {
            background-color: #6d4c41;
            color: white;
            border: none;
            cursor: pointer;
        }

        .filter-form a {
            background-color: #8d6e63;
            color: white;
            text-decoration: none;
            line-height: 28px;
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0cfc8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            min-width: 950px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0cfc8;
            white-space: nowrap;
        }

        th {
            background-color: #8d6e63;
            color: white;
        }

        tr:hover {
            background-color: #f1ebe8;
        }

        .action-buttons a {
            margin-right: 10px;
            color: #6d4c41;
            font-weight: bold;
            text-decoration: none;
        }

        .action-buttons a:hover {
            text-decoration: underline;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

<h2>Manage Users</h2>

<form class="filter-form" method="GET" action="">
    <input type="hidden" name="page" value="tfilter_view">
    <select name="filter" required>
        <option value="">Filter By</option>
        <option value="name" <?= $filter === 'name' ? 'selected' : '' ?>>Name</option>
        <option value="email" <?= $filter === 'email' ? 'selected' : '' ?>>Email</option>
        <option value="role" <?= $filter === 'role' ? 'selected' : '' ?>>Role</option>
    </select>
    <input type="text" name="keyword" placeholder="Enter keyword" value="<?= htmlspecialchars($keyword) ?>" required>
    <button type="submit">Search</button>
    <a href="admin-dash.php?page=manage_user">Clear</a>
</form>


<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Role</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['gender']) ?></td>
                        <td><?= htmlspecialchars($user['role'] ?? '') ?></td>
                        <td>
                            <?php
                            $role = strtolower($user['role'] ?? '');
                            echo in_array($role, ['admin', 'employee', 'team']) 
                                ? '<span class="badge bg-success">Active</span>' 
                                : '<span class="badge bg-danger">Inactive</span>';
                              
                            ?>
                        </td>
                        <td class="action-buttons">
                            <a href="admin-dash.php?page=edit_user&id=<?= $user['id'] ?>">Edit</a>
                            <a href="#" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="no-data">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

