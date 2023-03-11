<?php
$page_title = 'Virtual Tour - Tracking Manager';
$page_name = 'dashboard';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <button id="btnCreateNew" class="btn btn-info" type="button">Create New</button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="tblTrackings">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Property
                                </th>
                                <th>Type</th>
                                <th>
                                    Tracking #
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


<div id="createModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a New Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <select class="form-control form-control-sm" id="ddlType">
                        <option value="">Select Type</option>
                        <option value="internal">Internal</option>
                        <option value="external">External</option>
                    </select>
                </div>

                <form id="fmTracking" method="post">

                    <select class="form-control form-control-sm" id="property_id">
                        <option value="">Select Property</option>
                    </select>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCreate">Create</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='trackingItemTemplate'>
    <tr id="{{id}}">
        <td> {{property_id}} </td>
        <td> {{address}} </td>
        <td> {{tracking_type}} </td>
        <td> {{tracking_id}} </td>
    </tr>
</script>


<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>
<?php include '../includes/footer.html'; ?>


<script type="text/javascript">
    (function($) {

        $.TrackingManager = function(options) {

            var that = this;

            var trackingCodesList = [];
            var dataList = [];

            var userDataTable;

            var settings = $.extend({}, options);

            var getTrackings = function(id) {

                if (userDataTable) {
                    userDataTable.destroy();
                }

                $("#tblTrackings tbody").empty();

                $.get('/api/app_properties_analytics/filter.php', {}, function(response) {

                    trackingCodesList = JSON.parse(response);

                    for (let index = 0; index < trackingCodesList.length; index++) {
                        var element = trackingCodesList[index];

                        var source = document.getElementById("trackingItemTemplate").innerHTML;
                        var template = Handlebars.compile(source);

                        $("#tblTrackings tbody").append(template(element));

                    }

                    userDataTable = $("#tblTrackings").DataTable({});

                    userDataTable.order([
                        [0, 'desc']
                    ]).draw();

                });

            };

            var getProperties = function(id) {

                $.get('/api/app_properties/filter.php', {
                    is_deleted: 0
                }, function(response) {
                    dataList = JSON.parse(response);
                });

            };

            var toggleForm = function(type_val) {

                $("#fmTracking").hide();

                $("#property_id").html('<option value="">Select Property</option>');

                if (type_val == 'internal') {

                    var addedCount = 0;

                    for (let index = 0; index < dataList.length; index++) {

                        var element = dataList[index];

                        var toursCount = trackingCodesList.filter(a => a.tracking_type == 'matomo' && a.property_id == element.id).length;

                        if (toursCount <= 0) {
                            addedCount++;
                            $("#property_id").append('<option value="' + element.id + '">' + element.address + '</option>');
                        }
                    }

                    if (addedCount <= 0) {
                        $("#property_id").html('<option value="">No Property Pending</option>');
                    }

                    $("#fmTracking").show();

                } else if (type_val == 'external') {

                    for (let index = 0; index < overlaysList.length; index++) {

                        var element = overlaysList[index];

                        $("#property_id").append('<option value="' + element.id + '">' + element.title + '</option>');
                    }

                    $("#fmTracking").show();
                }

            };

            var addMatomoSite = function() {

                var propertyId = $("#property_id").val();
                var title = $("#property_id option:selected").text();

                if (!propertyId) return;

                $("#createModal input").attr('disabled', true);
                $("#createModal button").attr('disabled', true);

                var apiURL = 'https://stats.365homes.net/index.php?module=API&method=SitesManager.addSite';

                var params = {
                    siteName: title + " - " + propertyId,
                    urls: 'https://365homes.net',
                    timezone: 'America/Toronto',
                    currency: 'CAD',
                    startDate: 'today',
                    type: 'website',
                    siteSearch: '1',
                    token_auth: '3836ce9fdafcf38fa9635acc974149bb'
                };

                // apiURL = 'http://localhost:9094/index.php?module=API&method=SitesManager.addSite';

                // var params = {
                //     siteName: title + " - " + propertyId,
                //     urls: 'http://localhost:9099/',
                //     timezone: 'America/Toronto',
                //     currency: 'CAD',
                //     startDate: 'today',
                //     type: 'website',
                //     siteSearch: '1',
                //     token_auth: '2c642b66eeff97d1b02b3c1e61ec9d5b'
                // }

                $.post(apiURL, params, function(response) {

                    var siteID = parseInt($(response).text());

                    var dataParams = {
                        property_id: propertyId,
                        tracking_id: siteID,
                        tracking_type: 'matomo',
                    };

                    insertTrackingSite(dataParams);

                    $("#createModal input").attr('disabled', false);
                    $("#createModal button").attr('disabled', false);

                });

            };

            var insertTrackingSite = function(params) {
                $.post('/api/app_properties_analytics/save.php', params, function(response) {
                    $("#createModal").modal('hide');
                    var parsed = JSON.parse(response);
                    alert(parsed.result);
                    window.location.reload();
                });
            };

            var registerEvents = function() {

                $("div").on("click", "#btnCreateNew", function(e) {
                    e.stopPropagation();

                    $('#createModal').modal('show');

                });

                $("div").on("change", "#ddlType", function(e) {
                    e.stopPropagation();

                    var val = $(this).val();

                    toggleForm(val);

                });

                $("div").on("click", "#btnCreate", function(e) {
                    e.stopPropagation();

                    var type = $("#ddlType").val();

                    if (type == 'internal') {
                        addMatomoSite();
                    }

                });

                $('#createModal').on('hidden.bs.modal', function(e) {
                    $("#ddlType").val(null);

                });


            };

            var init = function() {
                registerEvents();
                getTrackings();
                getProperties();
            };

            init();

        };


    }(jQuery));
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var ins = new $.TrackingManager({});
    });
</script>