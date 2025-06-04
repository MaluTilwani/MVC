<?php
require_once "../model/User.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function handleForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formType = $_POST['form_type'] ?? '';
            if ($formType === 'register') {
                $this->registerUser();
            } elseif ($formType === 'add_user') {
                $this->addUserByAdmin();
            } else {
                echo "<script>alert('Invalid form submission.'); window.history.back();</script>";
            }
        }
    }

   public function registerUser() {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $success = $this->userModel->registerUser($name, $email, $hashedPassword);

    if ($success) {
        echo "<script>alert('Registration Successful!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error: Email may already exist.'); window.history.back();</script>";
    }
}

    private function addUserByAdmin() {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $phone    = trim($_POST['phone'] ?? '');
        $role     = $_POST['role'] ?? '';
        $gender   = $_POST['gender'] ?? '';
        $address  = trim($_POST['address'] ?? '');
        $profilePicturePath = null;

        if ($name && $email && $password && $phone && $role && $gender && $address && isset($_FILES['profile_picture'])) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
                $profilePicturePath = $fileName;
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $success = $this->userModel->addUser($name, $email, $hashedPassword, $phone, $role, $gender, $address, $profilePicturePath);

                if ($success) {
                    echo "<script>alert('User added successfully!'); 
                    window.location.href = 'manage_users.php';</script>";
                } else {
                    echo "<script>alert('Error: Could not add user.'); 
                    window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Failed to upload profile picture.'); 
                window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Please fill in all fields to add a user.'); 
            window.history.back();</script>";
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

            if ($result['is_admin'] == 1) {
                header("Location: ../view/admin-dash.php");
            } elseif ($result['role'] == 'team') {
                header("Location: ../view/team-dash.php");
            } elseif ($result['role'] == 'employee') {
                header("Location: ../view/emp-dash.php");
            } else {
                // fallback
                header("Location: ../view/login-denied.php");
            }
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
