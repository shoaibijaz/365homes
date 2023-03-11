<section class="page-section" id="floor_plan">
  <div class="container">
    <h2 class="tc-primary text-capitalize text-center mb-1">Floor Plan</h2>
    <div class="text-center"><span class="text-muted small">Click to enlarge image</span></div>
    
    <div class="row mt-5" id="floorPlanList">
  
    </div>
  </div>
</section>

<script type="text/x-handlebars-template" id='flooPlanItemTemplate' title="Click to enlarge image">
    <div class="col-lg-3 col-md-4 col-6 {{cls}} fp-item" index="{{counter}}">
      <a href="{{image}}" data-fancybox="gallery" class="d-block mb-4 h-100">
      {{# if image_thumb}}    
            <img src="{{image_thumb}}" class="img-fluid" title="Click to enlarge image">
            {{else}}
            <img src="{{image}}" class="img-fluid" title="Click to enlarge image">
            {{/if}}
      </a>
      </div>
  </script>