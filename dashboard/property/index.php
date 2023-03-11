<?php
$page_title = 'Properties';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">Properties</h6>

                    <div>
                        <a href="./manager.php" class="btn btn-sm btn-pink link-add-new">
                            <i class="fa fas fa-plus"></i> ADD NEW PROPERTY
                        </a>
                    </div>
                </div>
                <div class="card-body h-100">

                    <div class="loading">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 offset-md-4">
                            <select name="" id="ddlAgents" class="form-control form-control-sm">
                                <option value="">Filter Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tblList" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>Sale Price</th>
                                    <th>Type</th>
                                    <th>Published</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>

</div>

<div id="cloneModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make a clone of the property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fmClone" method="post">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group d-none">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter address">
                    </div>
                    <div id="progress" class="d-none">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                        <span class="ml-3"> Copying Basic.. </span>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCreateClone">Create Clone</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='listItemTemplate'>
    <tr id="{{id}}">
      
        <td class="small">
            {{address}}
        </td>

        <td class="small"> 
        {{#priceFormat}} {{price}}{{/priceFormat}}
        </td>
        
        <td class="small">
           {{property_type}}
        </td>

        <td>
        {{#ifCond is_published '==' 1}}
      <span>Yes</span>
      {{else}}
      <span>No</span>
       {{/ifCond}}
        </td>
        <td class="small"  data-sort="{{id}}">
        {{#dateOnly}} {{created_on}}{{/dateOnly}}
        </td>

        
    </tr>
</script>

<script type="text/x-handlebars-template" id='itemActionTemplate'>

    <div class="row">
       <div class="col">
       
       <a href="{{#url}}{{address}}{{/url}}" target="_blank" class="btn btn-dark btn-sm mb-1 border-0 rounded-0">View</a>
       <a href="./messages.php?property={{id}}"  class="btn btn-dark btn-sm mb-1 border-0 rounded-0">View Messages</a>

       </div>
        <div class="col text-right">
        
        <a href="./manager.php?id={{id}}" target="_blank" class="btn btn-info btn-sm mb-1 border-0 rounded-0">
            Edit
        </a>
        <a href="javascript:;" class="btn btn-info btn-sm mb-1 border-0 rounded-0 link-clone" data-id="{{id}}">
            Clone
        </a>
        <a href="javascript:;" class="btn btn-danger btn-sm link-delete mb-1 border-0 rounded-0" data-value="1" data-id="{{id}}">
            Delete
        </a>
        </div>
    </div>
 
</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>
<?php include '../includes/footer.html'; ?>
<script type="text/javascript">
    (function($) {

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

        Handlebars.registerHelper("url", function(options) {
            if (!this.id) return "";

            return '/real-estate-web-pages/' + string_to_slug(this.address) + "-property-" + this.id;
        });

        Handlebars.registerHelper("priceFormat", function(options) {
            if (!this.id) return "";

            return formatNumber(this.price);
        });

        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";

            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        };

        var formatNumber = function(number) {
            var splitNum;
            number = Math.abs(number);
            number = number.toFixed(2);
            splitNum = number.split('.');
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return splitNum.join(".");
        };

        $.PropertyListManager = function(options) {

            var that = this;
            var dataList = [];
            var listDataTable;

            var settings = $.extend({}, options);

            var getDataList = function() {

                $("#loading").show();

                if (listDataTable) {
                    listDataTable.destroy();
                    listDataTable = undefined;
                }

                $("#tblList tbody").empty();

                $.get('/api/app_properties/filter.php', {
                    is_deleted: 0,
                    logo: $("#ddlAgents").val(),
                    "_": $.now()
                }, function(response) {

                    dataList = JSON.parse(response);

                    for (let index = 0; index < dataList.length; index++) {
                        var element = dataList[index];
                        var source = document.getElementById("listItemTemplate").innerHTML;
                        var template = Handlebars.compile(source);
                        $("#tblList tbody").append(template(element));
                    }

                    $('#tblList').on('draw.dt', function() {

                        if (!listDataTable) return;

                        $("#tblList tbody tr").each(function() {

                            var row = listDataTable.row($(this));

                            var source = document.getElementById("itemActionTemplate").innerHTML;
                            var template = Handlebars.compile(source);

                            var id = $(this).attr('id');

                            if (id) {
                                var element = dataList.find(a => a.id == id);
                                row.child(template(element)).show();
                            }
                        });

                        $(".loading").hide();

                    });

                    listDataTable = $("#tblList").DataTable({
                        "columnDefs": [],
                        initComplete: function() {
                            this.api().columns().every(function() {});
                        },
                    });

                    listDataTable.draw();

                    initPlugins();
                });

            };

            var deleteProperty = function(id, isDeleted) {

                $.post('/api/app_properties/update_delete_status.php', {
                    is_deleted: isDeleted,
                    id: id
                }, function(response) {
                    var r = JSON.parse(response);

                    if (r.result == 1) {
                        toastr.success('Property has been deleted', 'Success');
                        getDataList();
                    } else {
                        toastr.error('Failed to complete the request', 'INFO!');
                    }
                });

            };

            var getAgents = function() {

                $.get('/api/app_agent_profiles/filter.php', {
                    is_deleted: 0,
                    "_": $.now()
                }, function(response) {
                    var data = JSON.parse(response);

                    $("#ddlAgents").html('<option value="">Filter Agent</option>');

                    for (let index = 0; index < data.length; index++) {
                        var element = data[index];

                        var opt = $("<option />", {
                            text: element.first_name + element.last_name,
                            value: element.id
                        });

                        $("#ddlAgents").append(opt);
                    }
                });

            };

            var initPlugins = function() {
                new $.CloneManager({
                    propertiesList: dataList
                })
            }

            var registerEvents = function() {

                $("div").on("click", ".link-delete", function(e) {
                    e.stopPropagation();

                    var status = $(this).attr('data-value');
                    var id = $(this).attr('data-id');

                    bootbox.confirm("Are you sure? You want to delete this property", function(r) {

                        if (r) {
                            deleteProperty(id, status);
                        }
                    });

                });

                $("div").on("change", "#ddlAgents", function(e) {
                    e.stopPropagation();
                    getDataList();
                });

            };

            var init = function() {
                registerEvents();
                getDataList();
                getAgents();
            };

            init();

        };

        $.CloneManager = function(options) {

            var settings = $.extend({
                propertiesList: []
            }, options);

            var initCloneForm = function() {

                var options = {
                    url: '/api/app_properties/create_clone_full.php',
                    beforeSubmit: function() {
                        var r = $("#fmClone #title").val();
                        if (!r) return r;

                        $("#cloneModal button").attr('disabled', true);
                        $("#cloneModal #progress").removeClass('d-none');
                        $("#cloneModal #progress span").html('Copying Basic..');

                    },
                    success: onCloneSuccess,
                    resetForm: true
                };

                $("#fmClone").ajaxForm(options);
            };

            var onCloneSuccess = function(response) {

                $("#cloneModal").modal('hide');

                var r = JSON.parse(response);

                if (r.result > 0) {
                    toastr.success('clone has been created');
                    window.location.reload();
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

                $("#cloneModal button").attr('disabled', false);
                $("#cloneModal #progress").addClass('d-none');
                $("#cloneModal #progress span").html('Copied');
            };
            var registerEvents = function() {

                $("div").on("click", ".link-clone", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    var property = settings.propertiesList.find(a => a.id == id);
                    $("#cloneModal input[name='id']").val(property.id);
                    $("#cloneModal input[name='title']").val(property.title);
                    $("#cloneModal input[name='address']").val(property.address + " copy");
                    $("#cloneModal").modal('show');
                });

                $("div").on("click", "#btnCreateClone", function(e) {
                    e.stopPropagation();
                    $("#fmClone").submit();
                });
            };

            var init = function() {
                registerEvents();
                initCloneForm();
            };

            init();

        };

    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.PropertyListManager({});
    });
</script>