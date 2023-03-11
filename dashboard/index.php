<?php
$page_title = 'Agent Dashboard';
include 'includes/header.php';
?>


<div class="container-fluid">
  <div class="row mb-3">
    <div class="col-md-4">
      <a href="./property/manager.php" class="btn btn-pink btn-block">
        <i class="fa fas fa-plus"></i>
        Add New Property</a>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-4 mb-3">

      <div class="card bg-primary text-white shadow-lg custom border-0">
        <a href="/dashboard/property/">
          <div class="card-body text-center">
            <span>Properties</span>

            <div class="info" data-count='property'>0</div>
          </div>
        </a>
      </div>

    </div>

    <div class="col-md-4 mb-3">

      <div class="card bg-success text-white shadow-lg custom border-0">
        <a href="/dashboard/agents/profiles.php">
          <div class="card-body text-center">
            <span>Profiles</span>

            <div class="info" data-count='profiles'>0</div>
          </div>
        </a>
      </div>

    </div>

    <div class="col-md-4 mb-3">

      <div class="card bg-info text-white shadow-lg custom border-0">
        <a href="/dashboard/my_plans/">
          <div class="card-body text-center">
            <span>Plans</span>
            <div class="info" data-count='credits'>0</div>
          </div>
        </a>
      </div>

    </div>

    <div class="col-md-4 mb-3">

      <div class="card bg-dark text-white shadow-lg custom border-0">
        <a href="/dashboard/stats/">
          <div class="card-body text-center">
            <span>Statistics</span>
          </div>
        </a>
      </div>

    </div>

    <div class="col-md-4 mb-3">

      <div class="card bg-warning text-white shadow-lg custom border-0">
        <a href="/dashboard/property/messages.php">
          <div class="card-body text-center">
            <span>Messages</span>
          </div>
        </a>
      </div>

    </div>

  </div>

  
</div>

<?php include './includes/pre_footer.html'; ?>
<?php include './includes/scripts.html'; ?>

<style>
  .card.custom {
    min-height: 100px;
    line-height: 66px;

  }

  .card.custom a {
    color: #fff;
    font-size: 23px;
  }

  .card.custom a:hover {
    text-decoration: none;
  }

  .card.custom:hover {
    opacity: 0.9;
  }

  .info {
    position: absolute;
    top: 10px;
    left: 0px;
    background: #335dd7;
    height: 34px;
    width: 47px;
    line-height: 34px;
    font-size: 15px;
  }

  .bg-success .info {
    background-color: #32ac63;
  }

  .bg-info .info {
    background-color: #1096b0;
  }
</style>

<script type="text/javascript">
  (function($) {

    $.HomeManager = function(options) {

      var that = this;

      var settings = $.extend({}, options);

      var getPropertyCount = function(id) {

        $.get('/api/app_properties/get_my_count.php', {}, function(response) {

          var data = JSON.parse(response);

          $("div[data-count='property']").html(data.count);

        });

      };

      var getCredits = function(id) {

        $.get('/api/app_users/get_my_credits.php', {}, function(response) {

          var data = JSON.parse(response);

          $("div[data-count='credits']").html(response);

        });

      };

      var getProfiles = function(id) {

        $.get('/api/app_agent_profiles/count.php', {}, function(response) {

          var data = JSON.parse(response);

          $("div[data-count='profiles']").html(data.count);

        });

      };

      var registerEvents = function() {};

      var init = function() {
        registerEvents();
        getPropertyCount();
        getCredits();
        getProfiles();
      };

      init();

    };

  }(jQuery));
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var ins = new $.HomeManager({});
  });
</script>

<?php include './includes/footer.html'; ?>