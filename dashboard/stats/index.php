<?php
$page_title = 'Statistics - Visitors';
$page_name = 'dashboard';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <ul class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    Visitors
                </a>
                <a href="./devices.php" class="list-group-item list-group-item-action">
                    Devices
                </a>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="row">
                <div class="col">
                    <div class="card p-1">
                        <div class="row mt-1">
                            <div class="col-lg-4 col-md-6 mb-1">
                                <select name="" id="ddlOverlays" class="form-control form-control-sm">
                                    <option value="">Select Property</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-1">
                                <div class="input-group d1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary btn-sm px-3 py-0" type="button">
                                            <i class="fa fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="date1">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-1">
                                <div class="input-group d2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary btn-sm px-3 py-0" type="button">
                                            <i class="fa fa-calendar-alt"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="date2">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3">
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


                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="bg-white p-2">
                                <div id="chartdiv">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="bg-white p-2">
                                <table class="table table-bordered" id="tblData">
                                    <thead>
                                        <tr>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Views
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs small border-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Time Line Graph</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">View Data</a>
                        </li>

                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>
<?php include '../includes/footer.html'; ?>

<style>
    #chartdiv {
        width: 100%;
        height: 400px;
    }

    .nav-tabs .nav-link {
        border-radius: 0;
    }

    .nav-tabs .nav-link.active {
        color: #ffffff;
        background-color: #474747;
        border-color: #474747;
    }
</style>

<script type="text/javascript">
    (function($) {

        am4core.useTheme(am4themes_animated);

        var chart;

        $.VisitorManager = function(options) {

            var that = this;

            var trackingCodesList = [];
            var userDataTable;

            var settings = $.extend({}, options);

            var getTrackingCode = function(id) {

                $("#ddlOverlays").html('<option value="">Select Property</option>');

                $.get('/api/app_properties_analytics/filter.php', {}, function(response) {

                    var data = JSON.parse(response);

                    trackingCodesList = data;

                    for (let index = 0; index < data.length; index++) {
                        var element = data[index];
                        $("#ddlOverlays").append('<option overlay="'+element.property_id+'" value="' + element.tracking_id + '">' + element.address + '</option>');
                    }

                    var overlayIdParm = getParameterByName('overlay');

                    if (overlayIdParm) {
                        $("select#ddlOverlays option[overlay='"+overlayIdParm+"']").prop('selected', true);
                    } else {
                        $("select#ddlOverlays").prop('selectedIndex', 1);
                    }

                    if ($("select#ddlOverlays option").length > 1) {
                        $("#btnSearch").trigger('click');
                    }

                });

            };

            var getVisits = function() {

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

                $("#chartdiv").prepend('<div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div>');

                var filterParams = {
                    'period': 'day',
                    'date': date1,
                    'format': 'JSON',
                    'idSite': websiteId,
                    'token_auth': '3836ce9fdafcf38fa9635acc974149bb'
                };

                var url = 'https://stats.365homes.net/index.php?module=API&method=Actions.get';

                var chartData = [];

                $.get(url, filterParams, function(response) {

                    for (var item in response) {
                        if (item) {
                            var viewsCount = response[item]['nb_pageviews'];
                            viewsCount = !viewsCount ? 0 : viewsCount;
                            chartData.push({
                                "date": item,
                                "value": viewsCount
                            });
                        }
                    }

                    drawChart(chartData);
                    drawTableData(chartData);

                    $("#btnSearch").attr('disabled', false);
                    $("#chartdiv .spinner-border").remove();
                });
            };

            var drawChart = function(chartData) {

                disposeAllChart();

                // Create chart instance
                chart = am4core.create("chartdiv", am4charts.XYChart);

                console.log(chartData)
                
                // Add data
                chart.data = chartData;

                // Set input format for the dates
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                valueAxis.min = -0.5;
                
                // Create series
                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "value";
                series.dataFields.dateX = "date";
                series.tooltipText = "{value}"
                series.strokeWidth = 2;
                series.minBulletDistance = 15;

                // Drop-shaped tooltips
                series.tooltip.background.cornerRadius = 20;
                series.tooltip.background.strokeOpacity = 0;
                series.tooltip.pointerOrientation = "vertical";
                series.tooltip.label.minWidth = 40;
                series.tooltip.label.minHeight = 40;
                series.tooltip.label.textAlign = "middle";
                series.tooltip.label.textValign = "middle";
                series.showTooltipOn = "always";

                // Make bullets grow on hover
                var bullet = series.bullets.push(new am4charts.CircleBullet());
                bullet.circle.strokeWidth = 2;
                bullet.circle.radius = 4;
                bullet.circle.fill = am4core.color("#fff");

                var bullethover = bullet.states.create("hover");
                bullethover.properties.scale = 1.3;

                // Make a panning cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.behavior = "panXY";
                chart.cursor.xAxis = dateAxis;
                chart.cursor.snapToSeries = series;

                // Create vertical scrollbar and place it before the value axis
                // chart.scrollbarY = new am4core.Scrollbar();
                // chart.scrollbarY.parent = chart.leftAxesContainer;
                // chart.scrollbarY.toBack();

                // Create a horizontal scrollbar with previe and place it underneath the date axis
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series);
                chart.scrollbarX.parent = chart.bottomAxesContainer;

                dateAxis.start = 0.1;
                dateAxis.keepSelection = true;

            };

            var drawTableData = function(chartData) {
                $("#tblData tbody").empty();

                for (let index = 0; index < chartData.length; index++) {
                    const element = chartData[index];
                    var date = moment(element.date).format('MMMM Do YYYY');
                    $("#tblData tbody").append('<tr><td>' + date + '</td><td>' + element.value + '</td></tr>');
                }
            }

            var disposeAllChart = function() {

                var charts = am4core.registry.baseSprites;

                while (charts.length > 0) {

                    try {
                        charts[0].dispose();
                    } catch (e) {
                        console.log('ERROR', e);
                    }
                }

                try {
                    if (chart) {
                        chart.dispose();
                    }
                } catch (e) {
                    console.log('ERROR', e);

                }

                delete chart;
            }

            var getParameterByName = function(name, url = window.location.href) {
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            };

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

                    getVisits();

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