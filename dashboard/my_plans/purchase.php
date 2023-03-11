<?php
$page_title = 'New Plan';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="loading">
                <div class="spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row" id="productsList">
            </div>
        </div>

    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <div class="card shadow" id="cartPanel">
                <div class="card-header bg-secondary border-0">
                    <h6 class="m-0 font-weight-bold text-white">Your cart (0) </h6>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/x-handlebars-template" id='listItemTemplate'>

    <div class="col-md-3 col-sm-6">
    <div class="pricingTable">
        <div class="pricingTable-header {{color}}">
            <h3 class="heading"> {{plan_name}}</h3>
            <div class="price-value">{{price}}
                <span class="currency">$</span>
                <span class="month">/mo</span>
            </div>
            <span class="subtitle">Commitment-free</span>
        </div>
        <ul class="pricing-content">
            <li class="font-weight-bold"> {{credits}} web page per month</li>
            <li>Unlimited profiles</li>
            <li>Web page statistics</li>
            <li>Commitment-free, month-to-month</li>
            <li>You can cancel any time</li>
        </ul>
        <a href="javascript:;" class="read {{color}} link-purchase" data-id="{{id}}">Subscribe Now</a>
    </div>
</div>
</script>

<script type="text/x-handlebars-template" id='cartTemplate'>
    <ul class="list-group mb-3">
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">{{plan_name}} x1</h6>
        </div>
        <span class="text-muted">${{price}}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">Page limit</h6>

        </div>
        <span class="text-muted">{{credits}}/mo</span>
    </li>
   
    <li class="list-group-item d-flex justify-content-between">
        <span>Total (USD)</span>
        <strong>${{price}}</strong>
    </li>
    </ul>
    <ul class="list-group mb-3">

        <li class="list-group-item bg-light">
            <input type="checkbox" name="" id="chkTerms">
            <a href="/terms.php" target="_blank"> I agree to the terms and conditions</a>
        </li>
    </ul>
    <input type="hidden" id="hfPlanId" value="{{id}}">
    <div class="card-footer text-center">
    <div id="paypal-button-container" class="d-none"></div>
                                
        <button type="button" class="btn btn-success" id="btnSubmit">Submit Subscription</button>
        <button type="button" class="btn btn-danger" id="btnClearCart">Clear Cart</button>
    </div>

</script>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>


