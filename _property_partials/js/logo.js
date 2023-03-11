(function ($) {
    $.LogoSettingsManager = function (options) {

        var that = this;

        var keyName = 'logo_settings';

        var settings = $.extend({
            productObject: null
        }, options);

        var getSettings = function () {

            var params = {
                key_name: keyName,
                property_id: settings.productObject.id
            };

            $.get('/api/app_properties_settings/find_by_key.php', params, function (response) {

                if (response) {

                    var parsed = JSON.parse(response);

                    if (parsed.key_value) {

                        var formValues = JSON.parse(parsed.key_value);
                        $("#logoPanel img").css({
                            width: formValues.width,
                            height: formValues.height
                        });

                    }
                }

            });


        };

        var init = function () {
            getSettings();
        };

        init();

    };
}(jQuery));