<?php
require_once "../config/config.php";

class Task {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addTask($title, $description, $assigned_to) {
        $stmt = $this->conn->prepare("INSERT INTO tasks (title, description, assigned_to) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $description, $assigned_to);
        return $stmt->execute();
    }

    public function getAllTasks() {
        $stmt = $this->conn->query("SELECT tasks.*, users.name AS assignee FROM tasks LEFT JOIN users ON users.id = tasks.assigned_to ORDER BY tasks.id ASC");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function update($id, $title, $description, $assigned_to) {
    $stmt = $this->conn->prepare("UPDATE tasks SET title = ?, description = ?, assigned_to = ? WHERE id = ?");
    $stmt->bind_param("ssii", $title, $description, $assigned_to, $id);
    return $stmt->execute();
}


public function delete($id) {
    $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

}
?>
