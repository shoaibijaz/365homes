(function ($) {
      $.FloorPlanManager = function (options) {

        var imageList = [];
    
        var settings = $.extend({
            productObject: null
        }, options);
    
        var getImages = function () {
    
            var params = {
                property_id: settings.productObject.id,
                is_deleted: 0,
                "_": $.now()
            };
    
            $.get('/api/app_property_floor_plans/filter.php', params, function (response) {
                imageList = JSON.parse(response);
                drawList();
            });
        };
    
        var drawList = function () {

            if(imageList.length <=0) {
                $('a[data-href="#floor_plan"]').remove();
                $('#floor_plan').remove();
            }

            $("#floorPlanList").empty();
    
            for (let index = 0; index < imageList.length; index++) {
    
                var item = imageList[index];
    
                var source = document.getElementById("flooPlanItemTemplate").innerHTML;
                var template = Handlebars.compile(source);
    
                $("#floorPlanList").append(template(item));
    
            }
        };
    
        var registerEvents = function () {
        };
    
        var init = function () {
            registerEvents();
            getImages();
        };
    
        init();
    
    };
}(jQuery));