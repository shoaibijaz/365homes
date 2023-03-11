<?php
$page_title = 'Profiles';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">PROFILES</h6>

                    <button class="btn btn-sm btn-pink link-add-new" type="button">
                        <i class="fa fas fa-plus"></i> ADD NEW PROFILE</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>IMG</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Designation</th>
                                </tr>

                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="userFormModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
    </div>
</div>

<form class="d-none" action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmPhoto">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="file" id="fuPhoto">
                <label class="custom-file-label" for="customFile1">Choose Photo</label>
            </div>
        </div>
    </div>
</form>

<script type="text/x-handlebars-template" id='listItemTemplate'>
    <tr id="{{id}}">
        <td>
        <img src="{{photo}}" alt="" width="30">
        </td>
        <td>
            {{first_name}} {{last_name}}
        </td>
        <td>
          
            {{email_contact}}
          
        </td>
        
        <td>
            
            {{office_contact}}
            <br>
           
            {{mobile_contact}}
           
        </td>

        <td>
           {{company_name}}
        </td>
        <td>
            {{designation}}
        </td>
        
    </tr>
</script>

<script type="text/x-handlebars-template" id='itemDetailTemplate'>

    <div class="row">
       <div class="col-md-9">
         
      
       {{#if website_url}}<a href="{{#addHttp}}{{website_url}}{{/addHttp}}" class="text-primary small" target="_blank">Website</a> -  {{/if}}
       {{#if facebook_url}}   <a href="{{#addHttp}}{{facebook_url}}{{/addHttp}}" class="text-primary small" target="_blank">Facebook</a> -{{/if}}
       {{#if twitter_url}}   <a href="{{#addHttp}}{{twitter_url}}{{/addHttp}}" class="text-primary small" target="_blank">Twitter</a> -{{/if}}
       {{#if instagram_url}}   <a href="{{#addHttp}}{{instagram_url}}{{/addHttp}}" class="text-primary small" target="_blank">Instagram</a>-{{/if}}
       {{#if linkedin_url}}   <a href="{{#addHttp}}{{linkedin_url}}{{/addHttp}}" class="text-primary small" target="_blank">Linkedin</a>{{/if}}
       </div>
       <div class="col-md-3 text-right">
       <a href="javascript:" class="text-info link-details" data-id="{{id}}">View Details</a> |
       <a href="javascript:" class="text-info link-edit" data-id="{{id}}">Edit</a> |
       <a href="javascript:" class="text-danger link-delete" data-id="{{id}}">Delete</a> 
       </div>
    </div>
 
</script>

<script type="text/x-handlebars-template" id='userFormTemplate'>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
            {{#ifCond id '>' 0}}
                <span>Update Profile</span>
                {{else}}
                <span>Add New Profile</span>
            {{/ifCond}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="/api/app_agent_profiles/save.php" method="post" id="fmProfile">
                <input type="hidden" name="id" value="{{id}}">
                <input type="hidden" name="photo" value="{{photo}}">
                <input type="hidden" name="owner_id" value="<?php echo ($_SESSION['login_agent']['id']) ?>">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i1">First Name*</label>
                                            <input type="text" name="first_name" value="{{first_name}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i2">Last Name*</label>
                                            <input type="text" name="last_name" value="{{last_name}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i2">Email*</label>
                                            <input type="text" name="email_contact" value="{{email_contact}}" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i1">Company Name*</label>
                                            <input type="text" name="company_name" value="{{company_name}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i2">Designation*</label>
                                            <input type="text" name="designation" value="{{designation}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="i2">Fax</label>
                                            <input type="text" name="fax" value="{{fax}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="card-body text-center">
                                    <button type="button" class="btn btn-info" id="btnUploadPhoto">Upload Photo</button>

                                    <div class="progress my-2" style="height:2px;">
                                        <div class="progress-bar" role="progressbar"></div>
                                    </div>

                                    <div>
                                        <img src="{{photo}}" alt="" class="img-thumbnail" width="80">
                                    </div>
                                    <p class="act">
                                        {{#if photo}}
                                            <a href="javascript:;" id="btnDeletePhoto" class="btn text-danger mt-2">Delete</a>
                                        {{/if}}
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="row">

                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Office Phone</label>
                                    <input type="text" name="office_contact" value="{{office_contact}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Mobile Phone</label>
                                    <input type="text" name="mobile_contact" value="{{mobile_contact}}" class="form-control form-control-sm">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Website</label>
                                    <input type="text" name="website_url" value="{{website_url}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Facebook link</label>
                                    <input type="text" name="facebook_url" value="{{facebook_url}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Twitter link</label>
                                    <input type="text" name="twitter_url" value="{{twitter_url}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Instagram link</label>
                                    <input type="text" name="instagram_url" value="{{instagram_url}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i2">Linkedin link</label>
                                    <input type="text" name="linkedin_url" value="{{linkedin_url}}" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnSaveUser">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>

<script type="text/javascript">
    (function($) {

        Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
            return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
        });

        Handlebars.registerHelper("dateOnly", function(options) {
            var data = options.fn(this);

            try {

                if ($.trim(data)) {
                    var date = moment($.trim(data)).format('DD-MMM-YYYY');
                    return new Handlebars.SafeString(date);
                }

                return new Handlebars.SafeString('N/A');

            } catch (e) {

            }

            return options.fn(this);
        });

        Handlebars.registerHelper("addHttp", function(options) {

            var url = options.fn(this);

            if (!/^(?:f|ht)tps?\:\/\//.test(url)) {
                url = "http://" + url;
            }
            return url;
        });

        $.UserManager = function(options) {

            var that = this;

            var usersList = [];
            var userDataTable;

            var settings = $.extend({}, options);

            var getUsers = function() {

                if (userDataTable) {
                    userDataTable.destroy();
                    userDataTable = undefined;
                }

                $("#usersTable tbody").empty();

                $.get('/api/app_agent_profiles/filter.php', {
                    is_deleted: 0
                }, function(response) {
                    var data = JSON.parse(response);

                    for (let index = 0; index < data.length; index++) {
                        var element = data[index];

                        var source = document.getElementById("listItemTemplate").innerHTML;
                        var template = Handlebars.compile(source);

                        $("#usersTable tbody").append(template(element));
                    }

                    $('#usersTable').on('draw.dt', function() {

                        if (!userDataTable) return;

                        $("#usersTable tbody tr").each(function() {

                            var row = userDataTable.row($(this));

                            var source = document.getElementById("itemDetailTemplate").innerHTML;
                            var template = Handlebars.compile(source);

                            var element = usersList.find(a => a.id == $(this).attr('id'));

                            console.log($(this).attr('id'));

                            row.child(template(element)).show();

                        });

                        $(".loading").hide();

                    });

                    userDataTable = $("#usersTable").DataTable({
                        "columnDefs": [{
                                "targets": $("#usersTable th").length - 1,
                                "orderable": false
                            },
                            {
                                targets: [4],
                                orderData: [0]
                            }
                        ],

                    });

                    usersList = data;

                    userDataTable.order([
                        [3, 'desc']
                    ]).draw();

                });

            };

            var initForm = function() {
                $("#fmProfile").ajaxForm({
                    beforeSubmit: function() {
                        var r = $("#fmProfile").valid();
                        if (!r) return r;

                        $("#userFormModal input").attr('disabled', true);
                        $("#userFormModal button").attr('disabled', true);
                    },
                    success: onSaveProfile,
                });
            };

            var onSaveProfile = function(response) {
                var r = JSON.parse(response);

                if (r.result > 0) {
                    toastr.success('Profile has been saved', 'Success');
                    getUsers();
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

                $("#userFormModal").modal('hide');

                $("#userFormModal input").attr('disabled', false);
                $("#userFormModal button").attr('disabled', false);
            };

            var validateForm = function() {
                $("#fmProfile").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_contact: {
                            required: true,
                            email: true
                        },
                        company_name: {
                            required: true
                        },
                    },
                });

            };

            var registerEvents = function() {

                $("div").on("click", ".link-add-new", function(e) {
                    e.stopPropagation();

                    var source = document.getElementById("userFormTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#userFormModal .modal-dialog").html(template({}));

                    $("#userFormModal").modal('show');

                });

                $("div").on("click", "#btnSaveUser", function(e) {
                    e.stopPropagation();

                    $("#fmProfile").submit();

                });

                $("div").on("click", ".link-delete", function(e) {
                    e.stopPropagation();

                    var status = $(this).attr('value');
                    var id = $(this).attr('data-id');

                    bootbox.confirm("Are you sure? You want to delete profile!", function(result) {
                        if (result) {
                            $.post('/api/app_agent_profiles/update_delete_status.php', {
                                is_deleted: status,
                                id: id
                            }, function(response) {
                                var r = JSON.parse(response);

                                if (r.result == 1) {
                                    toastr.success('Profile has been deleted', 'Success');
                                    getUsers();
                                } else {
                                    toastr.error('Failed to complete the request', 'INFO!');
                                }
                            });
                        }
                    });

                    return;
                    
                });

                $("div").on("click", ".link-edit", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');
                    if (!id) return;

                    var item = usersList.find(a => a.id == id);

                    var source = document.getElementById("userFormTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#userFormModal .modal-dialog").html(template(item));

                    $("#userFormModal").modal('show');

                });

                $("div").on("click", ".link-details", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');
                    if (!id) return;

                    var item = usersList.find(a => a.id == id);

                    var source = document.getElementById("userFormTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#userFormModal .modal-dialog").html(template(item));

                    $("#userFormModal").modal('show');

                });

                $('#userFormModal').on('shown.bs.modal', function(e) {
                    initForm();
                    validateForm();
                });

            };

            var init = function() {
                registerEvents();
                getUsers();
            };

            init();

        };

        $.MainPhotoManager = function(options) {

            var that = this;

            var settings = $.extend({}, options);

            var imageForm = function() {

                $('#fmPhoto').ajaxForm({
                    beforeSend: function() {
                        $("#userFormModal .progress-bar").empty();
                        var percentVal = '0%';
                        $("#userFormModal .progress-bar").css('width', percentVal)
                        $("#userFormModal .progress-bar").html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        $("#userFormModal .progress-bar").css('width', percentVal)
                        $("#userFormModal .progress-bar").html(percentVal);
                    },
                    success: function(responseText, statusText, xhr, $form) {
                        var parsed = JSON.parse(responseText);

                        if (parsed.message) {

                            $("#userFormModal input[name='photo']").val(parsed.message);
                            $("#userFormModal .img-thumbnail").attr('src', parsed.message);

                            var deleteLink = ' <a href="javascript:;" id="btnDeletePhoto" class="btn text-danger mt-2">Delete</a>';

                            $("#userFormModal .act").find("#btnDeletePhoto").remove();
                            $("#userFormModal .act").append(deleteLink);
                        }

                        $("#userFormModal .progress-bar").css('width', 0);
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

                $("div").on("click", "#btnUploadPhoto", function(e) {
                    e.stopPropagation();
                    $("#fuPhoto").trigger('click');
                });

                $("div").on("click", "#btnDeletePhoto", function(e) {
                    e.stopPropagation();

                    $("#userFormModal input[name='photo']").val(null);
                    $("#userFormModal .img-thumbnail").attr('src', null);

                    $(this).remove();

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
        var ins = new $.UserManager({});
        new $.MainPhotoManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>