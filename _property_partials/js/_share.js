(function ($) {
    $.ShareManager = function (options) {

        var that = this;

        var settings = $.extend({
            productObject: null
        }, options);

        var facebookShare = function () {
            u = location.href;
            t = document.title;
            window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t),
                'sharer',
                'toolbar=0,status=0,width=626,height=436');

            return false;
        };

        var twitterShare = function () {

            var u = window.location;
            var t = 'Explore ' + settings.productObject.address + ' at';

            window.open('http://twitter.com/share?url=' + encodeURIComponent(u) + '&text=' + encodeURIComponent(t) + '&via=365homes' + '&hashtags=365homes',
                'sharer',
                'toolbar=0,status=0,width=626,height=436');
        };

        var registerEvents = function () {

            $("div").on("click", ".btn-social", function (e) {
                e.stopPropagation();

                if (this.title == 'Facebook') {
                    facebookShare();
                } else
                if (this.title == 'Twitter') {
                    twitterShare();
                }

            });


        };

        var init = function () {
            registerEvents();
        };

        init();

    };
}(jQuery));