
<footer class="footer p-4">
    <div class="social-bar">
        <button type="button" class="btn btn-fb text-white mt-3 btn-social" title="Facebook"> <i class="bi bi-facebook"></i></button>
        <button type="button" class="btn btn-twt text-white mt-3 btn-social" title="Twitter"><i class="bi bi-twitter"></i></button>
        <script src="https://platform.linkedin.com/in.js" type="text/javascript">
            lang: en_US
        </script>
        <script type="IN/Share" data-url="<?php echo ('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"></script>
    </div>

    <div class="container mt-3">

        <div class="small text-center mb-3 ">
            <a href="terms.php" class="m-3 text-muted small"> Terms and Conditions</a>

            <a href="privacy.php" class="text-muted small">Privacy Policy</a>
        </div>

        <div class="small text-center ">
            <a href="https://365homes.net/" class="text-muted text-decoration-none">
                Copyright © 2021 - 365HOMES.net - 365 HOMES Real Estate Websites Design
            </a>
        </div>
    </div>
</footer>

<script type="text/x-handlebars-template" id='locationTemplate'>

    <div class="row">
        <div class="col-md-12">

            <h2 class="tc-primary text-capitalize text-center my-5">Location</h2>

            <div class="map-area" id="mapPanel">
            </div>
        </div>
    </div>

    <div class="row row my-3">
        <div class="col-md-9">
            <h4 class="px-2  py-3 text-muted">{{address}}</h4>
        </div>
        <div class="col-md-3">
            <div class="text-end">
            <a href="http://maps.google.com/maps?daddr={{address}}&f=d" target="_blank" class="btn btn-warning bg-theme-orange text-white mt-2">
            Get directions</a>
            </div>
        </div>
    </div>
</script>