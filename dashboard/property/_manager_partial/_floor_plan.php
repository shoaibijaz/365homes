<div class="tab-pane fade" id="pills-floor" role="tabpanel" aria-labelledby="pills-floor-tab">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div>
                <p class="text-muted small">
                   Floor Plan: File types supported: (JPEG, JPG, PNG, GIF, WebP)
                </p>
            </div>
            <form action="/api/upload_multi_images.php" class="dropzone" id="fpDropZone"></form>

            <div class="row mt-3" id="floorPlanList">
            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='floorPlanItemTemplate'>
    <div class="col-md-3 mb-2 fp-item" id="{{id}}">
        <div class="card">
            <div class="card-header">
            <a href="javascript:;" class="btn btn-sm btn-secondary link-view" id="{{id}}">
                    <i class="fa fa-image"></i>
                </a>
                <a href="javascript:;" class="btn btn-sm btn-danger link-delete" id="{{id}}">
                    <i class="fa fa-times"></i>
                </a>

            </div>
            <div class="card-body p-1">
                <a href="javascript:;" class="link-view" id="{{id}}"> 
                {{# if image_thumb}}    
                <img src="{{image_thumb}}" class="img-fluid mt-2">
                {{else}}
                <img src="{{image}}" class="img-fluid mt-2">
                {{/if}}
            </a>
            </div>
        </div>
        
    </div>
</script>