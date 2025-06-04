<?php

require_once "../model/User.php";
require_once "../model/Task.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class TaskController {
    private $taskModel;

     public function __construct() {
        $this->userModel = new User();
     }

// public function edit($id) {
//     $task = $this->taskModel->getById($id);
//     $users = $this->userModel->getAllExceptAdmins();
//     include 'views/tasks/edit.php';
// }

public function update($id) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    $this->taskModel->update($id, $title, $description, $assigned_to);
    header("Location: /tasks"); // Redirect to task list
}

// Handle delete
public function delete($id) {
    $this->taskModel->delete($id);
    header("Location: manage_task.php");
}
}