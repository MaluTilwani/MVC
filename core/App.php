<?php
require_once '../config/database.php';


spl_autoload_register(function ($class) {
    if (file_exists("../app/controllers/$class.php")) {
        require_once "../app/controllers/$class.php";
    } elseif (file_exists("../app/models/$class.php")) {
        require_once "../app/models/$class.php";
    }
});
