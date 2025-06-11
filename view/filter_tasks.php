<?php
require_once '../config/config.php';

$db = new Database();
$conn = $db->connect();

$filter = $_POST['filter'] ?? '';
$keyword = $_POST['keyword'] ?? '';

$sql = "SELECT t.id, t.title, t.description, t.due_date, t.priority, t.status, u.name AS assigned_user
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

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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

        echo '<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['title']) . '</td>
                <td>' . htmlspecialchars($row['description']) . '</td>
                <td>' . htmlspecialchars($row['assigned_user'] ?? 'Unassigned') . '</td>
                <td>' . htmlspecialchars($row['due_date']) . '</td>
                <td>' . htmlspecialchars($row['priority']) . '</td>
                <td>' . htmlspecialchars($row['status']) . '</td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">
                            ' . $progress . '%
                        </div>
                    </div>
                </td>
                <td>
                    <a href="admin-dash.php?page=task_edit&id=' . $row['id'] . '">Edit</a>
                    <a href="delete_task.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this task?\')">Delete</a>
                </td>
            </tr>';
    }
} else {
    echo '<tr><td colspan="9" class="no-data">No tasks found.</td></tr>';
}
