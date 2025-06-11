<?php
require_once "../config/config.php";

class User extends Database {

    public function __construct() {
        require_once '../config/config.php'; 
        $database = new Database();
        $this->conn = $database->connect(); 
        }

 public function registerUser($name, $email, $password) {
    $stmt = $this->conn->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    return $stmt->execute();
}
    
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY id ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addUser($name, $email, $password, $phone, $role, $gender, $address, $profile_picture) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, phone, role, gender, address, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $email, $password, $phone, $role, $gender, $address, $profile_picture);
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
public function getAll() {
    $stmt = $this->conn->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



public function updateUser($id, $name, $email, $phone, $gender, $address, $role) {
   
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE (email = ? OR phone = ?) AND id != ?");
    if (!$stmt) {
        return ['status' => false, 'message' => 'Prepare failed: ' . $this->conn->error];
    }

    $stmt->bind_param("ssi", $email, $phone, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        return ['status' => false, 'message' => 'Email or phone number already exists.'];
    }
    $stmt->close();

    // Update user details
    $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, gender = ?, address = ?, role = ? WHERE id = ?");
    if (!$stmt) {
        return ['status' => false, 'message' => 'Prepare failed: ' . $this->conn->error];
    }

    $stmt->bind_param("ssssssi", $name, $email, $phone, $gender, $address, $role, $id);

    if ($stmt->execute()) {
        $stmt->close();
        return ['status' => true, 'message' => 'User updated successfully.'];
    } else {
        $stmt->close();
        return ['status' => false, 'message' => 'Failed to update user.'];
    }
}

public function deleteUser($id) {
    $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    return $stmt->affected_rows > 0;
}

public function countUsersByRole($role) {
    $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM users WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}

}