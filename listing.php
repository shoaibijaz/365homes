<?php

$id = $_GET['id'];
$page_title = 'Universities Worldwide';
$totalCount = 0;
$country = null;

if (!isset($id)) die();

include $_SERVER['DOCUMENT_ROOT'] . '/api/app_properties/filter_properties.php';
if (count($results) > 0) {
    $country = $results[0]['country'];
    $totalCount = $results[0]['total'];
    $page_title = $results[0]['country'] . ' Universities';
}

function isset_full($data)
{
    return isset($data) && !empty($data);
}

include 'includes/header.php';

?>

<div class="parallax page-header" style="display:none;">
    <a href="#">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1></h1>
                </div>
            </div>
        </div>
    </a>
</div>

<!-- Start Content -->
<div class="main" role="main">
    <div id="content" class="content full">
        <div class="container">

            <div class="row">
                <div class="col-md-7">
                    <div class="block-heading">
                        <h4><span class="heading-icon"><i class="fa fa-th-list"></i></span>
                            <span> <?= $page_title; ?></span>
                        </h4>
                        <span class="p-5 strong" id="lblState"></span>
                        <span class="p-5">
                            <a href="#" class="btn btn-primary btn-sm pull-right"> <?= $totalCount ?> Universities</a>
                        </span>
                    </div>
                    <div class="property-listing">

                        <form id="fmFilter">
                            <input type="hidden" name="country" value="<?= $id ?>">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="state" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-lg" placeholder="Enter keywords" name="q">
                                </div>
                                <div class="col-md-4">
                                    <select name="city" class="form-control">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button id="btnFilter" type="button" class="btn btn-primary btn-block btn-lg">Search</button>
                                </div>
                            </div>
                        </form>

                        <ul>
                            <?php foreach ($results as $key => $value) : ?>

                                <li class="type-rent col-md-12">
                                    <div class="col-md-4">
                                        <a href="<?= slugifyUniversity($value); ?>" class="property-featured-image1">

                                            <?php if (isset_full($value['logo'])) : ?>
                                                <img src="<?= $value['logo'] ?>" alt="logo">
                                            <?php else : ?>
                                                <img src="fe_assets/images/holder_uni.png" alt="logo">
                                            <?php endif ?>

                                        </a>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="property-info">
                                            <h3><a href="<?= slugifyUniversity($value); ?>">
                                                    <?= $value['title'] ?>
                                                </a></h3>
                                            <span class="location margin-10">
                                                <?php if (isset_full($value['city'])) : ?>
                                                    <?= $value['city'] ?>,
                                                <?php endif ?>
                                                <?php if (isset_full($value['state'])) : ?>
                                                    <?= $value['state'] ?>,
                                                <?php endif ?>

                                                <?= $value['country'] ?>
                                            </span>

                                            <a class="btn btn-primary" href="<?= slugifyUniversity($value); ?>">View Details >> </a>
                                        </div>
                                    </div>
                                </li>

                            <?php endforeach; ?>
                        </ul>

                        <?php if ($totalCount <= 0) : ?>
                            <div class="mt-2 p-5">
                                <div class="alert alert-dark">
                                    There are no universities that meet you filter requirements.
                                </div>
                            </div>
                        <?php endif ?>

                    </div>

                    <div class="pagination paginationjs-theme-blue" id="pagination">
                    </div>
                </div>

                <div class="col-md-5">
                    <div id="countrySidebar"></div>
                </div>
                <!-- Start Sidebar -->

            </div>

        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='countrySidebarTemplate'>

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h5 class="margin-0">{{title}}</h5>
        </div>
        <div class="panel-body text-center">
            {{#if flag_image}}
                <div class="margin-20">
                    <img src="{{flag_image}}" alt="">
                </div>
                <hr>
            {{/if}}
           
            {{#if anthem}}
                <div>
                    <h5>Anthem</h5>
                    <audio controls>
                        <source src="{{anthem}}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>

                    <h4>
                        {{anthem_title}}
                    </h4>
                </div>
                <hr>
            {{/if}}
            
            {{#if moto}}
                <div>
                    <h5 class="margin-0">Motto</h5>

                    <h4>
                        {{moto}}
                    </h4>
                </div>
            {{/if}}
            
            {{#if attributes_json}}
            
            <table class="table">
                <tbody>
                {{#each attributes}}
                <tr>
                    <td>{{name}}</td>
                    <td>{{value}}</td>
                </tr>
                {{/each}}
                </tbody>
            </table>
            
                <hr>
            {{/if}}

            {{#if more_details}}
                <div>
                {{{more_details}}}
                </div>
            {{/if}}
        </div>
    </div>
</script>

<?php include 'includes/pre_footer.html'; ?>
<?php include 'includes/scripts.html'; ?>
<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
        margin-bottom: 15px;
        display: none;
    }
</style>

<script>
    (function($) {

        $.PropertyListPage = function(options) {

            var totalCount = '<?php echo ($totalCount); ?>';
            var idSlug = '<?php echo ($id); ?>';
            var countryName = '<?php echo ($country); ?>';

            var settings = $.extend({}, options);

            var initPagination = function() {

                var currentPage = getQS('page');
                currentPage = currentPage ? currentPage : 1;

                $("input[name='page']").val(currentPage);

                if (totalCount <= 0) {
                    $('#pagination').hide();
                    return;
                }

                $('#pagination').pagination({
                    dataSource: function(done) {
                        var result = [];
                        for (var i = 1; i <= totalCount; i++) {
                            result.push(i);
                        }
                        done(result);
                    },
                    locator: 'data',
                    pageSize: 10,
                    totalNumber: totalCount,
                    pageNumber: currentPage,
                    showPrevious: true,
                    showNext: true,
                    className: 'paginationjs-theme-blue',
                    //prevText: '<i class="la la-long-arrow-left"></i> Prev',
                    //nextText: 'Next <i class="la la-long-arrow-right"></i',
                    afterRender: function() {
                        // $(".paginationjs").css('margin', '0 auto');

                    },
                    afterPageOnClick: function(data, pagination) {
                        $("input[name='page']").val(pagination);
                        $("#btnFilter").trigger('click');
                    }
                })
            };

            var fillCountiesDropdown = function() {

                var tries = 0;

                var intr = setInterval(function() {

                    if (window.Countries) {

                        clearInterval(intr);

                        $(window.Countries).each(function(ix, item) {
                            var option = $("<option />", {
                                text: item.title,
                                value: item.slug
                            });

                            $("#fmFilter select[name='country']").append(option);
                        });

                        if (idSlug && idSlug != 'all') {
                            $("#fmFilter select[name='country']").val(idSlug);
                        }

                        $("#fmFilter select[name='country']").eq(0).select2({
                            theme: 'bootstrap',
                            width: '100%',
                        });

                        $("#fmFilter select[name='country']").eq(0).data('select2').$container.addClass('form-control margin-15 ');

                    } else if (tries >= 10) {
                        clearInterval(intr);
                    }

                    tries++;

                }, 1000);

            };

            var checkUSAStatesReady = function() {
                var tries = 0;

                return new Promise(function(resolve, reject) {
                    var intr = setInterval(function() {

                        if (window.USAStates) {
                            clearInterval(intr);
                            resolve();
                        } else if (tries >= 10) {
                            clearInterval(intr);
                            resolve();
                        }

                    }, 1000);
                })
            }

            var getCountryDetails = function() {
                if (idSlug == 'all') return;

                var state = getQS('state');
                var city = getQS('city');

                var data = {};

                var arr =[];
                if(state) arr.push(state);
                if(city) arr.push(city);

                if (arr.length>0) {
                    data.title = arr.join(";");
                } else {
                    data.slug = idSlug
                }
                $.get('/api/app_countries/find_with_details.php', data, function(response) {
                    var element = JSON.parse(response);

                    if (!countryName) {
                        $("h4 span").eq(1).html(element.title + " Universities");
                    }

                    if (!element.id) return;

                    element.attributes = [];

                    if (element.attributes_json) element.attributes = JSON.parse(element.attributes_json);

                    var source = document.getElementById("countrySidebarTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#countrySidebar").append(template(element));

                    if (element.page_banner_json) {
                        var parsedTopBanner = JSON.parse(element.page_banner_json);

                        if (parsedTopBanner.image) {
                            $(".page-header").css('background-image', 'url(' + parsedTopBanner.image + ')').show();
                        }

                        if (parsedTopBanner.text) {
                            $(".page-header h1").html(parsedTopBanner.text);
                        }

                        if (parsedTopBanner.link) {
                            $(".page-header a").attr('href', parsedTopBanner.link);
                            $(".page-header a").attr('target', '_blank');
                        }
                    }

                    if (element.page_map_json) {
                        var parsed = JSON.parse(element.page_map_json);
                        if (parsed.map_type == 'usa_states') {
                        }
                    }
                });
            };

            var getCitiesGroup = function() {

                if (!countryName) {
                    $("#fmFilter select[name='city']").select2({
                        theme: 'bootstrap',
                        width: '100%',
                    });

                    $("#fmFilter select[name='city']").data('select2').$container.addClass('form-control');
                    return;
                }

                var data = {
                    country: countryName
                };

                var state = getQS('state');

                if (state) data.state = state;

                $.get('/api/app_properties/group_by_city.php', data, function(response) {
                    var citiesList = JSON.parse(response);

                    citiesList.forEach(function(item) {
                        var option = $("<option />", {
                            text: item.city,
                            value: item.city
                        });
                        $("#fmFilter select[name='city']").append(option);
                    });

                    var city = getQS('city');

                    if (city) {
                        $("#fmFilter select[name='city']").val(city);
                    }

                    $("#fmFilter select[name='city']").select2({
                        theme: 'bootstrap',
                        width: '100%',
                    });

                    $("#fmFilter select[name='city']").data('select2').$container.addClass('form-control');

                });
            };

            var registerEvents = function() {

                $("div").on("click", "#btnFilter", function(e) {
                    e.stopPropagation();

                    var data = $("#fmFilter").serializeArray().reduce(function(m, o) {
                        m[o.name] = $.trim(o.value);
                        return m;
                    }, {});

                    var slug = '/all-universities';

                    if (data.country) {
                        slug = "/" + data.country + "-universities";
                    }

                    slug = slug + "?page=" + data.page;

                    if (data.q) {
                        slug = slug + "&q=" + data.q;
                    }

                    if (data.state) {
                        slug = slug + "&state=" + data.state;
                    }

                    if (data.city) {
                        slug = slug + "&city=" + data.city;
                    }

                    window.location.href = slug;

                });

                var stateCrumbs = [];

                var q = getQS('q');

                if (q) {
                    $("input[name='q']").val(q);
                }

                var state = getQS('state');

                if (state) {
                    $("input[name='state']").val(state);
                    stateCrumbs.push(state);
                }

                var city = getQS('city');

                if (city)
                    stateCrumbs.push(city);

                $("#lblState").html(stateCrumbs.join(' > '));

            };

            var init = function() {
                registerEvents();
                initPagination();
                getCitiesGroup();
                getCountryDetails();

            };

            init();

            return this;
        };

        var pls = new $.PropertyListPage();

    }(jQuery));
</script>

<?php include 'includes/footer.html'; ?>