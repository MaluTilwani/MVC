<?php
require_once 'models/User.php';

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->user->create($_POST['username'], $_POST['password'], $_POST['role']);
                    header('Location: index.php?action=list');
                } else {
                    include '/ems-system/app/views/task-views/create_user.php';
                }
                break;

            case 'list':
                $users = $this->user->readAll();
                include 'views/user-list.php';
                break;

            case 'edit':
                $id = $_GET['id'];
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->user->update($id, $_POST['username'], $_POST['role']);
                    header('Location: index.php?action=list');
                } else {
                    $user = $this->user->read($id);
                    include 'views/edit-user.php';
                }
                break;

            case 'delete':
                $this->user->delete($_GET['id']);
                header('Location: index.php?action=list');
                break;
        }
    }
}
