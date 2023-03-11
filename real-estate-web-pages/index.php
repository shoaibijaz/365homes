<?php

session_start();

if (isset($_SESSION['login_agent'])) {

    header("Location: /dashboard");

    // if ($_SESSION['login_user']['is_super'] > 0) {
    //     header("Location: /dashboard");
    // }
    // else {
    //     header("Location: /dashboard");
    // }

} else {
    header("Location: /login.php");
}

?>

<html>

<head>
    <title>365Homes</title>
    <link rel="icon" type="image/png" sizes="32x32" href="admin_assets/img/fav.png">
    <style>
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 40px;
            height: 40px;
            border-style: solid;
            border-color: black;
            border-top-color: transparent;
            border-width: 4px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
</head>

<body>
    <div id="cover-spin"></div>
</body>

</html>