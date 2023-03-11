$.GalleryManager = function (options) {

    var that = this;

    var imageList = [];

    var productObject;

    var settings = $.extend({
        productObject: null
    }, options);

    var imageForm = function () {

        $('#fmGallery').ajaxForm({
            beforeSend: function () {
                $("#pills-gallery .progress-bar").empty();
                var percentVal = '0%';
                $("#pills-gallery .progress-bar").css('width', percentVal)
                $("#pills-gallery .progress-bar").html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                $("#pills-gallery .progress-bar").css('width', percentVal)
                $("#pills-gallery .progress-bar").html(percentVal);
            },
            success: function (responseText, statusText, xhr, $form) {
                var parsed = JSON.parse(responseText);

                if (parsed.message) {
                    saveImage(parsed.message);
                }
            },
            complete: function (xhr) {
                // setTimeout(function() {

                // }, 2000);
            }
        });
    };

    var saveImage = function (image, thumb) {

        toastr.info("Saving image");

        var params = {
            property_id: settings.productObject.id,
            image: image,
            image_thumb: thumb,
            sort_order: imageList.length + 1
        };

        $.post('/api/app_property_images/save.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Image has been saved', 'Success');
                getImages();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

            $("#pills-gallery .progress-bar").empty().css('width', 0);

        });
    };

    var getImages = function () {

        var params = {
            property_id: settings.productObject.id,
            is_deleted: 0,
            "_": $.now()
        };

        $.get('/api/app_property_images/filter.php', params, function (response) {
            imageList = JSON.parse(response);
            drawList();
        });
    };

    var drawList = function () {

        $("#galleryList").empty();

        for (let index = 0; index < imageList.length; index++) {

            var item = imageList[index];

            var source = document.getElementById("galleryItemTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#galleryList").append(template(item));

        }

        try {
            $("#galleryList").sortable("destroy");
        } catch (error) {}

        $("#galleryList").sortable({
            tolerance: 'pointer',
            revert: 'invalid',
            helper: 'clone',
            update: function (event, ui) {
                updateSortOrder();
            }
        });

        $("#galleryList").disableSelection();
    };

    var deleteImage = function (id) {

        var params = {
            id: id,
            is_deleted: 1
        };

        $.post('/api/app_property_images/update_delete_status.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Image has been removed', 'Success');
                getImages();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

        });
    };

    var updateSortOrder = function () {

        var dataArray = $("#galleryList").sortable("toArray");

        if (dataArray.length <= 0) {
            toastr.warning('No data found');
            return;
        }

        $("#backdrop").show();

        var params = {
            id: dataArray
        };

        $.post('/api/app_property_images/update_sort_order.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Images position has been updated', 'Success');
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

            $("#backdrop").hide();
        });
    };

    var registerEvents = function () {

        $("div").on("change", "#fuGallery", function (e) {
            e.stopPropagation();
            $('#fmGallery').submit();
        });

        $("#galleryList").on("click", ".link-view", function (e) {
            e.stopPropagation();
            var id = $(this).attr('id');
            if (!id) return;

            var entity = imageList.find(a => a.id == id);

            if (entity) {
                bootbox.alert("<img class='mw-100' src='" + entity.image + "'>", function () {});
            }
        });

        $("#galleryList").on("click", ".link-delete", function (e) {
            e.stopPropagation();
            var id = $(this).attr('id');
            if (!id) return;

            bootbox.confirm("Are you sure! You want to delete this item?", function (result) {

                if (result) {
                    deleteImage(id);
                }
            });

        });

        var myDropzone = $("#galleryDropZone").dropzone({
            maxFiles: 20,
            params: {
                'property': settings.productObject.id
            },
            complete: function (file) {

                try {
                    var parsed = JSON.parse(file.xhr.response);

                    if (parsed.result > 0) {
                        saveImage(parsed.message, parsed.sub_message);

                    }
                } catch (error) {
                    toastr.error('image failed to upload');
                }

                console.log(file);

                Dropzone.forElement('#galleryDropZone').removeFile(file);

            }

        });

    };

    var init = function () {
        registerEvents();
        imageForm();
        getImages();
    };

    init();

};