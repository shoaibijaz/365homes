<?php
$page_title = 'Messages';
include '../includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">Messages</h6>
                    <div class="text-right">
                        <a href="/dashboard/property/messages.php" class="btn btn-primary btn-sm">Show All</a>
                    </div>
                </div>
                <div class="card-body h-100">

                    <div class="loading">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="row" id="filters">

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tblList" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Property</th>
                                    <th>Message</th>
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
<script type="text/x-handlebars-template" id='listItemTemplate'>
    <tr id="{{id}}">
      
        <td class="small">
            {{full_name}}
        </td>

        <td class="small"> 
          {{email}}
        </td>
        
        <td class="small">
           {{property_name}}
        </td>

        <td class="small">
           <div>
            {{{trimMessage message}}}
           </div>

         
        </td>

        <td class="small"  data-sort="{{id}}">
        {{#dateOnly}} {{created_on}}{{/dateOnly}}
        </td>

        
    </tr>
</script>

<script type="text/x-handlebars-template" id='itemActionTemplate'>

    <div class="row">
       
    <div class="col text-right">
        <a href="#" class="btn btn-info btn-sm link-view mb-1 border-0 rounded-0" data-value="1" data-id="{{id}}">
            View Details
        </a>

        <a href="#" class="btn btn-danger btn-sm link-delete mb-1 border-0 rounded-0" data-value="1" data-id="{{id}}">
            Delete
        </a>
        </div>
    </div>
 
</script>

<script type="text/x-handlebars-template" id='detailTemplate'>
    <table class="table table-bordered">
   <tr id="{{id}}">
      
      <td>Full Name</td>
      <td >
          {{full_name}}
      </td>
    </tr>

    <tr id="{{id}}">
      
      <td>Phone</td>
      <td>
          {{phone}}
      </td>
    </tr>

    <tr>
      <td>Email</td>

      <td> 
        {{email}}
      </td>
      </tr>
      
      <tr>
      <td>Property</td>

      <td> 
        {{property_name}}
      </td>
      </tr>

      <tr>

      <td colspan="2">
         <div>
          {{{message}}}
         </div>
      </td>

      
  </tr>
   </table>
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

        Handlebars.registerHelper('trimMessage', function(passedString) {

            var theString = passedString;

            if (passedString.length > 100) {
                theString = passedString.substring(0, 100) + '..';
            }

            return new Handlebars.SafeString(theString)
        });

        $.PropertyListManager = function(options) {

            var that = this;

            var dataList = [];
            var listDataTable;

            var settings = $.extend({}, options);

            var getDataList = function() {

                var propertyId = getQS('property');

                if (!propertyId) {
                    propertyId = undefined;
                }

                $("#loading").show();

                if (listDataTable) {
                    listDataTable.destroy();
                }

                $("#tblList tbody").empty();

                $.get('/api/app_property_ask/get_messages.php', {
                    is_deleted: 0,
                    property_id: propertyId,
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

                            var element = dataList.find(a => a.id == $(this).attr('id'));

                            row.child(template(element)).show();

                        });

                        $(".loading").hide();

                    });

                    listDataTable = $("#tblList").DataTable({
                        "columnDefs": [],
                        initComplete: function() {
                            this.api().columns().every(function() {});
                        },
                    });

                    listDataTable.order([4, 'desc']).draw();

                });

            };

            var deleteMessage = function(id, isDeleted) {

                $.post('/api/app_property_ask/update_delete_status.php', {
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

            var registerEvents = function() {

                $("div").on("click", ".link-view", function(e) {
                    e.stopPropagation();

                    var id = $(this).attr('data-id');

                    var element = dataList.find(a => a.id == id);

                    var source = document.getElementById("detailTemplate").innerHTML;
                    var template = Handlebars.compile(source);

                    bootbox.alert({
                        title: moment($.trim(element.created_on)).format('DD-MMM-YYYY'),
                        message: template(element)
                    });

                });

                $("div").on("click", ".link-delete", function(e) {
                    e.stopPropagation();

                    var status = $(this).attr('data-value');
                    var id = $(this).attr('data-id');

                    bootbox.confirm("Are you sure? You want to delete this message", function(r) {

                        if (r) {
                            deleteMessage(id, status);
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
        var ins = new $.PropertyListManager({});
    });
</script>