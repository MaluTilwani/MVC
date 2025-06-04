<?php
require_once "../config/config.php";

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register($name, $email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        return $stmt->execute();
    }

    public function login($email, $password) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
         echo "<script>alert('Password matched.');</script>";
         return $user;
        } else {
         echo "<script>alert('Email not found.');</script>";
        return "email_not_found";
    }
    }
    }
    public function getAllUsers() {
    $stmt = $this->conn->prepare("SELECT id, name, email FROM users ORDER BY id ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
public function getAll() {
    $stmt = $this->conn->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function getUserById($id) {
    $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public function updateUser($id, $name, $email) {
    // Check for duplicate email (excluding current user)
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        // Email exists alert
        echo "<script>alert('Email already exists. Update failed.');</script>";
        return false;
    }
    $stmt->close();

    $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!');</script>";
        $stmt->close();
        return true;
    } else {
        echo "<script>alert('Failed to update user.');</script>";
        $stmt->close();
        return false;
    }
}
public function deleteUser($id) {
    $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
}