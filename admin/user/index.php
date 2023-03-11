<?php
$page_title = 'Users';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Users</h6>

                    <button class="btn btn-sm btn-info link-add-new" type="button">
                        <i class="fa fas fa-plus"></i> Add New</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Credits</th>
                                    <th>Date</th>
                                    <th>Status</th>
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
        {{id}}
        </td>
        <td>
            {{first_name}} {{last_name}}
        </td>
        <td>
            <small>
            {{email}}
            </small>
        </td>
        
        <td>
            <small>
            {{phone}}
            </small>
        </td>
        <td>
            {{credits}}
        </td>
        <td>
            <small>  {{#dateOnly}} {{created_on}} {{/dateOnly}}</small>
        </td>
        <td>
            <small>{{status}}</small>        
        </td>

     


        
    </tr>
</script>

<script type="text/x-handlebars-template" id='itemDetailTemplate'>

    <div class="row">
       <div class="col">
       <span class="badge badge-primary mr-3">Login</span> <strong>{{login_name}}   </strong>
       <span class="badge badge-info">Password</span> <strong>{{password}}</strong>
       </div>
       <div class="col text-right">
       <a href="javascript:" title="Edit" class="btn btn-info btn-sm btn-circle link-edit" pk="{{id}}">
                    <i class="fas fa-pen"></i>
        </a>

        <a href="javascript:" title="Add Credits" class="btn btn-info btn-sm btn-circle link-credits" value="1" pk="{{id}}">
                    <i class="fas fa-coins"></i>
        </a>

        <a href="javascript:" title="Change Password" class="btn btn-info btn-sm btn-circle link-password" value="1" pk="{{id}}">
                    <i class="fas fa-key"></i>
        </a>

        <a href="javascript:;" title="Delete User" class="btn btn-danger btn-sm btn-circle link-update-delete" value="1" pk="{{id}}">
        <i class="fas fa-times"></i>
        </a>
       </div>
    </div>
 
</script>

<script type="text/x-handlebars-template" id='userFormTemplate'>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
            {{#ifCond id '>' 0}}
                <span>Update User</span>
                {{else}}
                <span>Add New User</span>
            {{/ifCond}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="/api/app_users/save_admin.php" method="post" id="fmProfile">
                <input type="hidden" name="id" value="{{id}}">
                <input type="hidden" name="photo" value="{{photo}}">
                <input type="hidden" name="user_type" value="2">
                <input type="hidden" name="status" value="pending">
                <input type="hidden" name="is_super" value="0">

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
                        
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="i2">Email</label>
                                    <input type="text" name="email" value="{{email}}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="i1">Login Name*</label>
                                    <input type="text" name="login_name" value="{{login_name}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="i2">Password*</label>
                                    <input type="text" name="password" value="{{password}}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="i2">Phone</label>
                                    <input type="text" name="phone" value="{{phone}}" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mt-4">
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

        $.UserManager = function(options) {

            var that = this;

            var usersList = [];
            var userDataTable;

            var settings = $.extend({}, options);

            var getUsers = function() {

                if (userDataTable) {
                    userDataTable.destroy();
                }

                $("#usersTable tbody").empty();

                $.get('/api/app_users/filter.php', {
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

            var updatePassword = function(id, password) {
                $.post('/api/app_users/update_password.php', {
                    id: id,
                    password: password
                }, function(response) {

                    var parsed = JSON.parse(response);

                    if (parsed.result > 0) {
                        getUsers();
                        toastr.success('Password is updated');
                    } else {
                        toastr.error('Password is failed to update');
                    }
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
                    toastr.success('User has been saved', 'Success');
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
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        },
                        login_name: {
                            required: true
                        }
                    },
                });

            };

            var updateCredits = function(id, credits, lastCredits) {
                $.post('/api/app_users/update_credits.php', {
                    id: id,
                    credits: credits,
                    last_credits:lastCredits
                }, function(response) {

                    var parsed = JSON.parse(response);

                    if (parsed.result > 0) {
                       getUsers();
                        toastr.success('Credits are updated');
                    } else {
                        toastr.error('Credits is failed to update');
                    }
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

                $("div").on("click", ".link-update-delete", function(e) {
                    e.stopPropagation();

                    var status = $(this).attr('value');
                    var id = $(this).attr('pk');

                    bootbox.confirm("Are you sure? You want to delete user!", function(result) {
                        if (result) {
                            $.post('/api/app_users/delete_status.php', {
                                is_deleted: status,
                                id: id
                            }, function(response) {
                                var r = JSON.parse(response);

                                if (r.result == 1) {
                                    toastr.success('User has been updated', 'Success');
                                    getUsers();
                                } else {
                                    toastr.error('Failed to complete the request', 'INFO!');
                                }
                            });
                        }
                    });

                    return;

                });

                $("div").on("click", ".link-password", function(e) {
                    e.stopPropagation();

                    var status = $(this).attr('value');
                    var id = $(this).attr('pk');

                    if (!id) return;

                    bootbox.prompt("Enter the new password", function(result) {
                        if (result)
                            updatePassword(id, result);
                    });

                });

                $("div").on("click", ".link-edit", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('pk');
                    if (!id) return;

                    var item = usersList.find(a => a.id == id);

                    var source = document.getElementById("userFormTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#userFormModal .modal-dialog").html(template(item));

                    $("#userFormModal").modal('show');

                });

                $("div").on("click", ".link-credits", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('pk');
                    if (!id) return;

                    var item = usersList.find(a => a.id == id);

                    bootbox.prompt({
                        title: "Add Credits!",
                        value: [item.credits && item.credits > 0 ? item.credits : null],
                        centerVertical: true,
                        callback: function(result) {
                            if(result) {
                                updateCredits(id, result, item.credits);
                            }
                        }
                    });


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