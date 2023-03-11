$.MainPhotoManager = function(options) {

    var that = this;

    var productObject;

    var settings = $.extend({
        productObject: null
    }, options);

    var imageForm = function() {

        $('#fmPhoto').ajaxForm({
            beforeSend: function() {
                $("#pills-main-photo .progress-bar").empty();
                var percentVal = '0%';
                $("#pills-main-photo .progress-bar").css('width', percentVal)
                $("#pills-main-photo .progress-bar").html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                $("#pills-main-photo .progress-bar").css('width', percentVal)
                $("#pills-main-photo .progress-bar").html(percentVal);
            },
            success: function(responseText, statusText, xhr, $form) {
                var parsed = JSON.parse(responseText);

                if (parsed.message) {
                    savePhoto(parsed.message);
                }
            },
            complete: function(xhr) {}
        });
    };

    var savePhoto = function(photo) {

        var data = {
            main_image: photo,
            id: settings.productObject.id
        };

        $.post('/api/app_properties/update_main_image.php', data, function(response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Image has been saved', 'Success');
                drawPhoto(photo);

            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
        });

    };

    var drawPhoto = function(photo) {
        $("#pills-main-photo img").attr('src', photo);
    };

    var registerEvents = function() {

        $("div").on("change", "#fuPhoto", function(e) {
            e.stopPropagation();
            $('#fmPhoto').submit();
        });

        $("div").on("click", "#btnDeleteMainPhoto", function(e) {
            e.stopPropagation();
            bootbox.confirm("Are you sure? You want to delete this photo", function(r) {

                if (r) {
                    savePhoto(null);
                }
            });
        });
    };

    var init = function() {
        registerEvents();
        imageForm();
        drawPhoto(settings.productObject.main_image);
    };

    init();

};
