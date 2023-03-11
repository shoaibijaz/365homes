(function ($) {
    $.VideoManager = function (options) {

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

            $.get('/api/app_property_videos/filter.php', params, function (response) {
                videosList = JSON.parse(response);
                drawList();
            });
        };

        var drawList = function () {

            if(videosList.length == 1) {
                var item = videosList[currentIndex];
                activeVideo(item);
            }
            else if(videosList.length > 1) {
                createCarousel();
            }
            else {
                $("#pills-home-tab").parent().remove();
                $("#pills-home").remove();
                $("a[data-href='#video']:contains('Video')").remove();
            }

            setTimeout(() => {
                if ($("#pills-tab li").length <= 0) {
                    $("#video").remove();
                    $("a[data-href='#video']:contains('Video')").remove();
                }
            }, 3000);


        };

        var activeVideo = function (item) {
            $("#videoFrame").attr('src', item.video_link);
            $("#videoFrame").VideoEmbedFrame();
        };

        var createCarousel = function(){

            var source = document.getElementById("videoItemTemplate").innerHTML;
            var template = Handlebars.compile(source);
            $("#pills-home").html(template({data:videosList}));

            $("#carouselExampleControls .carousel-item").eq(0).addClass('active');

            $("#carouselExampleControls .carousel-item iframe").each(function(){
                $(this).VideoEmbedFrame();
            });
        };

        var registerEvents = function () {
        };

        var init = function () {
            // registerEvents();
            getVideos();
        };

        init();

    };
}(jQuery));