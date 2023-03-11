<?php
$page_title = 'Change Password';
include '../includes/header.php';

$userID = $_SESSION['login_agent']['id'];

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="profilePanel">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Change Password</h6>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <form action="/api/app_users/change_password.php" method="post" id="fmProfile">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="i1">Current Password*</label>
                                            <input type="password" name="password" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="i2">New Password*</label>
                                            <input type="password" name="password_reset_token" id="password_reset_token"  class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="i2">Confirm New Password*</label>
                                            <input type="password" name="password_confirm" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="btnSaveProfile">Save Password</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>


<script type="text/javascript">
    (function($) {

        $.ProfileManager = function(options) {

            var settings = $.extend({}, options);

            var initForm = function() {
                $("#fmProfile").ajaxForm({
                    resetForm:true,
                    beforeSubmit: function() {
                        var r = $("#fmProfile").valid();
                        if (!r) return r;

                        $("#profilePanel input").attr('disabled', true);
                        $("#profilePanel button").attr('disabled', true);
                    },
                    success: onSaveProfile,
                });
            };

            var onSaveProfile = function(response) {
                var r = JSON.parse(response);

                if (r.result > 0) {
                    toastr.success('Password has been updated', 'Success');
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

                $("#profilePanel input").attr('disabled', false);
                $("#profilePanel button").attr('disabled', false);

            };

            var validateForm = function() {
                $("#fmProfile").validate({
                    rules: {
                        password: {
                            required: true,
                        },
                        'password_reset_token': {
                            required: true,
                        },
                        'password_confirm': {
                            equalTo:'#password_reset_token'
                        },
                    },
                });

            };

            var registerEvents = function() {

                $("div").on("click", "#btnSaveProfile", function(e) {
                    e.stopPropagation();
                    var profileValid = $("#fmProfile").valid();

                    if (profileValid) {
                        $("#fmProfile").submit();
                    }
                });

            };

            var init = function() {
                registerEvents();
                initForm();
                validateForm();
            };

            init();

        };


    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.ProfileManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>