(function ($) {
    $.AttributesManager = function (options) {

        var dataList = [];

        var settings = $.extend({
            productObject: null
        }, options);

        var getDataList = function () {

            $.get('/api/app_properties_features/filter.php', {
                is_deleted: 0,
                property_id: settings.productObject.id
            }, function (response) {

                dataList = JSON.parse(response);

                for (let index = 0; index < dataList.length; index++) {
                    var element = dataList[index];
                    var source = document.getElementById("featureItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#featuresList").append(template(element));
                }
            });

        };

        var formatNumber = function(number) {
            var splitNum;
            number = Math.abs(number);
            number = number.toFixed(2);
            splitNum = number.split('.');
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return splitNum.join(".");
        };

       
        var registerEvents = function () {

            var text= $(".price-ft").text();

            if(text) {
                var val = formatNumber(text);
                $(".price-ft").html(val);
            }
        };

        var init = function () {
            registerEvents();
            getDataList();
        };

        init();

    };
}(jQuery));