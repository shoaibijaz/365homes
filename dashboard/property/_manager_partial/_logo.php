<div class="tab-pane fade" id="pills-logo" role="tabpanel" aria-labelledby="pills-logo-tab">
    <div class="row">

        <div class="col-md-5">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmLogo">

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="fuLogo">
                            <label class="custom-file-label" for="customFile1">Choose Logo</label>
                        </div>

                        <div class="progress mt-2" style="height:5px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="mt-4" id="logoPanel">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <form id="fmLogoSettings">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white">
                        <h6 class="m-0 font-weight-bold text-dark"> Logo Settings</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="i2">Width</label>
                                    <input type="number" name="width" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="i2">Height</label>
                                    <input type="number" name="height" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3 d-none">
                                <div class="form-group">
                                    <label for="i2">Top</label>
                                    <input type="number" name="top" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3  d-none">
                                <div class="form-group">
                                    <label for="i2">Left</label>
                                    <input type="number" name="left" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right bg-white">
                        <button type="button" class="btn btn-success" id="btnSaveLogoSettings">
                            <i class="far fa-save"></i> Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='logoItemTemplate'>

    <div class="text-center mb-3" style="background: #dddddd;padding: 28px 0;border: 1px solid #c5c5c5;">
    <img src="{{logo}}" class="img-fluid" alt="">
    </div>
    <div class="text-center">
        <a href="javascript:;" class="btn btn-danger btn-sm link-delete-logo">
        <i class="fa fa-times"></i>        Delete
        </a>
    </div>

</script>