<?php
require_once '../config/config.php';

$db = new Database();
$conn = $db->connect();

$filter = $_GET['filter'] ?? '';
$keyword = $_GET['keyword'] ?? '';

$sql = "SELECT t.id, t.title, t.description, t.due_date , t.priority, t.status, u.name AS assigned_user
        FROM tasks t
        LEFT JOIN users u ON t.assigned_to = u.id";

$validFilters = ['title', 'description', 'assigned_user'];
$params = [];
$types = '';

if (!empty($filter) && in_array($filter, $validFilters) && !empty($keyword)) {
    if ($filter === 'assigned_user') {
        $sql .= " WHERE u.name LIKE ?";
    } else {
        $sql .= " WHERE t.$filter LIKE ?";
    }
    $params[] = '%' . $keyword . '%';
    $types .= 's';
}

$sql .= " ORDER BY t.id ASC";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            display: inline-block;
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

<h2>Manage Tasks</h2>

<form class="filter-form" method="GET" action="">
    <select name="filter" required>
        <option value="">Filter By</option>
        <option value="title" <?= $filter === 'title' ? 'selected' : '' ?>>Title</option>
        <option value="description" <?= $filter === 'description' ? 'selected' : '' ?>>Description</option>
        <option value="assigned_user" <?= $filter === 'assigned_user' ? 'selected' : '' ?>>Assigned User</option>
    </select>
    <input type="text" name="keyword" placeholder="Enter keyword" value="<?= htmlspecialchars($keyword) ?>" required>
    <button type="submit">Search</button>
    <a href="admin-dash.php?page=manage_task">Clear</a>
</form>

<div class="table-container">
    <table id="taskTable">
        <thead>
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
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="task-row">
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['assigned_user'] ?? 'Unassigned') ?></td>
                        <td><?= htmlspecialchars($row['due_date']) ?></td>
                        <td><?= htmlspecialchars($row['priority']) ?></td>
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
                            <a href="#" onclick="return confirm('You want to delete this task?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="no-data">No tasks found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form.filter-form').on('submit', function(e) {
            e.preventDefault(); 
            var filterValue = $('input[name="keyword"]').val().toLowerCase();

            $('#taskTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(filterValue) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $('a[href="filteration.php"]').on('click', function(e) {
            e.preventDefault();
            $('input[name="keyword"]').val('');
            $('#taskTable tbody tr').show(); 
            window.history.pushState({}, document.title, "filteration.php"); 
        });
    });
</script>
