<?php
$page_title = 'Agent Plans';

include '../includes/header.php';
?>

<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark">Agent Purchased Plans</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="productsList">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent</th>
                                <th>Plan</th>
                                <th>Credit</th>
                                <th>Months</th>
                                <th>Price</th>
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
</div> <!-- end container -->

<div id="paymentModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='listItemTemplate'>
    <tr id='{{id}}'>
    <td>{{counter}}</td>
    <td>{{login_name}}</td>
    <td>{{plan_name}}</td>
    <td>{{credits}}</td>
    <td>{{months}}/mon</td>
    <td>{{price}} CAD</td>
    <td>{{#dateOnly}} {{created_on}} {{/dateOnly}}</td>
    <td><span class="badge badge-primary">{{status_name}} </span></td>
    </tr>
</script>

<script type="text/x-handlebars-template" id='itemActionTemplate'>

    <div class="row">
       <div class="col">
       <a href="/property.php?id={{id}}" target="_blank" class="btn btn-dark btn-sm mb-1 border-0 rounded-0">View</a>
       </div>
    <div class="col text-right">
        
        <a href="javascript:;" class="btn btn-info btn-sm mb-1 border-0 rounded-0 link-payment" data-id="{{id}}">
            View Payment
        </a>

        {{#ifCond status_id '==' 1}}

        <a href="javascript:;" class="btn btn-success btn-sm mb-1 border-0 rounded-0 link-approve" data-id="{{id}}">
            Approve
        </a>

        <a href="./manager.php?id={{id}}"  class="btn btn-danger btn-sm mb-1 border-0 rounded-0 link-reject" data-id="{{id}}">
            Reject
        </a>

        {{/ifCond}}

        {{#ifCond status_id '==' 2}}
        
            <a href="javascript:;" class="btn btn-success btn-sm mb-1 border-0 rounded-0 link-approve" data-id="{{id}}">
            Approve</a>
            
            <a href="./manager.php?id={{id}}"  class="btn btn-danger btn-sm mb-1 border-0 rounded-0 link-reject" data-id="{{id}}">
            Reject</a>

        {{/ifCond}}

       
        </div>
    </div>
 
</script>

<script type="text/x-handlebars-template" id='paymentDetailTemplate'>
    <table class="table table-bordered">
        <tr><td><strong>Paid Amount:</strong></td><td>${{amount_paid}}</td></tr>
        <tr><td><strong>Date:</strong></td><td>{{#dateOnly}} {{created_on}} {{/dateOnly}}</td></tr>
        <tr><td><strong>Order ID:</strong></td><td>{{order_id}}</td></tr>
    </table>
</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>

<script>
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

                $.get('/api/app_user_plans/filter.php', params, function(response) {
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

                    $("#productsList tbody tr").each(function() {

                        var row = productsDataTable.row($(this));

                        var source = document.getElementById("itemActionTemplate").innerHTML;
                        var template = Handlebars.compile(source);

                        var element = productsList.find(a => a.id == $(this).attr('id'));

                        row.child(template(element)).show();

                    });

                    $(".loading").hide();

                });

                productsDataTable = $("#productsList").DataTable({
                    "columnDefs": [{
                        'width': '10px',
                        'targets': 0
                    }],
                    initComplete: function() {
                        this.api().columns().every(function() {});
                    },
                });

                productsDataTable.draw();

            };

            var getPayment = function(id) {

                $.get('/api/app_user_plan_payments/filter.php', {
                    user_plan_id: id
                }, function(response) {

                    var parsed = JSON.parse(response);

                    if (parsed.length > 0) {
                        var element = parsed[0];
                        console.log(JSON.parse(element.details))
                        console.log(JSON.parse(element.data))
                        var source = document.getElementById("paymentDetailTemplate").innerHTML;
                        var template = Handlebars.compile(source);
                        $("#paymentModal .modal-body").html(template(element));
                    } else {
                        $("#paymentModal .modal-body").html('No details found');
                    }

                    $("#paymentModal").modal('show');
                });

            };

            var approveStatus = function(id) {

                var params = {
                    id: id
                };

                $.post('/api/app_user_plans/approve_status.php', params, function(response) {
                    var r = JSON.parse(response);

                    if (r.result > 0) {
                        toastr.success('Package plan has been approved', 'danger');
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

                $("div").on("click", ".link-payment", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');
                    getPayment(id);

                });

                $("div").on("click", ".link-approve", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    if (!id) return;

                    bootbox.confirm("Are you sure! You want to approve this plan?", function(result) {

                        if (result) {
                            approveStatus(id);
                        }
                    });

                });

                $("div").on("click", ".link-details", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    if (!id) return;

                    viewDetails(id);

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