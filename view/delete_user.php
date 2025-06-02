<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once "../model/User.php";
$userModel = new User();

$id = $_GET['id'] ?? null;
if ($id) {
    $userModel->deleteUser($id);
}
header('Location: manage_users.php');
exit;
