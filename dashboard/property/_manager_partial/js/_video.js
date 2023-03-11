$.VideoManager = function (options) {
    var that = this;
    var videosList = [];
    var settings = $.extend({
        productObject: null
    }, options);
    var videoForm = function () {
        $('#fmVideo').ajaxForm({
            beforeSend: function () {},
            success: function (responseText, statusText, xhr, $form) {
                var r = JSON.parse(responseText);
                if (r.result > 0) {
                    toastr.success('Video has been saved', 'Success');
                    getVideos();
                    clearForm();
                } else {
                    toastr.error('Failed to complete the request', 'INFO!');
                }
            },
            complete: function (xhr) {}
        });
    };
    var getVideos = function () {
        var params = {
            property_id: settings.productObject.id,
            is_deleted: 0,
            "_": $.now()
        };
        $.get('/api/app_property_videos/filter.php', params, function (response) {
            videosList = JSON.parse(response);
            drawList();
        });
    };
    var drawList = function () {
        $("#videosList").empty();
        for (let index = 0; index < videosList.length; index++) {
            var item = videosList[index];
            var source = document.getElementById("videoItemTemplate").innerHTML;
            var template = Handlebars.compile(source);
            $("#videosList").append(template(item));
        }
    };
    var clearForm = function () {
        $("#fmVideo input").val(null);
        $("#fmVideo input[name='sort_order']").val(videosList.length);
        $("#fmVideo input[name='property_id']").val(settings.productObject.id);
    };
    var deleteImage = function (id) {
        var params = {
            id: id,
            is_deleted: 1
        };
        $.post('/api/app_property_videos/update_delete_status.php', params, function (response) {
            var r = JSON.parse(response);
            if (r.result > 0) {
                toastr.success('Video has been removed', 'Success');
                getVideos();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
        });
    };
    var registerEvents = function () {
        $("div").on("click", "#btnSaveVideoLink", function (e) {
            e.stopPropagation();
            $('#fmVideo').submit();
        });
        $("div").on("click", ".link-video-edit", function (e) {
            e.stopPropagation();
            var id = $(this).attr('data-id');
            var video = videosList.find(a => a.id == id);
            for (var item in video) {
                $("#fmVideo input[name='" + item + "']").val(video[item]);
            }
        });
        $("div").on("click", ".link-video-delete", function (e) {
            e.stopPropagation();
            var id = $(this).attr('data-id');
            bootbox.confirm("Are you sure! You want to delete video?", function (result) {
                if (result) {
                    deleteImage(id);
                }
            });
        });
    };
    var init = function () {
        registerEvents();
        clearForm();
        videoForm();
        getVideos();
    };
    init();
};