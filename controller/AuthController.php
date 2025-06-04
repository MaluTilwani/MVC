<?php
require_once "../model/User.php";
session_start();

class AuthController {
    public function register() {
        $user = new User();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            if ($user->register($name, $email, $password)) {
            echo "<script>
            alert('Registration Successful!');
            window.location.href = 'login.php';
            </script>";
            exit;
            } else {
            echo "<script>alert('Registration Failed!');</script>";
            }

        }
    }

public function login() {
    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $result = $user->login($email, $password);

        if (is_array($result)) {
            $_SESSION['user'] = $result;
            echo "<script>alert('loggedin successfully');</script>";
            header("Location: admin-dash.php");
            exit();
        } else {
            echo "<script>alert('Email and password not matched..');</script>";
        }
    }
}
  public function logout() {
    session_start();
    $_SESSION = [];              
    session_unset();             
    session_destroy();         
    header("Location: /task1/view/login.php");
    exit();
}

}
