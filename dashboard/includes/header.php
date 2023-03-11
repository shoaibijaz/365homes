<?php include 'check_session.php'; ?>

<?php

?>

<!DOCTYPE html>

<html lang="en-US">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" type="image/png" sizes="32x32" href="/admin_assets/img/favicon.png">

  <title> <?php echo ($page_title); ?></title>

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <link href="/admin_assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="/admin_assets/vendor/toastr/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/admin_assets/vendor/summernote/summernote-bs4.min.css" />

  <link rel="stylesheet" href="/admin_assets/vendor/datatables/dataTables.bootstrap4.min.css" type="text/css" />
  <link rel="stylesheet" href="/admin_assets/vendor/datatables/responsive.bootstrap4.min.css" type="text/css" />
  <link rel="stylesheet" href="/admin_assets/vendor/datatables/buttons.bootstrap4.min.css" type="text/css" />

  <link rel="stylesheet" href="/admin_assets/vendor/datetime/css/bootstrap-datetimepicker.min.css" type="text/css" />

  <link href="/admin_assets/css/style.css" rel="stylesheet">

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

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-lock"></i>
        </div>
        <div class="sidebar-brand-text mx-3">..</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard/property">
          <i class="fas fa-fw fa-venus"></i>
          <span>Properties</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard/agents/profiles.php">
          <i class="far fa-id-badge"></i>
          <span>Profiles</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard/stats/">
          <i class="fas fa-chart-bar"></i>
          <span>Statistics</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard/property/messages.php">
          <i class="fas fa-fw fa-comments"></i>
          <span>Messages</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard/my_plans/">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Plans</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
            <ul class="navbar-nav ml-auto">


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Properties
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/dashboard/property">Properties List</a>
                  <!-- <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/dashboard/property/trash.php">Deleted Properties</a> -->
                </div>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownStats" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Statistics
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/dashboard/stats/">Visitors</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/dashboard/stats/devices.php">Devices</a>
                </div>
              </li>

              <li class="nav-item">

                <a class="nav-link text-dark" href="/dashboard/agents/profiles.php">
                  Profiles
                </a>


              </li>

              <li class="nav-item">
                <a class="nav-link text-dark" href="/dashboard/my_plans/">
                  My Plans
                </a>
              </li>


              <li class="nav-item">
                <a class="nav-link text-dark" href="/dashboard/property/messages.php">
                  Messages
                </a>
              </li>


            </ul>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter notify-unread"></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>

                <div id="notifyList"></div>

              </div>
            </li>

            <li class="nav-item dropdown no-arrow mx-1">
              <a href="../my_plans/purchase.php" class="nav-link">
                <button type="button" class="btn-sm btn btn-yellow">Upgrade</button>
              </a>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-uppercase">
                  <?php echo ($_SESSION['login_agent']['login_name']); ?>
                </span>


                <?php if (empty($_SESSION['login_agent']['photo'])) : ?>
                  <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                <?php endif; ?>

                <?php if (!empty($_SESSION['login_agent']['photo'])) : ?>
                  <img class="img-profile rounded-circle" src=" <?php echo ($_SESSION['login_agent']['photo']); ?>">
                <?php endif; ?>

              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" id="topUserDropdown" aria-labelledby="userDropdown">

                <a href="../my_plans/purchase.php" class="dropdown-item text-center">
                  <button type="button" class="btn btn-yellow btn-sm">Upgrade</button>
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="../my_plans/">
                  <i class="fas fa-shopping-cart fa-sm fa-fw mr-2 text-gray-400"></i>
                  My Plans
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="/dashboard/user/profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="/dashboard/user/change_password.php">
                  <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="/logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->