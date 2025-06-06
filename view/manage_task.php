<?php
require_once '../config/config.php';

$db = new Database();
$conn = $db->connect();

$sql = "SELECT t.id, t.title, t.description, u.name AS assigned_user
        FROM tasks t
        LEFT JOIN users u ON t.assigned_to = u.id
        ORDER BY t.id ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Tasks</title>
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
            overflow-x: auto;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0cfc8;
        }

        table {
            min-width: 950px;
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e0cfc8;
            white-space: nowrap;
        }

        th {
            background-color: #8d6e63;
            color: white;
            position: sticky;
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

        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Manage Tasks</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Task Title</th>
            <th>Task Description</th>
            <th>Assigned To</th>
            <th>Actions</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['assigned_user'] ?? 'Unassigned') ?></td>
                    <td class="action-buttons">
                        <a href="admin-dash.php?page=task_edit&id=<?= $row['id'] ?>">Edit</a>
                        <a href="" onclick="return confirm('Delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="no-data">No tasks found.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
