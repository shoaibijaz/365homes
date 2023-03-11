<div class="tab-pane fade" id="pills-attributes" role="tabpanel" aria-labelledby="pills-attributes-tab">
    <div class="card border-0 shadow">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark">Features</h6>

            <div>
                <a href="javascript:;" class="btn btn-info link-add-new-ft">
                    <i class="fa fas fa-plus"></i> Add Feature
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="tblFeatures">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="featureModal" class="modal" tabindex="-1" role="dialog">
</div>

<script type="text/x-handlebars-template" id='featureFormTemplate'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Feature (I.e. bedroom, garage, etc.)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <form action="/api/app_properties_features/save.php" method="post" id="fmFeatures">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 shadow">
                                <div class="card-body">

                                    <input type="hidden" name="id" value="{{id}}">
                                    <input type="hidden" name="sort_order" value="{{sort_order}}">
                                    <input type="hidden" name="property_id" value="<?php echo ($_GET['id']) ?>">
                                    <input type="hidden" name="image" value="{{image}}">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="i1">Feature name*</label>
                                                <input type="text" name="title" value="{{title}}" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="i2">Value*</label>
                                                <input type="text" name="value" value="{{value}}" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>

                                
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                        
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSaveFeature">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</script>

<script type="text/x-handlebars-template" id='featureListItemTemplate'>
    <tr id="{{id}}">
      
       
        <td>
            {{title}}
        </td>

        <td> 
          {{value}}
        </td>
        <td>
            <a href="javascript:;" class="btn btn-sm btn-info link-edit-ft" data-id="{{id}}">
            <i class="fa fa-pen"></i>       Edit</a>
            <a href="javascript:;" class="btn btn-sm btn-danger link-delete-ft" data-id="{{id}}">
            <i class="fa fa-times"></i>       Delete</a>
        </td>
    </tr>
</script>