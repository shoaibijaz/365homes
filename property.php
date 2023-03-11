<?php

$id = $_GET['id'];

if (!isset($id)) {
  die();
}

include $_SERVER['DOCUMENT_ROOT'] . '/api/app_properties/get_properties_detail.php';

$product = getPropertyDetail($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title><?php echo ($product['property']['address']); ?></title>
  <!-- Favicon-->
  <link rel="icon" type="image/png" sizes="32x32" href="/fe_assets/assets/logo.jpg">
  <!-- Bootstrap Icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />

  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="/fe_assets/css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="/fe_assets/plugins/lightbox/v1.css" />
  <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css" />
  <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css" />
  <link type="text/css" rel="stylesheet" href="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.css" />

  <meta property="og:url" content="<?php echo ('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" />
  <meta property="og:type" content="video" />
  <meta property="og:title" content="Explore <?php echo ($product['property']['address']); ?> in 3D" />
  <meta property="og:description" content="365homes" />

  <meta property="og:image" content="<?php echo ($product['property']['main_image']); ?>" />

  <meta name="twitter:card" content="photo">
  <meta name="twitter:site" content="@365homes">
  <meta name="twitter:title" content="Explore <?php echo ($product['property']['address']); ?> in 3D">
  <meta name="twitter:description" content="365homes">
  <meta name="twitter:image" content="<?php echo ($product['property']['main_image']); ?>">
  <meta name="twitter:url" content="<?php echo ('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">

  <!-- Matomo -->
  <script>
    var _paq = window._paq = window._paq || [];
    var _matomo_id = '<?php echo ($product['property']['tracking_id']); ?>';

    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);

    (function() {
      var u = "//stats.365homes.net/";
      _paq.push(['setTrackerUrl', u + 'matomo.php']);
      _paq.push(['setSiteId', _matomo_id]);

      var d = document,
        g = d.createElement('script'),
        s = d.getElementsByTagName('script')[0];
      g.async = true;
      g.src = u + 'matomo.js';

      if (_matomo_id) {
        s.parentNode.insertBefore(g, s);
      }

    })();
  </script>
  <!-- End Matomo Code -->

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZPDFR37Z17"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-ZPDFR37Z17');
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-216234949-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-216234949-1');
  </script>

</head>

<body id="page-top">

  <!-- Navigation-->
  <?php include_once './_property_partials/_nav.php' ?>

  <!-- Masthead-->
  <?php include_once './_property_partials/_header.php' ?>

  <!-- Overview -->
  <?php include_once './_property_partials/_overview.php' ?>

  <!-- Gallery-->
  <?php include_once './_property_partials/_gallery.php' ?>

  <!-- Video-->
  <?php include_once './_property_partials/_video.php' ?>

  <!-- Floor Plan-->
  <?php include_once './_property_partials/_floor.php' ?>

  <!-- Location-->
  <?php include_once './_property_partials/_location.php' ?>

  <!-- Agents-->
  <?php include_once './_property_partials/_agent.php' ?>

  <!-- Footer-->
  <?php include_once './_property_partials/_footer.php' ?>

  <script src="/fe_assets/plugins/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/fe_assets/plugins/handlebars.min.js"></script>
  <script src="/fe_assets/plugins/jquery.form.js"></script>
  <script src="/fe_assets/plugins/jquery.validate.min.js"></script>
  <script src="/fe_assets/plugins/lightbox/v1.js"></script>
  <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
  <script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
  <script src="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.js"></script>

  <!-- Core theme JS-->
  <script src="/fe_assets/js/scripts.js"></script>
  <script src="../_property_partials/js/_basic.js"></script>
  <script src="../_property_partials/js/_features.js"></script>
  <script src="../_property_partials/js/_gallery.js"></script>
  <script src="../_property_partials/js/_contact.js"></script>
  <script src="../_property_partials/js/_key_points.js"></script>
  <script src="../_property_partials/js/_share.js"></script>
  <script src="../_property_partials/js/_agents.js"></script>
  <script src="../_property_partials/js/_logo.js"></script>
  <script src="../_property_partials/js/_video.js"></script>
  <script src="../_property_partials/js/_tours.js"></script>
  <script src="../_property_partials/js/_floor_plan.js"></script>

  <script type="text/javascript">

    $.ajaxSetup({
      cache: false
    });

    $(document).ready(function() {
      var ins = new $.BasicInfoManager({
        propertyId: '<?php echo ($id); ?>'
      });
    });
  </script>
</body>

</html>