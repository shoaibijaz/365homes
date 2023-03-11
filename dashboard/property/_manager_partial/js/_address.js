(function ($) {
    L.mapquest.key = '06WJXAb8tcsXUuyWpbMVE8HGM888sefb';
    Dropzone.autoDiscover = false;

    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] || o[this.name] == '') {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    function string_to_slug(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();
        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to = "aaaaeeeeiiiioooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes
        return str;
    };

    $.AddressManager = function (options) {
        var propertyObject;
        var propertyId = getQS('id');
        var myLatLng = [45.4206, -75.6907];
        myLatLng = [43.718803, -79.493494]
        var fg = L.featureGroup();
        var settings = $.extend({}, options);

        var getBasicInfo = function () {
            if (!propertyId) {
                return;
            }
            $.get('/api/app_properties/find.php', {
                id: propertyId,
                "_": $.now()
            }, function (response) {
                propertyObject = JSON.parse(response);
                loadFormData();
            });
        };

        var loadFormData = function () {
            if (propertyObject) {
                for (var field in propertyObject) {
                    $("#fmAddress input[name='" + field + "']").val(propertyObject[field]);
                }

                new $.BasicInfoManager({
                    productObject: propertyObject
                });

                new $.GalleryManager({
                    productObject: propertyObject
                });

                new $.FloorPlanManager({
                    productObject: propertyObject
                });

                new $.VideoManager({
                    productObject: propertyObject
                });

                new $.AttributesManager({
                    productObject: propertyObject
                });

                new $.MainPhotoManager({
                    productObject: propertyObject
                });
                
                new $.TourManager({
                    productObject: propertyObject
                });

                new $.LogoManager({
                    productObject: propertyObject
                });

                new $.KeyPointsManager({
                    productObject: propertyObject
                });

                new $.AgentsManager({
                    productObject: propertyObject
                });

                $(".link-preview").each(function () {
                    var link = '/real-estate-web-pages/' + string_to_slug(propertyObject.address) + "-property-" + propertyObject.id;
                    $(this).attr('href', link);
                });

                setTimeout(function () {
                    var mapLocation = $("#fmAddress input[name='map_location']").val();
                    if (mapLocation) {
                        var latLng = JSON.parse(mapLocation);
                        myLatLng = [latLng.lat, latLng.lng];
                        drawMarker();
                    } else { }
                }, 2000);
            }
        };

        var initForm = function () {
            var options = {
                beforeSubmit: function () {
                    var r = $("#fmAddress").valid();
                    if (!r) return r;
                    $("#fmAddress input").attr('disabled', true);
                    $("#fmAddress button").attr('disabled', true);
                },
                success: onSaveForm,
            };
            $("#fmAddress").ajaxForm(options);
        };

        var onSaveForm = function (response) {
            var r = JSON.parse(response);
            if (r.result > 0) {
                toastr.success('Property has been created', 'Success');
                var pkId = $("#fmAddress input[name='id']").val();
                //window.location.href = 'manager.php?id=' + r.result;
                if (!pkId || pkId <= 0) {
                    addMatomoSite(r.result);
                } else {
                    window.location.href = 'manager.php?id=' + r.result;
                }
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
            $("#fmAddress input").attr('disabled', false);
            $("#fmAddress button").attr('disabled', false);
        };

        var addMatomoSite = function (propertyId) {

            if(window.location.href.indexOf('localhost')>=0) {
                window.location.href = 'manager.php?id=' + propertyId;
                return;
            };

            var title = $("#fmAddress input[name='address']").val();

            if (!propertyId) return;

            var apiURL = 'https://stats.365homes.net/index.php?module=API&method=SitesManager.addSite';

            var params = {
                siteName: title + " - " + propertyId,
                urls: 'https://365homes.net',
                timezone: 'America/Toronto',
                currency: 'CAD',
                startDate: 'today',
                type: 'website',
                siteSearch: '1',
                token_auth: ''
            };

            // apiURL = 'http://localhost:9094/index.php?module=API&method=SitesManager.addSite';
            // var params = {
            //     siteName: title + " - " + propertyId,
            //     urls: 'http://localhost:9099/',
            //     timezone: 'America/Toronto',
            //     currency: 'CAD',
            //     startDate: 'today',
            //     type: 'website',
            //     siteSearch: '1',
            //     token_auth: ''
            // }
            $.post(apiURL, params, function (response) {
                var siteID = parseInt($(response).text());
                var dataParams = {
                    property_id: propertyId,
                    tracking_id: siteID,
                    tracking_type: 'matomo',
                };
                insertTrackingSite(dataParams, propertyId);
            });
        };

        var insertTrackingSite = function (params, propertyId) {
            $.post('/api/app_properties_analytics/save.php', params, function (response) {
                var parsed = JSON.parse(response);
                window.location.href = 'manager.php?id=' + propertyId;
            });
        };

        var validateForm = function () {
            $("#fmAddress").validate({
                rules: {
                    address: {
                        required: true,
                    }
                },
            });
        };

        var initMap = function () {
            $("#mapPanel").css({
                height: 300
            });
            mapObject = L.mapquest.map('mapPanel', {
                center: myLatLng,
                layers: [L.mapquest.tileLayer('hybrid'), fg],
                zoom: 10
            });
            mapObject.whenReady(function () {
                initSearch();
                L.control.layers({
                    'Map': L.mapquest.tileLayer('map'),
                    'Satellite': L.mapquest.tileLayer('satellite'),
                    'Hybrid': L.mapquest.tileLayer('hybrid'),
                    'Light': L.mapquest.tileLayer('light'),
                    'Dark': L.mapquest.tileLayer('map')
                }, {}, {
                    position: 'topleft'
                }).addTo(mapObject);
                $("#mapBackdrop").hide();
            });
        };

        var initSearch = function () {
            var ps = placeSearch({
                key: L.mapquest.key,
                container: document.querySelector('#txtAddressSearch')
            });
            ps.on('change', (e) => {
                if (e.result) {
                    if (e.result.value) {
                        $("#fmAddress input[name='map_location']").val(JSON.stringify(e.result.latlng));
                        $("#fmAddress input[name='address']").val(e.result.value);
                    }
                    if (e.result.latlng) {
                        myLatLng = [e.result.latlng.lat, e.result.latlng.lng];
                        drawMarker();
                    }
                }
            });
        };

        var drawMarker = function () {
            try {
                var layers = fg.getLayers();
                for (var i = 0; i < layers.length; i++) {
                    fg.removeLayer(layers[i]);
                }
            } catch (error) { }
            marker = L.marker(myLatLng, {
                icon: L.mapquest.icons.marker(),
                draggable: true
            }).addTo(fg);
            marker.on('dragend', function () {
                myLatLng = [marker._latlng.lat, marker._latlng.lng];
                $("#fmAddress input[name='map_location']").val(JSON.stringify(marker._latlng));
            });
            mapObject.fitBounds(fg.getBounds());
            mapObject.setZoom(17);
            $("#mapBackdrop").hide();
        };

        var registerEvents = function () {
            $("div").on("click", "#btnCreateProperty", function (e) {
                e.stopPropagation();
                $("#fmAddress").submit();
            });
            $("div").on("click", ".link-clear-location", function (e) {
                e.stopPropagation();
                try {
                    var layers = fg.getLayers();
                    for (var i = 0; i < layers.length; i++) {
                        fg.removeLayer(layers[i]);
                    }
                    $("#fmAddress input[name='map_location']").val(null);
                    $("#txtAddressSearch").val(null);
                    $("button.mq-input-icon.mq-icon-clear").trigger('click');
                } catch (error) { }
            });
        };

        var init = function () {
            registerEvents();
            initMap();
            initForm();
            validateForm();
            getBasicInfo();
        };
        init();
    };

    $.fn.VideoEmbedFrame = function () {
        var urlParser = function (frame) {
            var srcURL = frame.src;
            if (!srcURL) return;
            if (srcURL.indexOf("youtu") >= 0) {
                makeYouTubeEmbed(srcURL, frame);
            }
        };
        var makeYouTubeEmbed = function (url, frameObject) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            var ID = (match && match[2].length === 11) ?
                match[2] :
                null;
            if (ID) {
                var url = 'https://www.youtube.com/embed/' + ID;
                frameObject.src = url;
            }
        };
        return this.each(function () {
            urlParser(this);
        });
    };
}(jQuery));