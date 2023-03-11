<div class="tab-pane fade" id="pills-points" role="tabpanel" aria-labelledby="pills-points-tab">
    <div class="card border-0 shadow">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <div class="w-100 text-right">
                <a href="javascript:;" class="btn btn-sm btn-info link-add-new-pt">
                    <i class="fa fas fa-plus"></i> ADD NEW
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="keyPointsList"></div>
        </div>
    </div>
</div>

<div id="keyPointsModal" class="modal" tabindex="-1" role="dialog">
</div>

<script type="text/x-handlebars-template" id='keyPointFormTemplate'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Key Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/api/app_properties_key_points/save.php" method="post" id="fmKeyPoints">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 shadow">
                                <div class="card-body">

                                    <input type="hidden" name="id" value="{{id}}">
                                    <input type="hidden" name="sort_order" value="{{sort_order}}">
                                    <input type="hidden" name="property_id" value="<?php echo ($_GET['id']) ?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="i1">Enter Details</label>
                                                <textarea name="key_point" value="{{key_point}}" rows="3" class="form-control form-control-sm">
                                                {{key_point}}    
                                            </textarea>

                                                <small>You can enter max 200 characters.</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSaveKeyPoint">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</script>

<script type="text/x-handlebars-template" id='keyPointListItemTemplate'>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                {{key_point}}
            </div>
            <div class="card-footer">
                <a href="javascript:;" class="btn btn-sm btn-info link-edit-pt" data-id="{{id}}">
                <i class="fa fa-pen"></i>       
                Edit</a>
                <a href="javascript:;" class="btn btn-sm btn-danger link-delete-pt" data-id="{{id}}">
                <i class="fa fa-times"></i>        Delete</a>
            </div>
        </div>
    </div>
</script>