<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once "../model/Task.php";
$taskModel = new Task();

$id = $_GET['id'] ?? null;
if ($id) {
    $taskModel->delete($id);
}
header('Location: manage_task.php');
exit;
