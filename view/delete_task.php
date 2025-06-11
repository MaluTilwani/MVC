<?php

session_start();

require_once "../model/Task.php";
$taskModel = new Task();

$id = $_GET['id'] ?? null;
if ($id) {
    $deleted = $taskModel->delete($id);
    if ($deleted) {
        header('Location: admin-dash.php?page=manage_task');
        exit;
    } else {
        echo "<script>alert('Failed to delete task.');<script>";
    }
} else {
    echo "Invalid ID.";
}

header('Location: manage_task.php');
exit;



