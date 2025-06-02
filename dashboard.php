<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$role = strtolower($_SESSION['user']['role']);

if ($role == 'admin') {
    include "./view/admin-dash.php";
} elseif ($role == 'teamleader') {
    include "./view/team-dash.php";
} elseif ($role == 'employee') {
    include "./view/emp-dash.php";
}
?>
