<?php
$page_title = 'My Plans';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">My Plans</h6>
                    <div>
                        <a href="./purchase.php" class="btn btn-sm btn-yellow link-add-new text-dark font-weight-bold">
                            <i class="fa fas fa-plus"></i> Click here to subscribe
                        </a>
                    </div>
                </div>
                <div class="card-body h-100">
                    <div class="loading">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div id="dataList"></div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    <div class="accordion mb-3 d-none">
        <div class="card">
            <div class="card-header bg-white" id="heading{{id}}">
                <div class="row">
                    <div class="col">
                        <a class="text-dark" type="button" data-toggle="collapse" data-target="#collapse{{id}}" aria-expanded="true" aria-controls="collapse{{id}}">
                            <strong> {{plan_name}} (${{price}}) </strong>
                           <small> Click to view details</small>
                        </a>
                       
                    </div>
                    <div class="col text-right">
                        <a href="javascript:;" class="btn btn-danger btn-sm link-cancel" data-id="{{id}}">
                            Cancel my subscription</a>
                    </div>
                </div>
            </div>

            <div id="collapse{{id}}" class="collapse" aria-labelledby="heading{{id}}">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Credits</th>
                                <th>Price</th>
                                <th>Purchased Date</th>
                                <th>Started Date</th>
                                <th>Expired Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{credits}}</td>
                                <td>
                                    ${{price}}
                                </td>
                                <td>
                                {{#dateOnly}} {{created_on}} {{/dateOnly}}
                                </td>
                                <td>
                                {{#dateOnly}} {{started_on}} {{/dateOnly}}
                                </td>
                                <td>
                                {{#dateOnly}} {{end_on}} {{/dateOnly}}
                                </td>
                                <td>
                                    <a href="javascript:;" data-id="{{id}}" class="btn btn-primary btn-sm link-payment">Payment Details</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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

<script type="text/x-handlebars-template" id='noPlanTemplate'>
    <div class="card bg-light text-black shadow">
        <div class="card-body">
            You are not currently subscribed to any plan. Subscribing will allow you to begin adding property pages.
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

        $.MyPlansManager = function(options) {

            var that = this;

            var dataList = [];
            var listDataTable;

            var settings = $.extend({}, options);

            var getDataList = function() {

                $(".loading").show();

                $("#dataList").empty();

                $.get('/api/app_user_plans/get_my_plans.php', {
                    is_cancelled:0
                }, function(response) {

                    dataList = JSON.parse(response);

                    for (let index = 0; index < dataList.length; index++) {
                        var element = dataList[index];

                        var source = document.getElementById("listItemTemplate").innerHTML;
                        var template = Handlebars.compile(source);
                        $("#dataList").append(template(element));
                    }

                    if (dataList.length <= 0) {
                        var source = document.getElementById("noPlanTemplate").innerHTML;
                        var template = Handlebars.compile(source);
                        $("#dataList").html(template(element));


                    } else {
                        $(".link-add-new").html('<i class="fa fas fa-plus"></i> Upgrade your subscription');
                    }

                    $("#dataList .accordion").eq(0).removeClass('d-none');
                    $(".loading").hide();

                });

            };

            var getPayment = function(id) {

                $.get('/api/app_user_plan_payments/filter_agent.php', {
                    user_plan_id: id
                }, function(response) {

                    var parsed = JSON.parse(response);

                    if (parsed.length > 0) {
                        var element = parsed[0];
                        var source = document.getElementById("paymentDetailTemplate").innerHTML;
                        var template = Handlebars.compile(source);
                        $("#paymentModal .modal-body").html(template(element));
                    } else {
                        $("#paymentModal .modal-body").html('No details found');
                    }

                    $("#paymentModal").modal('show');
                });

            };

            var registerEvents = function() {

                $("div").on("click", ".link-payment", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');
                    getPayment(id);
                });

                $("div").on("click", ".link-cancel", function(e) {
                    e.stopPropagation();
                    var id = $(this).attr('data-id');

                    bootbox.confirm("Are you sure you want to cancel your subscription? This action cannot be undone.", function(result) {
                        if (result) {
                            $.post('/api/app_user_plans/update_cancel_status.php', {
                                is_cancelled: 1,
                                id: id
                            }, function(response) {
                                var r = JSON.parse(response);

                                if (r.result == 1) {
                                    toastr.success('Subscription has been cancelled.', 'Success');
                                    getDataList();
                                } else {
                                    toastr.error('Failed to complete the request', 'INFO!');
                                }
                            });
                        }
                    });

                });

            };

            var init = function() {
                registerEvents();
                getDataList();
            };

            init();

        };


    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.MyPlansManager({});
    });
</script>