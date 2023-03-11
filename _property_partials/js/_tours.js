(function ($) {
  $.TourManager = function (options) {

    var that = this;
    var videosList = [];
    var currentIndex = 0;

    var settings = $.extend({
      productObject: null
    }, options);

    var getVideos = function () {

      var params = {
        property_id: settings.productObject.id,
        is_deleted: 0
      };

      $.get('/api/app_property_tours/filter.php', params, function (response) {
        videosList = JSON.parse(response);
        drawList();
      });
    };

    var drawList = function () {

      if (videosList.length == 1) {
        var item = videosList[currentIndex];
        activeVideo(item);
      } else if (videosList.length > 1) {
        createCarousel();
      } else {
        $("#pills-profile-tab").parent().remove();
        $("#pills-profile").remove();
        $("a[data-href='#video']:contains('Virtual Tour')").remove();
      }

      setTimeout(() => {
        if ($("#pills-tab li").length <= 0) {
          $("#video").remove();
          $("a[data-href='#video']:contains('Virtual Tour')").remove();
        }

        if ($("#pills-home-tab").length <= 0) {
          $('#pills-profile-tab').tab('show')
        }

      }, 3000);

    };

    var activeVideo = function (item) {
      $("#tourFrame").attr('src', item.tour_link);
      $("#tourFrame").VideoEmbedFrame();
    };

    var createCarousel = function(){

      var source = document.getElementById("tourItemTemplate").innerHTML;
      var template = Handlebars.compile(source);
      $("#pills-profile").html(template({data:videosList}));

      $("#carouselExampleControls2 .carousel-item").eq(0).addClass('active');

           
  };

    var registerEvents = function () {
    };

    var init = function () {
      registerEvents();
      getVideos();
    };

    init();

  };

}(jQuery));