<?php
$page_title = 'Statistics - Devices';
$page_name = 'dashboard';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <ul class="list-group">
                <a href="./" class="list-group-item list-group-item-action ">
                    Visitors
                </a>
                <a href="#" class="list-group-item list-group-item-action active">
                    Devices
                </a>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="row">
                <div class="col">
                    <div class="card p-1">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="" id="ddlOverlays" class="form-control form-control-sm">
                                    <option value="">Select Property</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group d1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary btn-sm px-3 py-0" type="button">
                                            <i class="fa fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="date1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group d2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary btn-sm px-3 py-0" type="button">
                                            <i class="fa fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="date2">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-info btn-sm btn-block" type="button" id="btnSearch">
                                    Search Statistics
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered" id="tblData">
                                <thead>
                                    <tr>
                                        <th>
                                            Device
                                        </th>
                                        <th>
                                            Views
                                        </th>
                                        <th>
                                            Unique Views
                                        </th>
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

</div>

<script type="text/x-handlebars-template" id='deviceRowItemTemplate'>
    <tr>
        <td>
            <img width="20" class="mr-2" src="https://stats.spacezz.ca/{{logo}}"> {{label}}
        </td>
        <td>
            {{nb_visits}}
        </td>
        <td>
            {{sum_daily_nb_uniq_visitors}}
        </td>
     </tr>
</script>
<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>
<?php include '../includes/footer.html'; ?>

<style>
    #chartdiv {
        width: 100%;
        height: 400px;
    }
</style>

<script type="text/javascript">
    (function($) {

        am4core.useTheme(am4themes_animated);

        var devicesDataTable;

        $.VisitorManager = function(options) {

            var that = this;

            var trackingCodesList = [];

            var settings = $.extend({}, options);

            var getTrackingCode = function(id) {

                $("#ddlOverlays").html('<option value="">Select Property</option>');

                $.get('/api/app_properties_analytics/filter.php', {}, function(response) {

                    var data = JSON.parse(response);

                    trackingCodesList = data;

                    for (let index = 0; index < data.length; index++) {
                        var element = data[index];
                        $("#ddlOverlays").append('<option value="' + element.tracking_id + '">' + element.address + '</option>');
                    }

                    $("select#ddlOverlays").prop('selectedIndex', 1);

                });

            };

            var getDevices = function() {

                var websiteId = $("#ddlOverlays").val();

                if (!websiteId) {
                    toastr.error('Please select the property');
                    return;
                }

                var date1 = $("#date1").val();

                if (!date1) {
                    toastr.error('Please select the date');
                    return;
                }

                var date2 = $("#date2").val();

                if (date2) {
                    date1 = date1 + "," + date2
                }

                $("#btnSearch").attr('disabled', true);

                var filterParams = {
                    'period': 'range',
                    'date': date1,
                    'format': 'JSON',
                    'idSite': websiteId,
                    'token_auth': '3836ce9fdafcf38fa9635acc974149bb'
                };

                var url = 'https://stats.365homes.net/index.php?module=API&method=DevicesDetection.getType';

                $.get(url, filterParams, function(response) {
                    drawTableData(response);
                    $("#btnSearch").attr('disabled', false);
                });
            };

            var drawTableData = function(chartData) {

                if (devicesDataTable) {
                    devicesDataTable.destroy();
                }

                $("#tblData tbody").empty();

                for (let index = 0; index < chartData.length; index++) {

                    const element = chartData[index];

                    console.log(element);

                    var source = document.getElementById("deviceRowItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    $("#tblData tbody").append(template(element));
                }

                devicesDataTable = $("#tblData").DataTable({
                    "order": [
                        [1, "desc"]
                    ]
                });
            }

            var registerEvents = function() {

                $("div").on("click", ".d1 button", function(e) {
                    e.stopPropagation();

                    $('#date1').data("DateTimePicker").show()

                });

                $("div").on("click", ".d2 button", function(e) {
                    e.stopPropagation();

                    $('#date2').data("DateTimePicker").show()

                });

                $("div").on("click", "#btnSearch", function(e) {
                    e.stopPropagation();

                    getDevices();

                });

                $('#date1').datetimepicker({
                    format: 'yyyy-MM-DD',
                    defaultDate: dateFrom = moment().subtract(3, 'd'),
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $('#date2').datetimepicker({
                    format: 'yyyy-MM-DD',
                    defaultDate: new Date(),
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

            };

            var init = function() {
                registerEvents();
                getTrackingCode();
            };

            init();

        };
    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.VisitorManager({});
    });
</script>