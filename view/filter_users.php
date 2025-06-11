<?php
require_once '../config/config.php';
require_once '../model/User.php';

$userModel = new User();

$filter = $_POST['filter'] ?? '';
$keyword = $_POST['keyword'] ?? '';
$users = $userModel->getFilteredUsers($filter, $keyword); 
foreach ($users as $user):
    $role = strtolower($user['role'] ?? '');
    $statusBadge = ($role === 'admin' || $role === 'employee' || $role === 'team')
        ? '<span class="badge bg-success">Active</span>'
        : '<span class="badge bg-danger">Inactive</span>';
    ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
        <td><?= htmlspecialchars($user['gender'] ?? '') ?></td>
        <td><?= htmlspecialchars($user['role'] ?? '') ?></td>
        <td><?= $statusBadge ?></td>
        <td class="action-buttons">
            <a href="admin-dash.php?page=edit_user&id=<?= $user['id'] ?>">Edit</a>
            <a href="admin-dash.php?page=detail_view&id=<?= $user['id'] ?>">View</a>
            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
        </td>
    </tr>
<?php endforeach;

if (empty($users)) {
    echo '<tr><td colspan="8" class="text-center text-muted">No users found.</td></tr>';
}
?>
