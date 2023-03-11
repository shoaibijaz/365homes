<?php
$page_title = 'Manage Property';
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
                            <div id="agentProfileFormPanel"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
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
        <input type="hidden" name="phone" value="{{phone}}">
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
                    <label for="i2">Email</label>
                    <input type="text" name="email" readonly value="{{email}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

    </form>

</script>

<script type="text/x-handlebars-template" id='agentFormItemTemplate'>
    <form action="/api/app_agent_profile/save.php" method="post" id="fmAgentProfile">
    <input type="hidden" name="id" value="{{id}}">
    <input type="hidden" name="user_id" value="{{user_id}}">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i1">Company Name*</label>
                    <input type="text" name="company_name" value="{{company_name}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Designation*</label>
                    <input type="text" name="designation" value="{{designation}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Fax</label>
                    <input type="text" name="fax" value="{{fax}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i1">Office Contact No. *</label>
                    <input type="text" name="office_contact" value="{{office_contact}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Mobile No.</label>
                    <input type="text" name="mobile_contact" value="{{mobile_contact}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Office Email</label>
                    <input type="email" name="email_contact" value="{{email_contact}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i1">Website URL</label>
                    <input type="text" name="website_url" value="{{website_url}}" class="form-control form-control-sm">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="i2">Facebook URL</label>
                    <input type="text" name="facebook_url" value="{{facebook_url}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>
    </form>
</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>


<link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css" />
<link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css" />
<link type="text/css" rel="stylesheet" href="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.css" />

<script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
<script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
<script src="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.js"></script>

<script src="/admin_assets/vendor/easy_autocomplete/jquery.easy-autocomplete.min.js"></script>
<link rel="stylesheet" href="/admin_assets/vendor/easy_autocomplete/easy-autocomplete.min.css">
<link rel="stylesheet" href="/admin_assets/vendor/easy_autocomplete/easy-autocomplete.themes.min.css">

<style>
    .mq-dropdown-menu {
        z-index: 9999 !important;
    }

    .mq-input {
        height: 34px !important;
    }
</style>

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

                        // $("#profilePanel input").attr('disabled', true);
                        // $("#profilePanel button").attr('disabled', true);
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
                        }
                    },
                });

            };

            var getAgentProfile = function() {
                $.get('/api/app_agent_profile/find_by_user.php', {
                    user_id: uID
                }, function(response) {

                    var parsedResponse = JSON.parse(response);

                    if (parsedResponse != false)
                        agentProfileObject = parsedResponse

                    loadAgentProfileForm();
                });

            };

            var loadAgentProfileForm = function() {

                agentProfileObject['user_id'] = uID;

                var source = document.getElementById("agentFormItemTemplate").innerHTML;
                var template = Handlebars.compile(source);
                $("#agentProfileFormPanel").html(template(agentProfileObject));

                $("#fmAgentProfile").ajaxForm({
                    beforeSubmit: function() {
                        var r = $("#fmAgentProfile").valid();
                        if (!r) return r;

                        // $("#profilePanel input").attr('disabled', true);
                        // $("#profilePanel button").attr('disabled', true);
                    },
                    success: onSaveAgentProfile,
                });

                $("#fmAgentProfile").validate({
                    rules: {
                        company_name: {
                            required: true,
                        },
                        designation: {
                            required: true,
                        },
                        office_contact: {
                            required: true,
                        }
                    },
                });

            };

            var onSaveUserProfile = function(response) {
                var r = JSON.parse(response);
            };

            var onSaveAgentProfile = function(response) {

                var r = JSON.parse(response);

                if (r.result > 0) {
                    toastr.success('Profile has been saved', 'Success');

                    getProfile();
                    getAgentProfile();

                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

                $("#profilePanel input").attr('disabled', false);
                $("#profilePanel button").attr('disabled', false);
            };

            var registerEvents = function() {

                $("div").on("click", "#btnSaveProfile", function(e) {
                    e.stopPropagation();
                    var profileValid = $("#fmProfile").valid();
                    var agentProfileValid = $("#fmAgentProfile").valid();

                    if (profileValid && agentProfileValid) {
                        $("#fmProfile").submit();
                        $("#fmAgentProfile").submit();
                    }
                });

                $("div").on("click", ".link-clear-location", function(e) {
                    e.stopPropagation();
                    try {
                        var layers = fg.getLayers();
                        for (var i = 0; i < layers.length; i++) {
                            fg.removeLayer(layers[i]);
                        }

                        $("input[name='map_location']").val(null);

                    } catch (error) {}
                });

            };

            var init = function() {
                registerEvents();
                getProfile();
                getAgentProfile();
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