<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['quizes']);
session_destroy();
header('Location: /index.php');
?>