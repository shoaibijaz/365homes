<?php


if (isset($_SESSION['login_user']) && $_SESSION['login_user']['is_super'] > 0) {
    //
} else {
    header("Location: /403.php");
}

?>