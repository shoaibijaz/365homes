<section id="gallery">

    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="tc-primary text-capitalize text-center mb-5">Gallery</h2>
                <div class="row text-center text-lg-left mb-4" id="images">
                </div>

                <div class="text-center text-lg-left mb-4">
                    <a href="javascript:;" class="btn btn-lg btn-danger bg-theme-orange d-none" id="btnShowMoreImages">Show More</a>
                </div>
            </div>
        </div>
    </div>

</section>

<script type="text/x-handlebars-template" id='galleryItemTemplate'>
    <div class="col-lg-3 col-md-4 col-6 {{cls}} gallery-item" index="{{counter}}">
      <a href="{{image}}" data-fancybox="gallery" class="d-block mb-4 h-100">
      {{# if image_thumb}}    
            <img src="{{image_thumb}}" class="img-fluid">
            {{else}}
            <img src="{{image}}" class="img-fluid">
            {{/if}}
      </a>
      </div>
  </script>