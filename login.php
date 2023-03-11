<?php

session_start();

if (isset($_SESSION['login_agent'])) {
    header("Location: /dashboard");
} else if (isset($_SESSION['login_admin'])) {
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

    <title>365Homes - Login</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/fe_assets/assets/logo.jpg">

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

        <div class="col-md-6 m-auto">

            <div class="text-center mt-3 p-4">
                <a href="/">
                    <img src="/fe_assets/assets/logo.jpg" width="50%">
                </a>
            </div>
            <div class="card o-hidden border-0" id="signupCont">
                <div class="card-body bg-dark p-0">

                    <div class="text-center mt-2">
                        <h1 class="h4 text-dark mb-4">Welcome! Log in:
                           
                            </h1>     
                    </div>

                    <div class="p-3">

                        <div id="msg" role="alert">
                        </div>

                        <form method="post" class="user" id="signup">

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form-control-user rounded-0" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="password" class="form-control form-control-user rounded-0" id="password" name="password" placeholder="Password">
                                </div>

                            </div>
                            <button type="button" id="btnSubmit" class="btn btn-dark btn-user btn-block">
                                Login
                            </button>
                            <hr>

                        </form>

                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <a class="text-dark font-weight-bold" href="forgot_password.php">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <a class="text-dark font-weight-bold" href="signup.php">Create an Account!</a>
                                </div>
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
        (function($) {

            $.register_page = function(options) {

                var settings = $.extend({
                    container: '#signupCont'
                }, options);

                var init_form = function() {

                    var options = {
                        url: 'api/app_users/login.php',
                        beforeSubmit: show_request,
                        success: show_response,
                    };

                    _element("form").ajaxForm(options);
                };

                var init_validate = function() {
                    _element("form").validate({
                        rules: {
                            email: {
                                required: true
                            },
                            password: {
                                required: true,
                            }
                        },
                    });
                };

                var show_request = function() {

                    var r = _element("form").valid();

                    _element('#msg').empty();

                    if (!r) return r;

                    form_state(true);

                };

                var show_response = function(response) {

                    try {
                        var parsedJson = JSON.parse(response);

                        if (parsedJson.result > 0) {
                            window.location.reload();
                        } else {
                            _element('#msg').addClass('alert alert-warning').html(parsedJson.message)
                        }
                    } catch {}

                    form_state(false);
                };
                var form_state = function(working) {
                    if (working)
                        _element("form").find("input, select, button").attr('disabled', true);
                    else
                        _element("form").find("input, select, button").attr('disabled', false);
                };

                var _element = function(selector) {
                    return $(settings.container).find(selector);
                };

                var register_event = function() {

                    $("div").on("click", "#btnSubmit", function(e) {
                        e.stopPropagation();
                        _element("form").submit();
                    });

                    $("div").on("keypress", "form input", function(e) {
                        e.stopPropagation();

                        if (e.which == 13) {
                            _element("form").submit();
                        }

                    });
                };

                var init = function() {
                    register_event();
                    init_form();
                    init_validate();
                };

                init();

                return this;
            }

            var pls = new $.register_page();

        }(jQuery));
    </script>
</body>

</html>