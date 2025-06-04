<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");  // Adjust the path to your login.php
    exit;
}

// If logged in, show task1 dashboard or homepage here
echo "<h1>Welcome to Task1 Section, " . htmlspecialchars($_SESSION['user']['name']) . "</h1>";
?>

