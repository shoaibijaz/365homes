<!-- About-->
<section class="page-section wrap-bg-1">
  <div class="container">

    <?php if (!empty($product['property']['details_short'])) : ?>
      <section id="overviewSec">
        <h2 class="tc-primary text-capitalize text-center mb-5">Overview</h2>
        <div class="row" id="overview">
          <div class="col-md-12">
            <div class="tour-description">

              <p><?php echo ($product['property']['details_short']); ?></p>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <div class="row" id="keyPointsList">
    </div>

  </div>
</section>

<script type="text/x-handlebars-template" id='keyPointItemTemplate'>
  <div class="col-md-6 key-point">
      <p> {{key_point}}</p>
    </div>
  </script>