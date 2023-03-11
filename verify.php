<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>365Homes - Email Verification</title>
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

        .alert-dark {
            background-color: #4d4d4d !important;
    border: 0;
    color: #fff;
        }
    </style>
</head>

<body class="bg-yellow" id="verify">

    <div class="container">

        <div class="card o-hidden border-0 my-5" id="signupCont">
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
                            <div class="text-center">
                                <h1 class="h4 text-white-900 mb-4">Email Verification!</h1>
                            </div>

                            <div id="msg" class="alert alert-dark text-center" role="alert">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>

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

            $.verify_page = function(options) {

                var settings = $.extend({
                    container: '#verify',
                    url: 'api/app_users/verify.php'
                }, options);

                var send_request = function() {

                    $.post(settings.url, {
                        verified_token: qs['token']
                    }, function(response) {
                        show_response(response);
                    });

                };

                var show_response = function(response) {

                    try {
                        var parsedJson = JSON.parse(response);

                        $('#msg').html(parsedJson.message);

                        if (parsedJson.result > 0) {
                            setTimeout(() => {
                                window.location.href = '/login.php'
                            }, 2000);
                        }


                    } catch {}

                };

                var register_event = function() {};

                var init = function() {
                    register_event();
                    send_request();
                };

                init();

                return this;
            }

            var qs = (function(a) {
                if (a == "") return {};
                var b = {};
                for (var i = 0; i < a.length; ++i) {
                    var p = a[i].split('=', 2);
                    if (p.length == 1)
                        b[p[0]] = "";
                    else
                        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
                }
                return b;
            })(window.location.search.substr(1).split('&'));


            $(document).ready(function() {
                var pls = new $.verify_page();
            });

        }(jQuery));
    </script>
</body>

</html>