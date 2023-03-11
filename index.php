<?php

session_start();

if (isset($_SESSION['login_agent'])) {
    header("Location: /dashboard");
} else if (isset($_SESSION['login_admin'])) {
    header("Location: /admin");
}
else{
    header("Location: /login");
}

?>