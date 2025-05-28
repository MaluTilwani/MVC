<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'TeamLeader') {
    header('Location: ../../public/index.php');
    exit();
}
echo "<h1>Welcome Team Leader</h1>";
echo "<a href='logout.php'>Logout</a>";
