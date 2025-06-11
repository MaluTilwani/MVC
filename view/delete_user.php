<?php
session_start();
require_once "../model/User.php";

$userModel = new User();
$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $deleted = $userModel->deleteUser($id);
    if ($deleted) {
        echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'admin-dash.php?page=manage_users';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Failed to delete user.');    
                window.location.href = 'admin-dash.php?page=manage_users';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Invalid ID.');
            window.location.href = 'admin-dash.php?page=manage_users';
          </script>";
    exit;
    
}
