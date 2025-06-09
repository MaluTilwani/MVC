<?php
class Database {
    private $host = "db";
    private $user = "db";
    private $pass = "db";
    private $dbname = "db";
    public $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
