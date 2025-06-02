<?php
require_once '../config/config.php'; 

$db = new Database();
$conn = $db->connect();

// $sql = "SELECT t.*, u.name AS assigned_user
//         FROM tasks t
//         JOIN users u ON t.assigned_to = u.id
//         ORDER BY t.id DESC";

$sql = "SELECT t.id, t.title, t.description, u.name AS assigned_user, u.role AS assigned_role
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
            background-color: #f0f2f5;
            padding: 40px;
        }
        .table-container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #5d4037;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #a1887f;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            color: #6d4c41;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
            color: #5a382e;
        }
    </style>
</head>
<body>
    <h2>Manage Tasks</h2>
    <table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>Task Title</th>
    <th>Task Description</th>
    <th>Assigned To</th>
    <th>Role</th>
    <th>Action</th>
  </tr>
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><?php echo htmlspecialchars($row['assigned_user'] ?? 'Unassigned'); ?></td>
        <td><?php echo htmlspecialchars($row['assigned_role'] ?? 'N/A'); ?></td>
          <td class="action-buttons">
       <a href="task_edit.php?id=<?= $row['id'] ?>">Edit</a> |
      <a href="delete_task.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
    

    </td>
      </tr>
     <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="2" style="text-align:center;">No tasks found.</td></tr>
  <?php endif; ?>
</table>


</body>
</html>
