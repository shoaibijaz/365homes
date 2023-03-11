<div class="tab-pane fade" id="pills-3d" role="tabpanel" aria-labelledby="pills-3d-tab">
    <div class="shadow p-2 mb-2">
    <form action="/api/app_property_tours/save.php" method="post" id="fmTour">

        <input type="hidden" name="property_id" value="<?php echo ($_GET['id']) ?>">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="sort_order" value="0">

        <div class="row mb-3">
            <div class="col-md-10">
                <input type="text" class="form-control form-control-sm" name="tour_link" placeholder="Virtual Tour URL">
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-sm" type="button" id="btnSaveTour">
                    <i class="far fa-save"></i>
                    Save Virtual Tour</button>
            </div>
        </div>

    </form>
    </div>
    <div class="card border-0 shadow mb-3">
        <div class="card-body">

            <div id="toursList">
            </div>

        </div>
    </div>

</div>

<script type="text/x-handlebars-template" id='tourItemTemplate'>
    <div class="row mb-2">
        <div class="col-md-10">
            <input type="text" class="form-control form-control-sm" value="{{tour_link}}" readonly>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info btn-sm link-tour-edit" type="button" data-id="{{id}}">
                                <i class="far fa-pen fas"></i>
                                </button>
            <button class="btn btn-danger btn-sm link-tour-delete" type="button" data-id="{{id}}">
                                <i class="fa fa-times"></i>
                                </button>
        </div>
    </div>
</script>