<?php
require_once '../config/database.php';

class User {
    private $conn;
    private $table = "users";

    public function create($username, $password, $role) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table (username, password, role)
                VALUES ('$username', '$password', '$role')";
        return mysqli_query($this->conn, $sql);
    }

    public function readAll() {
        $sql = "SELECT * FROM $this->table";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function read($id) {
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function update($id, $username, $role) {
        $sql = "UPDATE $this->table SET username='$username', role='$role' WHERE id=$id";
        return mysqli_query($this->conn, $sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id=$id";
        return mysqli_query($this->conn, $sql);
    }
}
