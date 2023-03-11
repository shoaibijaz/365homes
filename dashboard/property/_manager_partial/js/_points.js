$.KeyPointsManager = function (options) {

    var dataList = [];

    var settings = $.extend({
        productObject: null
    }, options);

    var initForm = function () {

        var options = {
            beforeSubmit: function () {
                var r = $("#fmKeyPoints").valid();
                if (!r) return r;

                $("#keyPointsModal input").attr('disabled', true);
                $("#keyPointsModal button").attr('disabled', true);
            },
            success: onSave,
        };

        $("#fmKeyPoints").ajaxForm(options);
    };

    var onSave = function (response) {

        var r = JSON.parse(response);

        if (r.result > 0) {
            toastr.success('Key point has been saved', 'Success');
            $("#keyPointsModal").modal('hide');
            getDataList();
        } else {
            toastr.error('Failed to complete the request', 'INFO!');
        }

        $("#keyPointsModal input").attr('disabled', false);
        $("#keyPointsModal button").attr('disabled', false);
    };

    var validateForm = function () {
        $("#fmKeyPoints").validate({
            rules: {
                key_point: {
                    required: true,
                    maxlength: 200
                }
            },
        });
    };

    var getDataList = function () {

        $("#keyPointsList").empty();

        $.get('/api/app_properties_key_points/filter.php', {
            is_deleted: 0,
            property_id: settings.productObject.id,
            "_": $.now()
        }, function (response) {

            dataList = JSON.parse(response);

            for (let index = 0; index < dataList.length; index++) {
                var element = dataList[index];
                var source = document.getElementById("keyPointListItemTemplate").innerHTML;
                var template = Handlebars.compile(source);
                $("#keyPointsList").append(template(element));
            }

        });

    };

    var deleteFeature = function (id, isDeleted) {

        $.post('/api/app_properties_key_points/update_delete_status.php', {
            is_deleted: isDeleted,
            id: id
        }, function (response) {
            var r = JSON.parse(response);

            if (r.result == 1) {
                toastr.success('Key point has been deleted', 'Success');
                getDataList();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
        });

    };

    var registerEvents = function () {

        $("div").on("click", ".link-add-new-pt", function (e) {
            e.stopPropagation();

            var source = document.getElementById("keyPointFormTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#keyPointsModal").html(template({
                sort_order: dataList.length + 1
            }));

            var val = $("#keyPointsModal textarea").eq(0).val();

            $("#keyPointsModal textarea").eq(0).val($.trim(val));

            $("#keyPointsModal").modal({
                show: true,
                backdrop: 'static'
            });

        });

        $("div").on("click", "#btnSaveKeyPoint", function (e) {
            e.stopPropagation();
            $("#fmKeyPoints").submit();
        });

        $("div").on("click", ".link-edit-pt", function (e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');
            var item = dataList.find(a => a.id == id);

            var source = document.getElementById("keyPointFormTemplate").innerHTML;
            var template = Handlebars.compile(source);

            $("#keyPointsModal").html(template(item));

            var val = $("#keyPointsModal textarea").eq(0).val();
            $("#keyPointsModal textarea").eq(0).val($.trim(val));

            $("#keyPointsModal").modal({
                show: true,
                backdrop: 'static'
            });

        });

        $("div").on("click", ".link-delete-pt", function (e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');

            bootbox.confirm("Are you sure you want to delete this key point?", function (r) {

                if (r) {
                    deleteFeature(id, 1);
                }
            });

        });

        $('#keyPointsModal').on('shown.bs.modal', function (e) {
            initForm();
            validateForm();
        });

        $('#keyPointsModal').on('hidden.bs.modal', function (e) {
            $('#keyPointsModal').empty();
        });

    };

    var init = function () {
        registerEvents();
        getDataList();
    };

    init();

};