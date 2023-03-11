<?php

session_start();

unset($_SESSION['login_agent']);
unset($_SESSION['login_admin']);
session_destroy();

header("Location: /login.php");
?>
