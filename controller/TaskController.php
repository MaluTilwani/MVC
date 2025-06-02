<?php
require_once "../model/User.php";
require_once "../model/Task.php";

session_start();

class TaskController {
public function edit($id) {
    $task = $this->taskModel->getById($id);
    $users = $this->userModel->getAllExceptAdmins(); 
    include 'views/tasks/edit.php';
}

// Handle update
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
    header("Location: /tasks");
}
}