$.VirtualTourLinkManager1 = function (options) {

    var that = this;

    var productObject;

    var settings = $.extend({}, options);

    var tourForm = function () {
        $('#fmTour').ajaxForm({
            beforeSend: function () {},
            success: function (responseText, statusText, xhr, $form) {
                var r = JSON.parse(responseText);

                if (r.result > 0) {
                    toastr.success('Tour link has been saved', 'Success');
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

            },
            complete: function (xhr) {}
        });
    };
    var registerEvents = function () {

        $("div").on("click", "#btnSaveTourLink", function (e) {
            e.stopPropagation();
            $('#fmTour').submit();
        });

        $("div").on("click", "#btnDeleteTourLink", function (e) {
            e.stopPropagation();

            bootbox.confirm("Are you sure! You want to delete tour link?", function (result) {

                if (result) {
                    $("#fmTour input[name='virtual_tour_link']").val(null);
                    $('#fmTour').submit();
                }
            });

        });

        $("#fmTour input[name='virtual_tour_link']").val(settings.productObject.virtual_tour_link);
    };

    var init = function () {
        registerEvents();
        tourForm();
    };

    init();

};

$.TourManager = function(options) {

    var that = this;
    var videosList = [];

    var settings = $.extend({
        productObject: null
    }, options);

    var videoForm = function() {
        $('#fmTour').ajaxForm({
            beforeSend: function() {},
            success: function(responseText, statusText, xhr, $form) {
                var r = JSON.parse(responseText);

                if (r.result > 0) {
                    toastr.success('Tour has been saved', 'Success');
                    getVideos();
                    clearForm();
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }

            },
            complete: function(xhr) {}
        });
    };

    var getVideos = function() {

        var params = {
            property_id: settings.productObject.id,
            is_deleted: 0,
            "_": $.now()
        };

        $.get('/api/app_property_tours/filter.php', params, function(response) {
            videosList = JSON.parse(response);
            drawList();
        });
    };

    var drawList = function() {

        $("#toursList").empty();

        for (let index = 0; index < videosList.length; index++) {

            var item = videosList[index];

            var source = document.getElementById("tourItemTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#toursList").append(template(item));

        }
    };

    var clearForm = function() {
        $("#fmTour input").val(null);
        $("#fmTour input[name='sort_order']").val(videosList.length);
        $("#fmTour input[name='property_id']").val(settings.productObject.id);
    };

    var deleteImage = function(id) {

        var params = {
            id: id,
            is_deleted: 1
        };

        $.post('/api/app_property_tours/update_delete_status.php', params, function(response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Tour has been removed', 'Success');
                getVideos();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

        });
    };

    var registerEvents = function() {

        $("div").on("click", "#btnSaveTour", function(e) {
            e.stopPropagation();
            $('#fmTour').submit();
        });

        $("div").on("click", ".link-tour-edit", function(e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');
            var video = videosList.find(a => a.id == id);

            for (var item in video) {
                $("#fmTour input[name='" + item + "']").val(video[item]);
            }

        });

        $("div").on("click", ".link-tour-delete", function(e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');
            bootbox.confirm("Are you sure! You want to delete tour?", function(result) {

                if (result) {
                    deleteImage(id);
                }
            });

        });

    };

    var init = function() {
        registerEvents();
        clearForm();
        videoForm();
        getVideos();
    };

    init();

};