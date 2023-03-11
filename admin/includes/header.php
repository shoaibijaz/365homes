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

  <title> 365HOMES - <?php echo ($page_title); ?></title>

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <link href="/admin_assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="/admin_assets/vendor/toastr/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/admin_assets/vendor/summernote/summernote-bs4.min.css" />

  <link rel="stylesheet" href="/admin_assets/vendor/datatables/dataTables.bootstrap4.min.css" type="text/css" />
  <link rel="stylesheet" href="/admin_assets/vendor/datatables/responsive.bootstrap4.min.css" type="text/css" />
  <link rel="stylesheet" href="/admin_assets/vendor/datatables/buttons.bootstrap4.min.css" type="text/css" />

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-lock"></i>
        </div>
        <div class="sidebar-brand-text mx-3">..</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active d-none">
        <a class="nav-link" href="/admin/property">
          <i class="fas fa-fw fa-venus"></i>
          <span>Properties</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/admin/user/">
          <i class="fas fa-fw fa-users"></i>
          <span>Users</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/admin/plan/">
          <i class="fas fa-fw fa-tasks"></i>
          <span>Plans</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/admin/agent_plan/">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Agent Plans</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <li class="nav-item active">
        <a class="nav-link" href="/admin/trackings/manager.php">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>Tracking</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Dashboard -->
      <!-- <li class="nav-item active">
        <a class="nav-link" href="/dashboard/property/messages.php">
          <i class="fas fa-fw fa-comments"></i>
          <span>Messages</span></a>
      </li> -->

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


              <li class="nav-item dropdown d-none">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Properties
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/admin/property">Properties List</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/admin/property/trash.php">Deleted Properties</a>
                </div>
              </li>

              <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Users
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/admin/user/">Users List</a>
                </div>
              </li>

              <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Plans
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/admin/plan/">Plans List</a>
                </div>
              </li>

              <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Agent Plans
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/admin/agent_plan/">Agent Plans List</a>
                </div>
              </li>

              <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Trackings
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/admin/trackings/manager.php">Manager</a>
                </div>
              </li>

              <!-- <li class="nav-item">
                <a class="nav-link text-dark" href="/dashboard/property/messages.php">
                  Messages
                </a>
              </li> -->


            </ul>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- <li class="nav-item">
              <a class="nav-link  text-dark link-how-work" href="javascript:;">

                How it works
              </a>
            </li> -->

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

            <div class="topbar-divider d-none d-sm-block"></div>


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php echo ($_SESSION['login_admin']['login_name']); ?>
                </span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

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