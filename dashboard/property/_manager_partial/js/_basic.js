(function ($) {
    $.BasicInfoManager = function (options) {

        var propertyTypeList = ['Detached House',

            'Semi-detached House',

            'Townhouse',

            'Duplex/Triplex',

            'Condominium',

            'Apartment',

            'Vacation Home',

            'Mobile Home',

            'Timeshare',

            'Parking Stall',

            'Commercial',

            'Vacant Lot',

            'Detached Backsplit'

        ];

        var settings = $.extend({
            productObject: null
        }, options);

        var loadBasicInfoForm = function () {
            for (var field in settings.productObject) {
                var value = settings.productObject[field];
                if (value) {

                    $("#fmBasic input[name='" + field + "']").val(value);

                    $("#fmBasic textarea[name='" + field + "']").val(value);

                    $("#fmBasic select[name='" + field + "']").val(value);

                }
            }
            $("select[name='transaction_type']").trigger('change');
        };

        var initBasicInfoForm = function () {
            var options = {

                beforeSubmit: function () {

                    var r = $("#fmBasic").valid();

                    if (!r) return r;
                    $("#fmBasic input").attr('disabled', true);

                    $("#fmBasic button").attr('disabled', true);

                },

                success: onSaveBasicDetails,

            };
            $("#fmBasic").ajaxForm(options);

        };

        var onSaveBasicDetails = function (response) {
            var r = JSON.parse(response);
            if (r.result > 0) {

                toastr.success('Property details has been saved', 'Success');

            } else {

                toastr.error('Failed to complete the request', 'INFO!');

            }
            $("#fmBasic input").attr('disabled', false);

            $("#fmBasic button").attr('disabled', false);

        };

        var validateBasicForm = function () {

            $("#fmBasic").validate({
                rules: {
                    property_type: {
                        required: true,
                    }
                },

            });

        };

        var bindPropertyType = function () {

            $(propertyTypeList).each(function (ix, item) {

                var opt = $("<option />", {
                    text: item,
                    value: item
                });

                $('select[name="property_type"]').append(opt);
            });

        };

        var registerEvents = function () {

            $("div").on("click", "#btnBasicInfo", function (e) {
                e.stopPropagation();
                $("#fmBasic").submit();
            });

            $("div").on("click", ".link-clear-location", function (e) {
                e.stopPropagation();

                try {

                    var layers = fg.getLayers();

                    for (var i = 0; i < layers.length; i++) {

                        fg.removeLayer(layers[i]);

                    }
                    $("input[name='map_location']").val(null);

                    $("#txtAddressSearch").val(null);
                } catch (error) {}

            });

            $("div").on("change", "select[name='transaction_type']", function (e) {

                e.stopPropagation();

                var val = $(this).val();
                if (val == 'Sale') {

                    $("#priceBox label").html('Price');

                } else {

                    $("#priceBox label").html('Rental Price/mo');

                }

            });

            $("textarea").each(function () {

                var val = $.trim($(this).val());

                $(this).val(val);

            });

        };
        
        var init = function () {

            registerEvents();

            bindPropertyType();

            loadBasicInfoForm();

            initBasicInfoForm();

            validateBasicForm();

        };
        init();
    };
}(jQuery));