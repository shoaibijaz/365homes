(function ($) {
    $.KeyPointsManager = function (options) {

        var dataList = [];

        var settings = $.extend({
            productObject: null
        }, options);

        var getDataList = function () {

            $.get('/api/app_properties_key_points/filter.php', {
                is_deleted: 0,
                property_id: settings.productObject.id
            }, function (response) {

                dataList = JSON.parse(response);

                for (let index = 0; index < dataList.length; index++) {
                    var element = dataList[index];
                    var source = document.getElementById("keyPointItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#keyPointsList").append(template(element));
                }

                if (dataList.length <= 0) {
                    $("#keyPointsList").hide();
                }
            });

        };

        var registerEvents = function () {};

        var init = function () {
            registerEvents();
            getDataList();
        };

        init();

    };
}(jQuery));