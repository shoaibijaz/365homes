<?php

session_start();

if (isset($_SESSION['login_agent'])) {
    header("Location: /dashboard");
}

if (isset($_SESSION['login_admin'])) {
    header("Location: /admin");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>365Homes - Register</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/fe_assets/assets/logo.jpg">

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin_assets/css/sb-admin-2.css" rel="stylesheet">

    <style>
        .bg-yellow {
            background-color: #ffd401;
        }

        .bg-dark {
            background-color: #ffd401 !important;
        }
    </style>
</head>

<body class="bg-yellow">

    <div class="container">

        <div class="card o-hidden border-0 my-3 bg-dark" id="signupCont">
            <div class="card-body bg-dark p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-9 m-auto">
                        <div class="p-5">
                            <div class="text-center mb-5">
                                <a href="/">
                                    <img src="/fe_assets/assets/logo.jpg" width="30%">
                                </a>
                            </div>


                            <div id="msg" class="alert alert-info" role="alert">
                                <p>
                                    You have been registered successfully. Please check your email in order to verify your account.
                                </p>

                                <p>
                                If you cannot locate our email in your inbox, please check your spam folder. 
                                </p>
                            </div>

                       
                            <div class="text-center">
                                <a class="small font-weight-bold" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="admin_assets/vendor/jquery/jquery.min.js"></script>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/vendor/jquery/jquery.validate.min.js"></script>
    <script src="admin_assets/vendor/jquery/jquery.form.js"></script>
    <!-- Core plugin JavaScript-->

    <!-- Custom scripts for all pages-->
    <script src="admin_assets/js/sb-admin-2.min.js"></script>

    <script>
     
    </script>
</body>

</html>