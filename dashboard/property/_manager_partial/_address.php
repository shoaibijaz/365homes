<div class="tab-pane fade show active" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab">
    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="/api/app_properties/save_address.php" method="post" id="fmAddress">

                <input type="hidden" name="id" value="">
                <input type="hidden" name="sort_order" value="0">
                <input type="hidden" name="map_location" value="">

                <div class="row mb-4">
                    <div class="col">
                        <input type="text" name="address" id="txtAddressSearch" class="form-control fm-control-sm" placeholder="Search Location">
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-sm btn-success" id="btnCreateProperty">
                            <i class="far fa-save"></i> Save & Create Property
                        </button>
                        <button type="button" class="btn btn-sm btn-warning link-clear-location">
                            <i class="fas fa-eraser"></i> Clear Location
                        </button>
                    </div>
                </div>

                <div style="position: relative;">
                    <div id="mapBackdrop">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div id="mapPanel"></div>
                </div>
            </form>
        </div>
    </div>
</div>