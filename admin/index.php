<?php
$page_title = 'Admin';
include 'includes/header.php';
?>

<?php include './includes/pre_footer.html'; ?>
<?php include './includes/scripts.html'; ?>


<script type="text/javascript">
  (function($) {

    $.StatsManager = function(options) {

      var that = this;

      var trackingCodesList;

      var settings = $.extend({
        overlayList: []
      }, options);

      var getTrackingCode = function(id) {

        $("#statsPanel").html('<span id="load">Loading ..</span>');

        $.get('/api/app_overlays_analytics/filter.php', {}, function(response) {

          var data = JSON.parse(response);

          trackingCodesList = data;

          var maxLength = data.length >= 5 ? 5 : data.length;

          for (let index = 0; index < maxLength; index++) {

            var element = data[index];

            var source = document.getElementById("statOverlayWidgetItemTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#statsPanel").append(template(element));

          }

          $("#statsPanel #load").remove();

          getWidgets();

        });

      };

      var getWidgets = function() {

        $(".overlay-stat-widget").each(function() {

          var trackingId = $(this).attr('tracking_id');

          getLiveWidget(this, trackingId);
          getTotalViewsWidget(this, trackingId);

        });
      };

      var getLiveWidget = function(thisPanel, trackingId) {

        var url = 'https://stats.spacezz.ca/index.php?module=API&method=Live.getCounters&idSite=' + trackingId + '&lastMinutes=30&format=JSON&token_auth=&force_api_session=1';

        $.get(url, {}, function(response) {
          var item = response[0];

          var source = document.getElementById("liveVisitorWidgetTemplate").innerHTML;
          var template = Handlebars.compile(source);

          $(thisPanel).find("#liveWidget").html(template(item));
        });

      };

      var getTotalViewsWidget = function(thisPanel, trackingId) {

        var url = 'https://stats.spacezz.ca/index.php?module=API&method=Actions.get&idSite=' + trackingId + '&period=year&date=2021&format=JSON&token_auth=&force_api_session=1';

        $.get(url, {}, function(response) {
          var item = response;

          var source = document.getElementById("totalViewsWidgetTemplate").innerHTML;
          var template = Handlebars.compile(source);

          $(thisPanel).find("#totalViewsWidget").html(template(item));

        });


      };

      var registerEvents = function() {};

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
    var ins = new $.StatsManager({});
  });
</script>

<?php include './includes/footer.html'; ?>