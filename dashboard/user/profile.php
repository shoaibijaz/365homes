<?php
$page_title = 'My Profile';
include '../includes/header.php';

$userID = $_SESSION['login_agent']['id'];

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="profilePanel">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">User Profile</h6>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div id="profileFormPanel"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow mt-2">
                                <div class="card-body">
                                    <form action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmPhoto">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file" id="fuPhoto">
                                                    <label class="custom-file-label" for="customFile1">Choose Photo</label>
                                                </div>
                                                <div class="progress mt-2" style="height:2px;">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-center mt-3">
                                                <img src="" alt="" class="img-thumbnail w-50">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="btnSaveProfile">Save Profile</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/x-handlebars-template" id='profileFormTemplate'>

    <form action="/api/app_users/update_profile.php" method="post" id="fmProfile">
        <input type="hidden" name="id" value="{{id}}">
        <input type="hidden" name="photo" value="{{photo}}">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i1">First Name*</label>
                    <input type="text" name="first_name" value="{{first_name}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Last Name*</label>
                    <input type="text" name="last_name" value="{{last_name}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Phone</label>
                    <input type="text" name="phone" value="{{phone}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="i2">Email</label>
                    <input type="text" name="email" value="{{email}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

    </form>

</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>

<script type="text/javascript">
    (function($) {

        $.ProfileManager = function(options) {

            var userObject;

            var agentProfileObject = {
                user_id: 1
            };

            var uID = "<?php echo ($userID) ?>";

            var settings = $.extend({}, options);

            var getProfile = function() {
                $.get('/api/app_users/find.php', {
                    id: uID
                }, function(response) {
                    userObject = JSON.parse(response);
                    loadProfileForm();
                });

            };

            var loadProfileForm = function() {

                if (userObject) {
                    var source = document.getElementById("profileFormTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#profileFormPanel").html(template(userObject));
                }

                if ($("#fmProfile input[name='photo']").val()) {

                    $("#fmPhoto .img-thumbnail").attr('src', $("#fmProfile input[name='photo']").val());

                    var deleteLink = ' <a href="javascript:;" id="btnDeletePhoto" class="btn text-danger mt-2">Delete</a>';

                    $("#fmPhoto .img-thumbnail").parent().find("#btnDeletePhoto").remove();
                    $("#fmPhoto .img-thumbnail").parent().append(deleteLink);
                }


                $("#fmProfile").ajaxForm({
                    beforeSubmit: function() {
                        var r = $("#fmProfile").valid();
                        if (!r) return r;

                        $("#profilePanel input").attr('disabled', true);
                        $("#profilePanel button").attr('disabled', true);
                    },
                    success: onSaveUserProfile,
                });

                $("#fmProfile").validate({
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
                                url: "/api/app_users/email_exist.php?id=" + uID,
                                type: "post"
                            }
                        },
                    },
                    messages: {
                        email: {
                            remote: "This email already exist."
                        },
                    },
                });

            };

            var onSaveUserProfile = function(response) {
                var r = JSON.parse(response);

                if (r.result > 0) {
                    toastr.success('Profile has been updated.');
                }

                $("#profilePanel input").attr('disabled', false);
                $("#profilePanel button").attr('disabled', false);
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
                getProfile();
            };

            init();

        };

        $.MainPhotoManager = function(options) {

            var that = this;

            var settings = $.extend({}, options);

            var imageForm = function() {

                $('#fmPhoto').ajaxForm({
                    beforeSend: function() {
                        $("#fmPhoto.progress-bar").empty();
                        var percentVal = '0%';
                        $("#fmPhoto .progress-bar").css('width', percentVal)
                        $("#fmPhoto.progress-bar").html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        $("#fmPhoto .progress-bar").css('width', percentVal)
                        $("#fmPhoto .progress-bar").html(percentVal);
                    },
                    success: function(responseText, statusText, xhr, $form) {
                        var parsed = JSON.parse(responseText);

                        if (parsed.message) {

                            $("#fmProfile input[name='photo']").val(parsed.message);
                            $("#fmPhoto .img-thumbnail").attr('src', parsed.message);

                            var deleteLink = ' <a href="javascript:;" id="btnDeletePhoto" class="btn text-danger mt-2">Delete</a>';

                            $("#fmPhoto .img-thumbnail").parent().find("#btnDeletePhoto").remove();
                            $("#fmPhoto .img-thumbnail").parent().append(deleteLink);
                        }

                        $("#fmPhoto .progress-bar").css('width', 0);
                    },
                    complete: function(xhr) {}
                });
            };

            var drawPhoto = function(photo) {
                $("#pills-main-photo img").attr('src', photo);
            };

            var registerEvents = function() {

                $("div").on("change", "#fuPhoto", function(e) {
                    e.stopPropagation();
                    $('#fmPhoto').submit();
                });

                $("div").on("click", "#btnDeletePhoto", function(e) {
                    e.stopPropagation();

                    $("#fmProfile input[name='photo']").val(null);
                    $("#fmPhoto .img-thumbnail").attr('src', null);

                    $("#fmPhoto .img-thumbnail").parent().find("#btnDeletePhoto").remove();

                });
            };

            var init = function() {
                registerEvents();
                imageForm();
                //drawPhoto(settings.productObject.main_image);
            };

            init();

        };

    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.ProfileManager({});
        new $.MainPhotoManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>