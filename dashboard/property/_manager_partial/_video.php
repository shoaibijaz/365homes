<div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">

    <div class="shadow p-2 mb-2">
        <form action="/api/app_property_videos/save.php" method="post" id="fmVideo">

            <input type="hidden" name="property_id" value="<?php echo ($_GET['id']) ?>">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="sort_order" value="0">

            <div class="row mb-3">
                <div class="col-md-10">
                    <input type="text" class="form-control form-control-sm" name="video_link" placeholder="Video URL">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success btn-sm" type="button" id="btnSaveVideoLink">
                        <i class="far fa-save"></i>
                        Save Video Link</button>
                </div>
            </div>

        </form>
    </div>

    <div class="card border-0 shadow mb-3">
        <div class="card-body">

            <div id="videosList">
            </div>

        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='videoItemTemplate'>
    <div class="row mb-2">
        <div class="col-md-10">
            <input type="text" class="form-control form-control-sm" value="{{video_link}}" readonly>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info btn-sm link-video-edit" type="button" data-id="{{id}}">
                                <i class="far fa-pen fas"></i>
                                </button>
            <button class="btn btn-danger btn-sm link-video-delete" type="button" data-id="{{id}}">
                                <i class="fa fa-times"></i>
                                </button>
        </div>
    </div>
</script>