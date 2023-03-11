<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['uni_login_admin'])) {
    header("Location: /login.php");
}

?>
