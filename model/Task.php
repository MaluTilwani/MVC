<?php
require_once "../config/config.php";

class Task extends Database {

    public function __construct() {
        require_once '../config/config.php'; 
        $database = new Database();
        $this->conn = $database->connect(); 
        }
        
    public function addTask($title, $description, $assigned_to, $due_date, $priority, $status) {
    $stmt = $this->conn->prepare("INSERT INTO tasks (title, description, assigned_to, due_date, priority, status) 
                                 VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $description, $assigned_to, $due_date, $priority, $status);
   
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
    if (!$this->conn) {
        die("Database connection not established.");
    }

    $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

}
?>
s