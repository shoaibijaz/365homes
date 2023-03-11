(function ($) {
  $.ContactManager = function (options) {

    var that = this;

    var productObject;
    var contactModal;

    var agentId;

    var settings = $.extend({
      productObject: null
    }, options);

    var contactForm = function () {

      $('#fmContact').ajaxForm({
        clearForm: true,
        beforeSend: function () {
          var r = $("#fmContact").valid();
          if (!r) return r;

          $("#contactSection input").attr('disabled', true);
          $("#contactSection button").attr('disabled', true);

        },
        success: function (responseText, statusText, xhr, $form) {
          var parsed = JSON.parse(responseText);

          if (parsed.result > 0) {
            alert('Thank you for your inquiry. We will contact you shortly.');
          } else {
            alert('Sorry, operation failed. Please try again.')
          }

        },
        complete: function (xhr) {
          $("#contactSection input").attr('disabled', false);
          $("#contactSection button").attr('disabled', false);
        }
      });
    };

    var validateBasicForm = function () {
      $("#fmContact").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          full_name: {
            required: true,
          },

          phone: {
            required: true,
          },
        },
      });
    };

    var registerEvents = function () {

      $("div").on("click", "#btnSubmitContact", function (e) {
        e.stopPropagation();
        $('#fmContact').submit();
      });

    };

    var init = function () {
      registerEvents();
      contactForm();
      validateBasicForm();
    };

    init();

  };
}(jQuery));