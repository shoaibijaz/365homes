<header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center mt-3">
            <div class="col-lg-8">
                <h1 class="text-white font-weight-bold">
                    <?php echo ($product['property']['address']); ?>
                </h1>
                <hr class="divider" />
            </div>
            <div class="col-lg-8 ">
                <p class="text-white-75 mb-5"><?php echo ($product['property']['title']); ?></p>
                <a class="btn btn-primary btn-xl link-scroll" href="javascript:;" data-href="#contactSection">REQUEST VIEWING</a>
            </div>

            <div class="col-lg-12" id="headerSec">
                <div class="infobox">
                    <div class="content-fixed container">
                        <div class="d-sm-flex flex-wrap justify-content-center" id="featuresList">

                            <?php if (!empty($product['property']['price']) && $product['property']['price'] > 0) : ?>
                                <div class=" item">
                                    <span class="text-uppercase tc-white">price</span>
                                    <p class="tc-primary">$
                                        <label class="price-ft"> <?php echo ($product['property']['price']); ?></label>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($product['property']['property_type'])) : ?>
                                <div class=" item">
                                    <span class="text-uppercase tc-white">Type</span>
                                    <p class="tc-primary">
                                        <label> <?php echo ($product['property']['property_type']); ?></label>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script type="text/x-handlebars-template" id='featureItemTemplate'>
    <div class="item">
                <span class="text-uppercase tc-white">
                {{title}}</span>
                <p class="tc-primary">{{value}}</p>
    </div>
</script>