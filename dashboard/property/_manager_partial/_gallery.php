<div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
    <div class="card border-0 shadow">
        <div class="card-body">
            <div>
                <p class="text-muted small">
                    File types supported: (JPEG, JPG, PNG, GIF, WebP)
                </p>
            </div>
            <form action="/api/upload_multi_images.php" class="dropzone" id="galleryDropZone"></form>

            <form class="d-none" action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmGallery">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="fuGallery">
                            <label class="custom-file-label" for="customFile1">Choose Image</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="progress mt-2">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mt-3" id="galleryList">
            </div>
        </div>
    </div>

</div>

<script type="text/x-handlebars-template" id='galleryItemTemplate'>
    <div class="col-md-3 mb-2 gallery-item" id="{{id}}">
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