$.AttributesManager = function (options) {

    var propertyIconsList = [{
            image_path: '/icons_files/bedroom.png',
            title: 'Beds'
        },
        {
            image_path: '/icons_files/bathrooms.png',
            title: 'Baths'
        },
        {
            image_path: '/icons_files/garage.png',
            title: 'Garage'
        },
        {
            image_path: '/icons_files/floor-plan.png',
            title: 'Interior'
        },
        {
            image_path: '/icons_files/house-type.png',
            title: 'Year'
        },
        {
            image_path: '/icons_files/pool.png',
            title: 'Pool'
        },
        {
            image_path: '/icons_files/toilets.png',
            title: 'Toilets'
        },
        {
            image_path: '/icons_files/open-house.png',
            title: 'Open House'
        },
        {
            image_path: '/icons_files/for-rent.png',
            title: 'For Rent'
        },
        {
            image_path: '/icons_files/for-sale.png',
            title: 'For Sale'
        },
        {
            image_path: '/icons_files/location.png',
            title: 'Location'
        }
    ];

    var dataList = [];
    var listDataTable;

    var settings = $.extend({
        productObject: null
    }, options);

    var initForm = function () {

        var options = {
            beforeSubmit: function () {
                var r = $("#fmFeatures").valid();
                if (!r) return r;

                $("#featureModal input").attr('disabled', true);
                $("#featureModal button").attr('disabled', true);
            },
            success: onSave,
        };

        $("#fmFeatures").ajaxForm(options);
    };

    var onSave = function (response) {

        var r = JSON.parse(response);

        if (r.result > 0) {
            toastr.success('Feature has been saved', 'Success');
            $("#featureModal").modal('hide');
            getDataList();
        } else {
            toastr.error('Failed to complete the request', 'INFO!');
        }

        $("#featureModal input").attr('disabled', false);
        $("#featureModal button").attr('disabled', false);
    };

    var validateForm = function () {
        $("#fmFeatures").validate({
            rules: {
                title: {
                    required: true,
                },
                value: {
                    required: true,
                }
            },
        });
    };

    var getDataList = function () {

        if (listDataTable) {
            listDataTable.destroy();
        }

        $("#tblFeatures tbody").empty();

        $.get('/api/app_properties_features/filter.php', {
            is_deleted: 0,
            property_id: settings.productObject.id,
            "_": $.now()
        }, function (response) {

            dataList = JSON.parse(response);

            for (let index = 0; index < dataList.length; index++) {
                var element = dataList[index];
                var source = document.getElementById("featureListItemTemplate").innerHTML;
                var template = Handlebars.compile(source);
                $("#tblFeatures tbody").append(template(element));
            }

            listDataTable = $("#tblFeatures").DataTable({
                "columnDefs": [],
                initComplete: function () {
                    this.api().columns().every(function () {});
                },
            });

            listDataTable.draw();

        });

    };

    var drawIcons = function () {
        $(propertyIconsList).each(function (ix, item) {
            var div = $("<div />", {
                class: 'col-md-2 mb-2 text-center'
            });

            var img = $("<img />", {
                src: item.image_path,
                'data-src': item.image_path,
                class: "img-fluid img-thumbnail link-icon-ft",
                role: "button",
                style: 'max-height:70px;'
            });

            div.html(img);

            $("#featureIconsList").append(div);
        });

        var image = $('#featureModal input[name="image"]').val();

        if (image) {
            $('#featureModal img[data-src="' + image + '"]').addClass('bg-success');
        }
    };

    var deleteFeature = function (id, isDeleted) {

        $.post('/api/app_properties_features/update_delete_status.php', {
            is_deleted: isDeleted,
            id: id
        }, function (response) {
            var r = JSON.parse(response);

            if (r.result == 1) {
                toastr.success('Feature has been deleted', 'Success');
                getDataList();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
        });

    };

    var registerEvents = function () {

        $("div").on("click", ".link-add-new-ft", function (e) {
            e.stopPropagation();

            var source = document.getElementById("featureFormTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#featureModal").html(template({
                sort_order: dataList.length + 1
            }));
            $("#featureModal").modal({
                show: true,
                backdrop: 'static'
            });

        });

        $("div").on("click", ".link-icon-ft", function (e) {
            e.stopPropagation();

            var src = $(this).attr('data-src');

            var hasClass = $(this).hasClass('bg-success');

            $(".link-icon-ft").removeClass('bg-success');
            $('#featureModal input[name="image"]').val(null);

            if (!hasClass) {
                $(this).addClass('bg-success');
                $('#featureModal input[name="image"]').val(src);
            }

        });

        $("div").on("click", "#btnSaveFeature", function (e) {
            e.stopPropagation();
            $("#fmFeatures").submit();
        });

        $("div").on("click", ".link-edit-ft", function (e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');
            var item = dataList.find(a => a.id == id);

            var source = document.getElementById("featureFormTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#featureModal").html(template(item));

            $("#featureModal").modal({
                show: true,
                backdrop: 'static'
            });

        });

        $("div").on("click", ".link-delete-ft", function (e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');

            bootbox.confirm("Are you sure? You want to delete this feature", function (r) {

                if (r) {
                    deleteFeature(id, 1);
                }
            });

        });

        $('#featureModal').on('shown.bs.modal', function (e) {
            drawIcons();
            initForm();
            validateForm();
        });

        $('#featureModal').on('hidden.bs.modal', function (e) {
            $('#featureModal').empty();
        });

    };

    var init = function () {
        registerEvents();
        getDataList();
    };

    init();

};