<style>
    .demo {
        padding: 50px 0;
    }

    .heading-title {
        margin-bottom: 50px;
    }

    .pricingTable {
        border: 2px solid #e3e3e3;
        text-align: center;
        position: relative;
        padding-bottom: 40px;
        transform: translateZ(0px);
    }

    .pricingTable:before,
    .pricingTable:after {
        content: "";
        position: absolute;
        top: -2px;
        left: -2px;
        bottom: -2px;
        right: -2px;
        z-index: -1;
        transition: all 0.5s ease 0s;
    }

    .pricingTable:before {
        border-right: 2px solid #ffd401;
        border-left: 2px solid #ffd401;
        transform: scaleY(0);
        transform-origin: 100% 0 0;
    }

    .pricingTable:after {
        border-bottom: 2px solid #ffd401;
        border-top: 2px solid #ffd401;
        transform: scaleX(0);
        transform-origin: 0 100% 0;
    }

    .pricingTable:hover:before {
        transform: scaleY(1);
    }

    .pricingTable:hover:after {
        transform: scaleX(1);
    }

    .pricingTable .pricingTable-header {
        background: #ffd401;
        color: #fff;
        margin: -2px -2px 35px;
        padding: 40px 0;
    }

    .pricingTable .heading {
        font-size: 30px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }

    .pricingTable .subtitle {
        font-size: 14px;
        display: block;
    }

    .pricingTable .price-value {
        font-size: 50px;
        font-weight: 600;
        margin-top: 10px;
        position: relative;
        display: inline-block;
    }

    .pricingTable .currency {
        font-size: 45px;
        font-weight: normal;
        position: absolute;
        top: 2px;
        left: -30px;
    }

    .pricingTable .month {
        font-size: 20px;
        position: absolute;
        bottom: 17px;
        right: -40px;
    }

    .pricingTable .pricing-content {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .pricingTable .pricing-content li {
        font-size: 16px;
        color: #7a7e82;
        line-height: 40px;
    }

    .pricingTable .read {
        display: inline-block;
        border: 2px solid #7a7e82;
        font-size: 14px;
        font-weight: 700;
        color: #7a7e82;
        padding: 9px 30px;
        position: relative;
        text-transform: uppercase;
        transition: all 0.3s ease 0s;
    }


    .pricingTable .read:before,
    .pricingTable .read:after {
        content: "";
        display: block;
        height: 30px;
        position: absolute;
        right: -11px;
        transition: all 0.3s ease 0s;
    }

    .pricingTable .read:hover:before,
    .pricingTable .read:hover:after {
        border-left-color: #ffd401;
    }

    .read.pink {
        background-color: #e46367;
        border: 2px solid #e46367;
        color: #fff;
    }

    .read.yellow {
        background-color: #ffd401;
        border: 2px solid #ffd401;
        color: #fff;
    }

    .read.green {
        background-color: #35C296;
        border: 2px solid #35C296;
        color: #fff;
    }

    .read.purple {
        background-color: #654CAF;
        border: 2px solid #654CAF;
        color: #fff;
    }

    .pricingTable .pricingTable-header.purple {
        background-color: #654CAF;
    }

    .pricingTable .pricingTable-header.green {
        background-color: #35C296;
    }


    .pricingTable .pricingTable-header.pink {
        background-color: #e46367;
    }

    @media screen and (max-width: 990px) {
        .pricingTable {
            margin-bottom: 25px;
        }
    }
</style>

<script>
    (function($) {

        $.PlansManager = function(options) {

            var that = this;

            var productsList = [];
            var colors = ['yellow', 'purple', 'green', 'pink'];

            var myCurrentPlan;

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

                $("#productsList").empty();

                for (let index = 0; index < productsList.length; index++) {

                    var item = productsList[index];

                    if (item.is_deleted == 1) continue;

                    item.color = colors[index];

                    var source = document.getElementById("listItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    $("#productsList").append(template(item));

                }

                $(".loading").hide();

            };

            var getMyPlans = function() {

                $.get('/api/app_user_plans/get_my_plans.php', {
                    is_cancelled: 0
                }, function(response) {
                    var parsedData = JSON.parse(response);

                    if (parsedData.length > 0) {}
                    myCurrentPlan = parsedData[0];

                    getList();
                });

            };


            var setPaypal = function(price) {

                paypal.Buttons({
                    funding: {
                        disallowed: [paypal.FUNDING.CREDIT]
                    },
                    style: {
                        label: 'checkout',
                    },
                    createOrder: function(data, actions) {

                        if (price <= 0) return false;

                        // This function sets up the details of the transaction, including the amount and line item details.
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: price
                                },
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        // This function captures the funds from the transaction.
                        return actions.order.capture().then(function(details) {
                            if (data.orderID) {
                                var payment = {
                                    order_id: data.orderID,
                                    amount_total: price,
                                    amount_paid: price,
                                    details: details,
                                    data: data
                                };

                                savePlan(payment);
                            }
                        });
                    }
                }).render('#paypal-button-container');


            };

            var savePlan = function(payment) {

                var userData = {
                    plan_id: $("#hfPlanId").val()
                };

                var paymentData = JSON.stringify(payment);

                var params = {
                    user: userData,
                    payment: paymentData,
                };

                $.post('/api/app_user_plans/place_user_plan.php', params, function(response) {
                    var r = JSON.parse(response);

                    if (r.id > 0) {
                        toastr.success('our have purchased the plan successfully. Thank You!');
                        window.location.href = '/dashboard/property';
                    } else {
                        toastr.error('Sorry we are unable to completed the order.');
                    }

                });
            };

            var registerEvents = function() {

                $("div").on("click", ".link-purchase", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');

                    if (id && myCurrentPlan && myCurrentPlan.plan_id == id) {
                        toastr.warning('You are currently subscribed to this plan.');
                        return;
                    }

                    var source = document.getElementById("cartTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    var item = productsList.find(a => a.id == id);

                    $("#cartPanel .card-body").html(template(item));
                    $("#cartPanel .card-header h6").html('Your cart (1)');

                    setPaypal(item.price);

                    $('html, body').animate({
                        scrollTop: $("#cartPanel").offset().top
                    }, 100);

                });

                $("div").on("click", "#btnClearCart", function(e) {
                    e.stopPropagation();

                    $("#cartPanel .card-body").empty();
                    $("#cartPanel .card-header h6").html('You Cart (0)');

                    $('html, body').animate({
                        scrollTop: $("#productsList").offset().top - 1000
                    }, 100);

                });

                $("div").on("click", "#btnSubmit", function(e) {
                    e.stopPropagation();

                    var checked = $("#chkTerms").is(":checked");

                    if (!checked) {
                        toastr.error('Please agree to the terms and conditions to proceed.')
                    }
                });

                $("div").on("change", "#chkTerms", function(e) {
                    e.stopPropagation();

                    var checked = $("#chkTerms").is(":checked");

                    if (checked) {
                        $("#btnSubmit").hide();
                        $("#paypal-button-container").removeClass('d-none');
                    } else {
                        $("#btnSubmit").show();
                        $("#paypal-button-container").addClass('d-none');
                    }

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

                toastr.options.positionClass = 'toast-bottom-right';
            };

            var init = function() {

                registerEvents();

                getMyPlans();
            };

            init();

        };

    }(jQuery));

    $(document).ready(function() {
        var pm = new $.PlansManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>