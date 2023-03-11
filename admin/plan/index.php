<?php
$page_title = 'Plans';

include '../includes/header.php';
?>

<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark">Plans</h6>

            <div>
                <button type="button" class="btn btn-info btn-bordered btn-sm link-add-new">
                    <i class="fa fas fa-plus"></i>
                    Add New Plan</button>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="productsList">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Credits</th>
                                <th>Months</th>
                                <th>Price</th>
                                <th>Level</th>
                                <th>Tag</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> <!-- end container -->

<form class="d-none" action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmImage">
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="file" id="fu">
    </div>
</form>

<div id="formModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">

    </div>
</div><!-- /.modal -->

<div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="card mb-4 box-shadow">


                </div>
            </div>

        </div>
    </div>
</div><!-- /.modal -->

<div id="featuresModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">
                    Features
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="">Name*</label>
                            <input type="text" class="form-control form-control-sm" name="ft_name" autocomplete="on" value="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="">Value*</label>
                            <input type="text" class="form-control form-control-sm" name="ft_value" autocomplete="on" value="">
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="form-group mb-4">
                            <label for="">-----</label>
                            <button type="button" class="btn btn-success btn-sm btn-block">Save</button>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!-- /.modal -->

<script type="text/x-handlebars-template" id='listItemTemplate'>
    <tr id='{{id}}'>
    <td>{{counter}}</td>
    <td>{{plan_name}}</td>
    <td>{{credits}}</td>
    <td>{{months}}/mo</td>
    <td>{{price}} CAD</td>
    <td>{{level}}</td>
    <td>{{special_tag}}</td>
    <td>

    <a href="javascript:;" class="btn btn-info btn-sm mb-1 border-0 rounded-0 link-features" data-id="{{id}}">
                    Features
            </a>

    <a href="javascript:;" class="btn btn-info btn-sm mb-1 border-0 rounded-0 link-details" data-id="{{id}}">
                    Details
            </a>
    <a href="javascript:;" class="btn btn-info btn-sm mb-1 border-0 rounded-0 link-edit" data-id="{{id}}">
                    Edit
            </a>
            <a href="javascript:;" class="btn btn-danger btn-sm mb-1 border-0 rounded-0 link-delete" data-id="{{id}}">
                    Delete
            </a>
    </td>
    </tr>
</script>

