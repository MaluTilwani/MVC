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
            $role = $_POST['role'];

            if ($user->register($name, $email, $password, $role)) {
                header("Location: login.php");
            } else {
                echo "Registration Failed!";
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

           switch (strtolower($result['role'])) {
                case 'admin':
                    header("Location: ../view/admin-dash.php");
                    break;
                case 'teamleader':
                    header("Location: ../view/team-dash.php");
                    break;
                case 'employee':
                    header("Location: ../view/emp-dash.php");
                    break;
                default:
                    echo "Unknown role!";
                    break;
            }
            exit();
        } elseif ($result === "email_not_found") {
            echo "Email not registered. Please <a href='register.php'>register</a> first.";
            
        } elseif ($result === "invalid_password") {
            echo "Incorrect password. Please try again.";
        } else {
            echo "Login failed due to an unknown error.";
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
