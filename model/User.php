<?php
require_once "../config/config.php";

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register($name, $email, $password, $role) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
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
            echo "Password matched.<br>";
            return $user;
        } else {
            echo "Password mismatch.<br>";
            return "invalid_password";
        }
    } else {
        echo "Email not found.<br>";
        return "email_not_found";
    }
}
    public function getAllUsers() {
    $stmt = $this->conn->prepare("SELECT id, name, email, role FROM users ORDER BY id ASC");
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
    $stmt = $this->conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public function updateUser($id, $name, $email, $role) {
    // Check for duplicate email (excluding current user)
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        return false; // Email already exists
    }
    $stmt->close();

    $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    return $stmt->execute();
}

public function deleteUser($id) {
    $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


}