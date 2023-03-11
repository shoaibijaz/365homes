<?php

session_start();

$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    if ($_SESSION['login_agent']['credits'] <= 0) {
        header("Location: /dashboard/my_plans/purchase.php?from=property");
    }
}

$page_title = 'Manage Property';
include '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div id="backdrop">
                <div class="spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <h6 class="m-0 font-weight-bold text-dark">Property Information</h6>

                    <div>
                        <?php if (isset($_GET['id'])) : ?>
                            <a class="btn btn-sm btn-orange link-preview" href="/property.php?id=<?php echo ($id); ?>" target="_blank">
                                <i class="fa fa-street-view"></i> Preview Page
                            </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3 custom" id="pills-tab" role="tablist">

                        <li class="nav-item mb-1 mr-1" role="presentation">
                            <a class="nav-link active" id="pills-address-tab" data-toggle="pill" href="#pills-address" role="tab" aria-controls="pills-address" aria-selected="true">
                                Address
                            </a>
                        </li>
                        <li class="nav-item mb-1 mr-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                                    Basic Details
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light"> Basic Details</a>
                            <?php endif ?>

                        </li>
                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-main-photo-tab" data-toggle="pill" href="#pills-main-photo" role="tab">
                                    Main Photo
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Main Photo</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab">Gallery</a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Gallery</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-video-tab" data-toggle="pill" href="#pills-video" role="tab">
                                    Video
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Video</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-3d-tab" data-toggle="pill" href="#pills-3d" role="tab">
                                    Virtual Tour
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Virtual Tour</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-floor-tab" data-toggle="pill" href="#pills-floor" role="tab">
                                    Floor Plan
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Floor Plan</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-agents-tab" data-toggle="pill" href="#pills-agents" role="tab">
                                    Profiles
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">
                                    Profiles
                                </a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1 mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-logo-tab" data-toggle="pill" href="#pills-logo" role="tab">
                                    Logo
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">
                                    Logo
                                </a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mr-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-points-tab" data-toggle="pill" href="#pills-points" role="tab">
                                    Key Points
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light"> Key Points</a>
                            <?php endif ?>

                        </li>

                        <li class="nav-item mb-1" role="presentation">

                            <?php if (isset($_GET['id'])) : ?>
                                <a class="nav-link" id="pills-attributes-tab" data-toggle="pill" href="#pills-attributes" role="tab">
                                    Features
                                </a>
                            <?php endif ?>

                            <?php if (!isset($_GET['id'])) : ?>
                                <a class="nav-link bg-light">Features</a>
                            <?php endif ?>

                        </li>

                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <?php include './_manager_partial/_address.php'; ?>
                        <?php include './_manager_partial/_basic_form.php'; ?>
                        <?php include './_manager_partial/_main_photo.php'; ?>
                        <?php include './_manager_partial/_gallery.php'; ?>
                        <?php include './_manager_partial/_video.php'; ?>
                        <?php include './_manager_partial/_virtual_tour.php'; ?>
                        <?php include './_manager_partial/_floor_plan.php'; ?>
                        <?php include './_manager_partial/_agent.php'; ?>
                        <?php include './_manager_partial/_logo.php'; ?>
                        <?php include './_manager_partial/_points.php'; ?>
                        <?php include './_manager_partial/_features.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/pre_footer.html'; ?>
<?php include '../includes/scripts.html'; ?>

<link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css" />
<link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css" />
<link type="text/css" rel="stylesheet" href="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.css" />

<script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
<script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
<script src="https://unpkg.com/leaflet-draw@0.4.13/dist/leaflet.draw.js"></script>

<script src="/admin_assets/vendor/easy_autocomplete/jquery.easy-autocomplete.min.js"></script>
<link rel="stylesheet" href="/admin_assets/vendor/easy_autocomplete/easy-autocomplete.min.css">
<link rel="stylesheet" href="/admin_assets/vendor/easy_autocomplete/easy-autocomplete.themes.min.css">

<link type="text/css" rel="stylesheet" href="/admin_assets/vendor/dropzone/dropzone.min.css" />
<script src="/admin_assets/vendor/dropzone/dropzone.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

<script src="./_manager_partial/js/_address.js"></script>
<script src="./_manager_partial/js/_basic.js"></script>
<script src="./_manager_partial/js/_gallery.js"></script>
<script src="./_manager_partial/js/_floor_plan.js"></script>
<script src="./_manager_partial/js/_video.js"></script>
<script src="./_manager_partial/js/_features.js"></script>
<script src="./_manager_partial/js/_main_photo.js"></script>
<script src="./_manager_partial/js/_virtual_tour.js"></script>
<script src="./_manager_partial/js/_logo.js"></script>
<script src="./_manager_partial/js/_points.js"></script>
<script src="./_manager_partial/js/_agents.js"></script>

<style>
    .mq-dropdown-menu {
        z-index: 9999 !important;
    }

    .mq-input {
        height: 34px !important;
    }

    .custom .nav-link {
        background: #fff;
        color: #000;
        border-radius: 2px;
        box-shadow: 0 2px 10px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 10%);
        text-align: center;
        font-weight: 500;
        padding: 12px 22px;
        font-size: 13px;
    }

    #backdrop {
        position: absolute;
        background: #0000005e;
        z-index: 999;
        width: 98%;
        height: 100%;
        padding: 50px;
        border-radius: 9px;
        text-align: center;
        display: none;
    }

    #mapBackdrop {
        position: absolute;
        z-index: 1006;
        background: #393737eb;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        padding: 50px 0;
    }
</style>
<script type="text/javascript">
    $.ajaxSetup({
        cache: false
    });

    $(document).ready(function() {
        var ins = new $.AddressManager({});
    });
</script>

<?php include '../includes/footer.html'; ?>