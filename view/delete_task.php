<?php
ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

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