<script type="text/x-handlebars-template" id='formTemplate'>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                {{#ifCond id ' > ' 0}}
                    <span>Update Plan</span>
                    {{else}}
                        <span>New Plan</span>
                {{/ifCond}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="fmEntity" method="post" action="/api/app_plans/save.php">
                <input type="hidden" name="id" value="{{id}}">
                <input type="hidden" name="description" value="{{description}}">
                <input type="hidden" name="image" value="{{image}}">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Name*</label>
                                    <input type="text" class="form-control  form-control-sm" name="plan_name" autocomplete="on" value="{{plan_name}}">
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="">Price*</label>
                                        <input type="number" class="form-control form-control-sm" name="price" min="1" value="{{price}}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="">Credit*</label>
                                        <input type="number" class="form-control  form-control-sm" name="credits" min="1" value="{{credits}}">
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Months*</label>
                                    <input type="number" class="form-control" readonly name="months" min="1" value="{{months}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Level*</label>
                                    <input type="number" class="form-control" name="level" min="1" value="{{level}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Special Tag</label>
                                    <input type="text" class="form-control form-control-sm" name="special_tag" value="{{special_tag}}">
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary waves-effect waves-light" id="btnSave">Save changes</button>
        </div>
    </div>
</script>

<script type="text/x-handlebars-template" id='detailsItemTemplate'>
    <div class="card-body">
    <h1 class="card-title pricing-card-title text-center">${{price}} <small class="text-muted">/ {{months}} mo</small></h1>
    <div class="text-center">
        <h6>{{credits}} Properties Credits</h6>
    </div>
    <div class="text-center"> {{{description}}}</div>
    </div>

</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>

<script>
    (function($) {

        $.PlansManager = function(options) {

            var that = this;

            var productsList = [];

            var productObject;
            var productsDataTable;

            var settings = $.extend({
                productObject: null
            }, options);

            var getList = function() {

                var params = {
                    is_deleted: 0
                };

                $.get('/api/app_plans/filter.php', params, function(response) {
                    productsList = JSON.parse(response);
                    drawList();
                });
            };

            var drawList = function() {

                if (productsDataTable) {
                    productsDataTable.destroy();
                }

                $("#productsList tbody").empty();

                for (let index = 0; index < productsList.length; index++) {

                    var item = productsList[index];

                    if (item.is_deleted == 1) continue;

                    item.counter = index + 1;

                    var source = document.getElementById("listItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    $("#productsList tbody").append(template(item));

                }

                $('#productsList').on('draw.dt', function() {

                    if (!productsDataTable) return;

                    $(".loading").hide();

                });

                productsDataTable = $("#productsList").DataTable({
                    "columnDefs": [{
                        'width': '10px',
                        'targets': 0
                    }, {
                        'width': '80px',
                        'targets': 1
                    }],
                    initComplete: function() {
                        this.api().columns().every(function() {});
                    },
                });


            };

            var initForm = function() {

                $('#fmEntity').ajaxForm({
                    beforeSubmit: function(arr, $form, options) {
                        var r = $("#fmEntity").valid();
                        if (!r) return r;

                        $("#fmEntity input").attr('disabled', true);
                        $("#fmEntity button").attr('disabled', true);

                    },
                    success: function(responseText, statusText, xhr, $form) {
                        var parsed = JSON.parse(responseText);

                        if (parsed.result > 0) {
                            $("#formModal").modal('hide');
                            toastr.success('Plan info has been saved');
                            getList();
                        } else {
                            toastr.success('Plan info failed to saved. Please try again or reload the page.');
                        }

                        $("#fmEntity input").attr('disabled', false);
                        $("#fmEntity button").attr('disabled', false);
                    }
                });
            };

            var validateForm = function() {
                $("#fmEntity").validate({
                    rules: {
                        plan_name: {
                            required: true,
                        },
                        credits: {
                            required: true,
                        },
                        months: {
                            required: true,
                        },
                        price: {
                            required: true,
                        }
                    },
                });
            };

            var deletePlan = function(id) {

                var params = {
                    id: id,
                    is_deleted: 1
                };

                $.post('/api/app_plans/update_delete_status.php', params, function(response) {
                    var r = JSON.parse(response);

                    if (r.result > 0) {
                        toastr.success('Plan has been removed', 'danger');
                        getList();
                    } else {
                        toastr.error('Failed to complete the request', 'INFO!');
                    }
                });
            };

            var viewDetails = function(id) {

                var item = productsList.find(a => a.id == id);

                var source = document.getElementById("detailsItemTemplate").innerHTML;
                var template = Handlebars.compile(source);

                $("#detailModal .modal-title").html(item.plan_name);
                $("#detailModal .modal-body").html(template(item));

                $("#detailModal").modal('show');

            };

            var registerEvents = function() {

                $("div").on("click", ".link-add-new", function(e) {
                    e.stopPropagation();

                    var source = document.getElementById("formTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    var item = {
                        'level': productsList.length + 1,
                        'credits': 1,
                        'months': 1,
                        'price': 4.99
                    };

                    $("#formModal .modal-dialog").html(template(item));

                    $("#formModal").modal({
                        'show': true,
                        'backdrop': 'static'
                    });

                });

                $("div").on("click", "#btnSave", function(e) {
                    e.stopPropagation();

                    $("#fmEntity").submit();

                });

                $("div").on("click", ".link-edit", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');

                    var item = productsList.find(a => a.id == id);

                    var source = document.getElementById("formTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    $("#formModal .modal-dialog").html(template(item));

                    $("#formModal").modal({
                        'show': true,
                        'backdrop': 'static'
                    });

                });

                $("div").on("click", ".link-delete", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    if (!id) return;

                    bootbox.confirm("Are you sure! You want to delete this plan?", function(result) {

                        if (result) {
                            deletePlan(id);
                        }
                    });

                });

                $("div").on("click", ".link-details", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    if (!id) return;

                    viewDetails(id);

                });

                $("div").on("click", ".link-features", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');

                    var item = productsList.find(a => a.id == id);

                    // var source = document.getElementById("formTemplate").innerHTML;
                    // var template = Handlebars.compile(source);

                    // $("#formModal .modal-dialog").html(template(item));

                    $("#featuresModal").modal({
                        'show': true,
                        'backdrop': 'static'
                    });

                });

                $('#formModal').on('shown.bs.modal', function(e) {
                    initForm();
                    validateForm();

                    $("#formModal #description").summernote({
                        height: 200,
                        toolbar: [
                            ['fontsize', ['fontsize']],
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                        ]
                    })
                });
            };

            var init = function() {
                registerEvents();
                getList();
            };

            init();

        };

    }(jQuery));

    $(document).ready(function() {
        var pm = new $.PlansManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>