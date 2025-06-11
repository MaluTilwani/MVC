<?php

require_once "../model/User.php";
require_once "../model/Task.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class TaskController {
    private $taskModel;

     public function __construct() {
        $this->taskModel = new Task();
     }



public function update($id) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    $this->taskModel->update($id, $title, $description, $assigned_to, $due_date, $priority, $status);
    header("Location: /tasks"); // Redirect to task list
}

// Handle delete
public function delete($id) {
    $this->taskModel->delete($id);
    header("Location: manage_task.php");
}
}