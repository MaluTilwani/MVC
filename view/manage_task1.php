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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            color: #888;
            font-style: italic;
            padding: 20px;
        }

        .filter-form {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-form select,
        .filter-form input,
        .filter-form button {
            padding: 6px 12px;
            font-size: 14px;
        }

        .progress {
            height: 20px;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Manage Tasks</h2>

    <!-- Filter Form -->
    <form id="filterForm" class="filter-form">
        <select name="filter" class="form-select w-auto" required>
            <option value="">Filter By</option>
            <option value="title">Title</option>
            <option value="description">Description</option>
            <option value="assigned_user">Assigned User</option>
        </select>
        <input type="text" name="keyword" class="form-control w-auto" placeholder="Enter keyword" required>
        <button type="submit" class="btn btn-dark">Search</button>
        <button type="button" id="clearFilter" class="btn btn-secondary">Clear</button>
    </form>

    <!-- Task Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Title</th>
                <th>Task Description</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="taskBody">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
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
                                    $progress = 25; $color = 'bg-warning';
                                } elseif ($status === 'in progress' || $status === 'inprogress') {
                                    $progress = 60; $color = 'bg-info';
                                } elseif ($status === 'completed' || $status === 'complete') {
                                    $progress = 100; $color = 'bg-success';
                                }
                            ?>
                            <div class="progress">
                                <div class="progress-bar <?= $color ?>" style="width: <?= $progress ?>%;"><?= $progress ?>%</div>
                            </div>
                        </td>
                        <td class="action-buttons">
                            <a href="admin-dash.php?page=task_edit&id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete_task.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" class="no-data">No tasks found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'filter_tasks.php',
                data: $(this).serialize(),
                success: function (response) {
                    $('#taskBody').html(response);
                },
                error: function () {
                    alert('Error loading filtered tasks.');
                }
            });
        });

        $('#clearFilter').on('click', function () {
            $('select[name="filter"]').val('');
            $('input[name="keyword"]').val('');

            $.ajax({
                type: 'POST',
                url: 'filter_tasks.php',
                data: {},
                success: function (response) {
                    $('#taskBody').html(response);
                }
            });
        });
    });
    </script>
</body>
</html>

