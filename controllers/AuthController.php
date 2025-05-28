<?php 
// app/Controllers/AuthController.php
require_once '../app/Models/User.php';

class AuthController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new User($conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->login($email, $password)) {
                $role = $_SESSION['role'];
                if ($role == 'Admin') {
                    header('Location: ../Views/admin_dashboard.php');
                } elseif ($role == 'TeamLeader') {
                    header('Location: ../Views/teamleader_dashboard.php');
                } elseif ($role == 'Employee') {
                    header('Location: ../Views/employee_dashboard.php');
                }
            } else {
                $error = 'Invalid login credentials';
                include '../Views/login_view.php'; // your login form
            }
        } else {
            include '../Views/login_view.php';
        }
    }
}
