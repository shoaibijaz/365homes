$.LogoManager = function (options) {

    var that = this;

    var productObject;

    var settings = $.extend({
        productObject: null
    }, options);

    var imageForm = function () {

        $('#fmLogo').ajaxForm({
            beforeSend: function () {
                $("#fmLogo .progress-bar").empty();
                var percentVal = '0%';
                $("#fmLogo .progress-bar").css('width', percentVal)
                $("#fmLogo .progress-bar").html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                $("#fmLogo .progress-bar").css('width', percentVal)
                $("#fmLogo .progress-bar").html(percentVal);
            },
            success: function (responseText, statusText, xhr, $form) {
                var parsed = JSON.parse(responseText);

                if (parsed.message) {
                    saveLogo(parsed.message);
                }
            },
            complete: function (xhr) {}
        });
    };

    var saveLogo = function (image) {

        var params = {
            id: settings.productObject.id,
            logo: image,
        };

        $.post('/api/app_properties/update_logo.php', params, function (response) {
            var r = JSON.parse(response);

            if (r.result > 0) {
                toastr.success('Logo has been saved', 'Success');
                drawPhoto(image);
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }

            $("#fmLogo .progress-bar").empty().css('width', 0);

        });
    };

    var drawPhoto = function (photo) {

        $("#logoPanel").empty();

        if (!photo) return;

        var item = {
            logo: photo
        };

        var source = document.getElementById("logoItemTemplate").innerHTML;
        var template = Handlebars.compile(source);

        $("#logoPanel").html(template(item));
    };

    var registerEvents = function () {

        $("div").on("change", "#fuLogo", function (e) {
            e.stopPropagation();
            $('#fmLogo').submit();
        });

        $("div").on("click", ".link-delete-logo", function (e) {
            e.stopPropagation();

            bootbox.confirm("Are you sure! You want to delete logo?", function (result) {

                if (result) {
                    saveLogo(undefined);
                }
            });

        });
    };

    var init = function () {
        registerEvents();
        imageForm();
        drawPhoto(settings.productObject.logo);

        new $.LogoSettingsManager({
            productObject: settings.productObject
        });
    };

    init();

};

$.LogoSettingsManager = function (options) {

    var that = this;

    var defaultValues = {
        width: 152,
        height: 25,
        left: 0,
        top: 0
    };

    var keyName = 'logo_settings';

    var settings = $.extend({
        productObject: null
    }, options);

    var saveSettings = function (data) {
        $.post('/api/app_properties_settings/save.php', data, function (response) {

            var parsed = JSON.parse(response);

            if (parsed.result > 0) {
                toastr.success('Logo settings has been saved');
            } else {
                toastr.success('Settings failed to saved. Please try again or reload the page.');
            }
        });
    };

    var getSettings = function () {

        var params = {
            key_name: keyName,
            property_id: settings.productObject.id,
            "_": $.now()
        };

        $.get('/api/app_properties_settings/find_by_key.php', params, function (response) {

            var formValues = defaultValues;

            if (response) {
                var parsed = JSON.parse(response);

                if (parsed.key_value) {
                    formValues = JSON.parse(parsed.key_value);
                }
            }

            for (var item in formValues) {
                $("#fmLogoSettings input[name='" + item + "']").val(formValues[item]);
            }

        });
    };

    var registerEvents = function () {

        $("div").on("click", "#btnSaveLogoSettings", function (e) {
            e.stopPropagation();

            var data = $("#fmLogoSettings").serializeObject();

            saveSettings({
                key_name: keyName,
                key_value: JSON.stringify(data),
                property_id: settings.productObject.id
            });

        });
    };

    var init = function () {
        registerEvents();
        getSettings();
    };

    init();

};