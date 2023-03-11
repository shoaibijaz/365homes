<?php
function slugifyUniversity($row, string $divider = '-')
{
  $text = $row['title'];

  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return  $text . '-' . $row['id'];
}

?>

<!DOCTYPE html>

<html class="no-js" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> <?php echo ($page_title); ?></title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
  <meta name="format-detection" content="telephone=no">

  <link rel="icon" type="image/png" href="fe_assets/images/map-marker.png">

  <!-- CSS
  ================================================== -->
  <link href="fe_assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="fe_assets/css/style.css" rel="stylesheet" type="text/css">
  <link href="fe_assets/plugins/prettyphoto/css/prettyPhoto.css" rel="stylesheet" type="text/css">
  <link href="fe_assets/plugins/owl-carousel/css/owl.carousel.css" rel="stylesheet" type="text/css">
  <link href="fe_assets/plugins/owl-carousel/css/owl.theme.css" rel="stylesheet" type="text/css">

  <link href="/fe_assets/plugins/select2/select2.min.css" rel="stylesheet" />
  <link href="/fe_assets/plugins/pagination/pagination.css" rel="stylesheet" />
  <link href="/admin_assets/vendor/easy_autocomplete/easy-autocomplete.min.css" rel="stylesheet" />

  <!--[if lte IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
  <!-- Color Style -->
  <link href="fe_assets/colors/color10.css" rel="stylesheet" type="text/css">
  <!-- SCRIPTS
  ================================================== -->
  <script src="fe_assets/js/modernizr.js"></script><!-- Modernizr -->

</head>

<body class="home">
  <!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
  <div class="body">
    <!-- Start Site Header -->
    <header class="site-header">
      <div class="top-header hidden-xs">
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-sm-6">
              <ul class="horiz-nav pull-left">
                <li><a href="/login"><i class="fa fa-user"></i> Login</a></li>

                <li><a href="/signup"><i class="fa fa-check-circle"></i> Register</a></li>
              </ul>
            </div>
            <div class="col-md-8 col-sm-6">
              <ul class="horiz-nav pull-right">
                <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="middle-header">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <!-- <h1 class="logo"> <a href="/"><img src="fe_assets/images/logo.png" width="50" alt="Logo"></a> </h1> -->

              <div class="top-logo-search">
                <input type="text" class="form-control form-control-sm" id="txtTopSearch" placeholder="Search University">
              </div>
            </div>

            <div class="col-md-3 text-right logo">
              <a href="/">
              <img src="fe_assets/images/logo_2.png" width="125" alt="Logo">
              </a>
            </div>
            <div class="col-md-5">
              <div class="contact-info-blocks hidden-sm hidden-xs">
                <div>
                  <i class="fa fa-phone"></i> Free Line For You
                  <span>080 378678 90</span>
                </div>
                <div>
                  <i class="fa fa-envelope"></i> Email Us
                  <span>sales@realspaces.com</span>
                </div>

              </div>
              <a href="#" class="visible-sm visible-xs menu-toggle margin-20"><i class="fa fa-bars"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="main-menu-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <nav class="navigation">
                <ul class="sf-menu">
                  <li><a href="/">Home</a>
                  </li>
                  <li><a href="javascript:;">World</a>
                    <ul class="scroll-search" id="countries_1">
                      <li class="p-5">
                        <input type="text" autocomplete="off" class="form-control form-control-sm" tabindex="0" focus id="txtQCountries_1" placeholder="Search country">
                      </li>

                    </ul>

                  </li>
                  <li><a href="javascript:;">USA</a>
                    <ul class="scroll-search" id="usaStates_1">
                      <li class="p-5">
                        <input type="text" autocomplete="off" class="form-control form-control-sm" tabindex="0" focus id="txtQUSAStates_1" placeholder="Search USA states">
                      </li>
                      <li>
                        <a href="./united-states-universities">All States</a>
                      </li>
                    </ul>
                  </li>
                  <li><a href="/add-university">Add University</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- End Site Header -->