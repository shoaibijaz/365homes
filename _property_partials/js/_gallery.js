

(function ($) {
    $.GalleryManager = function (options) {

        var that = this;
        var imageList = [];
        var productObject;

        var imagesLimit = 15;

        var settings = $.extend({
            productObject: null
        }, options);

        var getImages = function () {

            var params = {
                property_id: settings.productObject.id,
                is_deleted: 0
            };

            $.get('/api/app_property_images/filter.php', params, function (response) {
                imageList = JSON.parse(response);
                drawList();
            });
        };

        var drawList = function () {

            $("#images").empty();

            for (let index = 0; index < imageList.length; index++) {

                var item = imageList[index];

                item.counter = index;
                item.cls = '';

                if (index > imagesLimit) {
                    item.cls = 'd-none';
                }

                var source = document.getElementById("galleryItemTemplate").innerHTML;
                var template = Handlebars.compile(source);

                $("#images").append(template(item));

            }

            if (imageList.length > imagesLimit) {
                $("#btnShowMoreImages").removeClass('d-none');

            }

            if(imageList.length <=0) {
                $("#gallery").remove();
                $('a[data-href="#gallery"]').remove();
            }

        };

        var registerEvents = function () {
            $("div").on("click", "#btnShowMoreImages", function (e) {
                e.stopPropagation();

                if ($(this).text().indexOf('More') >= 0) {
                    $(".gallery-item").removeClass('d-none');
                    $(this).text('Show Less');
                } else {
                    $(".gallery-item").each(function (ix) {
                        if (ix > imagesLimit) {
                            $(this).addClass('d-none');
                        }
                    });
                    $(this).text('Show More');
                }
            });

        };

        var init = function () {
            registerEvents();
            getImages();
        };

        init();

    };
}(jQuery));