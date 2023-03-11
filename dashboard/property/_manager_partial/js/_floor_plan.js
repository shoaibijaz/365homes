$.FloorPlanManager = function (options) {

    var imageList = [];

    var settings = $.extend({
        productObject: null
    }, options);

    var saveImage = function (image, thumb) {

        toastr.info("Saving floor plan image");

        var params = {
            property_id: settings.productObject.id,
            image: image,
            image_thumb: thumb,
            sort_order: imageList.length + 1
        };

        $.post('/api/app_property_floor_plans/save.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Floor plan image has been saved', 'Success');
                getImages();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

            $("#pills-floor .progress-bar").empty().css('width', 0);

        });
    };

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

        $("#floorPlanList").empty();

        for (let index = 0; index < imageList.length; index++) {

            var item = imageList[index];

            var source = document.getElementById("floorPlanItemTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#floorPlanList").append(template(item));

        }

        try {
            $("#floorPlanList").sortable("destroy");
        } catch (error) {}

        $("#floorPlanList").sortable({
            tolerance: 'pointer',
            revert: 'invalid',
            helper: 'clone',
            update: function (event, ui) {
                updateSortOrder();
            }
        });

        $("#floorPlanList").disableSelection();
    };

    var deleteImage = function (id) {

        var params = {
            id: id,
            is_deleted: 1
        };

        $.post('/api/app_property_floor_plans/update_delete_status.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Floor plan image has been removed', 'Success');
                getImages();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

        });
    };

    var updateSortOrder = function () {

        var dataArray = $("#floorPlanList").sortable("toArray");

        if (dataArray.length <= 0) {
            toastr.warning('No data found');
            return;
        }

        $("#backdrop").show();

        var params = {
            id: dataArray
        };

        $.post('/api/app_property_floor_plans/update_sort_order.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Floor plan image position has been updated', 'Success');
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

            $("#backdrop").hide();
        });
    };

    var registerEvents = function () {

        $("#floorPlanList").on("click", ".link-view", function (e) {
            e.stopPropagation();
            var id = $(this).attr('id');
            if (!id) return;

            var entity = imageList.find(a => a.id == id);

            if (entity) {
                bootbox.alert("<img class='mw-100' src='" + entity.image + "'>", function () {});
            }
        });

        $("#floorPlanList").on("click", ".link-delete", function (e) {
            e.stopPropagation();
            var id = $(this).attr('id');
            if (!id) return;

            bootbox.confirm("Are you sure! You want to delete this floor plan?", function (result) {

                if (result) {
                    deleteImage(id);
                }
            });

        });

         $("#fpDropZone").dropzone({
            maxFiles: 10,
            dictDefaultMessage: "Drop your floon plan files here to upload",
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

                Dropzone.forElement('#fpDropZone').removeFile(file);

            }

        });

    };

    var init = function () {
        registerEvents();
        getImages();
    };

    init();

};