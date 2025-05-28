<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Employee') {
    header('Location: ../../public/index.php');
    exit();
}
echo "<h1>Welcome Employee</h1>";
echo "<a href='logout.php'>Logout</a>";
// Add Employee view tasks here
