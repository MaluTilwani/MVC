<?php
require_once '../config/config.php';

$db = new Database();
$conn = $db->connect();

$sql = "SELECT t.id, t.title, t.description, t.due_date, t.priority, t.status, u.name AS assigned_user
        FROM tasks t
        LEFT JOIN users u ON t.assigned_to = u.id
        ORDER BY t.id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Tasks</title>
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
    <a href="admin-dash.php?page=filter_view" style="margin-left:85%;">Search By Filter</a>
    <h2>Manage Tasks</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Task Title</th>
            <th>Task Description</th>
            <th>Assigned To</th>
            <th>Due_date</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Actions</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['assigned_user'] ?? 'Unassigned') ?></td>
                    <td><?= htmlspecialchars($row['due_date'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['priority'] ?? '') ?></td>s
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
    <?php
    $status = strtolower($row['status']);
    $progress = 0;
    $color = 'bg-secondary';

    if ($status === 'pending') {
        $progress = 25;
        $color = 'bg-warning';
    } elseif ($status === 'in progress' || $status === 'inprogress') {
        $progress = 60;
        $color = 'bg-info';
    } elseif ($status === 'completed' || $status === 'complete') {
        $progress = 100;
        $color = 'bg-success';
    }
    ?>
    <div class="progress" style="height: 20px;">
        <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
            <?= $progress ?>%
        </div>
    </div>
</td>
                    <td class="action-buttons">
                        <a href="admin-dash.php?page=task_edit&id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete_task.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
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
