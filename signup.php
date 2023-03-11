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
                            <div class="text-center">
                                <a href="/">
                                    <img src="/fe_assets/assets/logo.jpg" width="30%">
                                </a>
                            </div>
                            <div class="text-center">
                                <h1 class="h4 text-white-900 my-4 font-weight-bold">Create an Account!</h1>
                            </div>

                            <div id="msg" role="alert">
                            </div>

                            <form method="post" class="user" id="signup">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user rounded-0" id="first_name" name="first_name" placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user rounded-0" id="last_name" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user rounded-0" id="email" name="email" placeholder="Email">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user rounded-0" id="phone" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user rounded-0" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user rounded-0" id="repeat_password" name="repeat_password" placeholder="Repeat Password">
                                    </div>
                                </div>

                                <p>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="chkTerms" name="chk_terms">
                                    <label class="form-check-label" for="inlineCheckbox1">
                                        By clicking on “Register Now” button you are accepting the <a href="terms.php">Terms & Conditions</a>
                                    </label>
                                </div>
                                </p>

                                <button type="button" id="btnSubmit" class="btn btn-dark btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>

                            </form>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
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
                        url: 'api/app_users/signup.php',
                        beforeSubmit: show_request,
                        success: show_response,
                    };

                    _element("form").ajaxForm(options);
                };

                var init_validate = function() {
                    _element("form").validate({
                        rules: {
                            first_name: {
                                required: true,
                            },
                            last_name: {
                                required: true,
                            },
                            email: {
                                required: true,
                                email: true,
                                remote: {
                                    url: "/api/app_users/email_exist.php",
                                    type: "post"
                                }
                            },
                            password: {
                                required: true,
                            },
                            repeat_password: {
                                required: true,
                                equalTo: '#password',
                            },
                            phone: {
                                required: true
                            },
                            chk_terms: {
                                required: true
                            }
                        },
                        messages: {
                            email: {
                                remote:"This email already exist."
                            },
                        },
                        errorPlacement: function(error, element) {

                            if (($(element).attr('name') == 'chk_terms')) {
                                error.insertAfter($(element).parent());
                            } else {
                                error.insertAfter(element);
                            }

                        }
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
                            window.location.href = 'signup_success.php';

                            // _element('#msg').addClass('alert alert-info');
                            // _element('#msg').html('You have been registered successfully. Please check the mail inbox to verify the account. Please check your spam folder as well');
                            // _element("form").find("input, select").val(null);

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