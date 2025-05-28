<?php
session_start();
session_unset();
session_destroy();
header('Location: /ems-system/public/index.php');
exit();