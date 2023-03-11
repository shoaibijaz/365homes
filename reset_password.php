<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>365Homes - Reset Password</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/fe_assets/assets/logo.jpg">

    <!-- Custom fonts for this template-->
    <link href="admin_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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

        <div class="card o-hidden border-0 my-3" id="signupCont">
            <div class="card-body bg-dark p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7 m-auto">
                        <div class="p-5">
                            <div class="text-center mb-5">
                                <a href="/">
                                <img src="/fe_assets/assets/logo.jpg" width="30%">
                                </a>
                            </div>
                            <div class="text-center">
                                <h1 class="h4 text-white-900 mb-4">Reset Your Password</h1>
                            </div>

                            <div id="msg" role="alert">
                            </div>

                            <form method="post" class="user" id="signup">

                                <input type="hidden" name="password_reset_token" value="<?php echo ($_GET['token']) ?>">
                                <div class="form-group row">
                                    <div class="col mb-3 mb-sm-0  m-auto">
                                        <input type="password" class="form-control form-control-user rounded-0" id="password" name="password" placeholder="Enter Password">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col mb-3 mb-sm-0 m-auto">
                                        <input type="password" class="form-control form-control-user rounded-0" id="re_password" name="re_password" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 m-auto">
                                        <button type="button" id="btnSubmit" class="btn btn-dark btn-user btn-block">
                                            Save Password
                                        </button>
                                    </div>
                                </div>


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
    <script src="admin_assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin_assets/js/sb-admin-2.min.js"></script>

    <script>
        (function($) {

            $.ForgotPassword = function(options) {

                var settings = $.extend({
                    container: '#signupCont'
                }, options);

                var init_form = function() {

                    var options = {
                        url: 'api/app_users/reset_token_password.php',
                        beforeSubmit: show_request,
                        success: show_response,
                    };

                    _element("form").ajaxForm(options);
                };

                var init_validate = function() {
                    _element("form").validate({
                        rules: {

                            password: {
                                required: true,
                            },
                            re_password: {
                                required: true,
                                equalTo: '#password'
                            }

                        },
                        // errorPlacement: function(error, element) {}
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
                            _element('#msg').addClass('alert alert-success');
                            _element('#msg').html(parsedJson.message);
                            _element("form").find("input, select").val(null);

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

            $(document).ready(function() {
                var pls = new $.ForgotPassword();
            });

        }(jQuery));
    </script>
</body>

</html>