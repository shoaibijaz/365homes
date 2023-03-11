L.mapquest.key = '06WJXAb8tcsXUuyWpbMVE8HGM888sefb';

(function ($) {

    $.BasicInfoManager = function (options) {

        var propertyObject;
        var myLatLng = [45.4206, -75.6907];
        var fg = L.featureGroup();

        var settings = $.extend({
            propertyId: null
        }, options);

        var getBasicInfo = function () {
            if (!settings.propertyId) return;

            $.get('/api/app_properties/find.php', {
                id: settings.propertyId
            }, function (response) {
                propertyObject = JSON.parse(response);

                loadPlugins();
            });

        };

        var setTopBackground = function () {
            if (propertyObject.main_image) {

                var css = 'linear-gradient(to bottom, rgb(65 64 64 / 58%) 0%, rgb(20 20 20 / 52%) 100%), url(' + propertyObject.main_image + ')';


                $(".masthead").css('background-image', css);
            } else {
                $(".masthead").css('background-image', 'none');
                $(".masthead").css('background-color', '#9f9f9f');
            }
        };

        var loadPlugins = function () {
            if (propertyObject) {

                setTopBackground();

                $(".embed-frame").VideoEmbedFrame();

                new $.AttributesManager({
                    productObject: propertyObject
                });

                new $.GalleryManager({
                    productObject: propertyObject
                });

                new $.ContactManager({
                    productObject: propertyObject
                });

                new $.KeyPointsManager({
                    productObject: propertyObject
                });

                new $.ShareManager({
                    productObject: propertyObject
                });

                new $.AgentsManager({
                    productObject: propertyObject
                });

                new $.LogoSettingsManager({
                    productObject: propertyObject
                });

                new $.VideoManager({
                    productObject: propertyObject
                });

                new $.TourManager({
                    productObject: propertyObject
                });

                new $.FloorPlanManager({
                    productObject: propertyObject
                });

                initMap();

            }

        };

        var initMap = function () {

            var source = document.getElementById("locationTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#locationArea").append(template(propertyObject));

            $("#mapPanel").css({
                height: 300
            });

            var mapLocation = propertyObject.map_location;

            if (mapLocation) {
                var latLng = JSON.parse(mapLocation);
                myLatLng = [latLng.lat, latLng.lng];
            }

            mapObject = L.mapquest.map('mapPanel', {
                center: myLatLng,
                layers: [L.mapquest.tileLayer('hybrid'), fg],
                zoom: 10
            });

            mapObject.whenReady(function () {
                drawMarker();

                L.control.layers({
                    'Map': L.mapquest.tileLayer('map'),
                    'Satellite': L.mapquest.tileLayer('satellite'),
                    'Hybrid': L.mapquest.tileLayer('hybrid'),
                    'Light': L.mapquest.tileLayer('light'),
                    'Dark': L.mapquest.tileLayer('map')
                  }, {}, { position: 'topleft'}).addTo(mapObject);

            });
        };

        var drawMarker = function () {

            try {

                var layers = fg.getLayers();

                for (var i = 0; i < layers.length; i++) {
                    fg.removeLayer(layers[i]);
                }

            } catch (error) {}

            marker = L.marker(myLatLng, {
                icon: L.mapquest.icons.marker(),
                draggable: false
            }).addTo(fg);

            mapObject.fitBounds(fg.getBounds());
            mapObject.setZoom(17);

        };

        var registerEvents = function () {
            $("div").on("click", ".link-scroll", function (e) {
                e.stopPropagation();

                var id = $(this).attr('data-href');

                $('html, body').animate({
                    scrollTop: $(id).offset().top - 50
                }, 500);

            });
        };

        var init = function () {
            registerEvents();
            getBasicInfo();
        };

        init();

    };

    $.fn.VideoEmbedFrame = function () {

        var urlParser = function (frame) {
            var srcURL = frame.src;

            if (!srcURL) return;

            if (srcURL.indexOf("youtu") >= 0) {
                makeYouTubeEmbed(srcURL, frame);
            }
        };

        var makeYouTubeEmbed = function (url, frameObject) {

            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);

            var ID = (match && match[2].length === 11) ?
                match[2] :
                null;

            if (ID) {
                var url = 'https://www.youtube.com/embed/' + ID;
                frameObject.src = url;
            }

        };

        return this.each(function () {
            urlParser(this);
        });

    };

}(jQuery));