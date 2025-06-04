<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;

}

 header("Location: view/login.php");
            exit;




