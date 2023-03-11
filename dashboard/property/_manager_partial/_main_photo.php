<div class="tab-pane fade" id="pills-main-photo" role="tabpanel" aria-labelledby="pills-main-photo-tab">
    <div class="card border-0 shadow">
        <div class="card-body">

            <form action="/api/upload_images.php" method="post" enctype="multipart/form-data" id="fmPhoto">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="fuPhoto">
                            <label class="custom-file-label" for="customFile1">Choose Photo</label>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-md-8">

                        <div class="card border-0 shadow">
                            <div class="card-header text-right">
                                <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMainPhoto">
                                <i class="fa fa-times"></i>    
                                Delete Photo</button>
                            </div>
                            <div class="card-body">
                                <img src="" alt="" class="img-fluid">
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

</div>