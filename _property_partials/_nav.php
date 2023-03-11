<nav class="navbar navbar-expand-lg navbar-dark fixed-top-absolute py-3" id="mainNav">
    <div class="container-fluid px-4 px-lg-5">
        <?php if (!empty($product['property']['logo'])) : ?>
            <a class="navbar-brand d-none" href="#" id="logoPanel">
                <img src="<?php echo ($product['property']['logo']); ?>" alt="">
            </a>
        <?php endif; ?>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav <?php if (isset($product['property']['logo'])) echo ('ms-auto');
                                    else echo ("m-auto") ?> my-2 my-lg-0">

                <?php if (!empty($product['property']['details_short'])) : ?>
                    <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#overviewSec">Overview</a></li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#gallery">Photos</a></li>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#video">Video</a></li>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#video">Virtual Tour</a></li>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#floor_plan"> Floor Plan</a></li>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#locationArea">Location</a></li>

                <li class="nav-item"><a class="nav-link link-scroll" href="javascript:;" data-href="#contactSection">Contact</a></li>

            </ul>
        </div>
    </div>
</nav>