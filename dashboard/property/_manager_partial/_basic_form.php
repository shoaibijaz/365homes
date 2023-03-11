<div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <form action="/api/app_properties/save_basic.php" method="post" id="fmBasic">
        <input type="hidden" name="id" value="">
        
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i4">Property Type*</label>
                                    <select name="property_type" class="form-control form-control-sm">
                                        <option value="">Select Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="i4">Transaction Type*</label>
                                    <select name="transaction_type" class="form-control form-control-sm">
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="priceBox">
                                <div class="form-group">
                                    <label for="i3">Price</label>
                                    <input type="number" min="0" class="form-control form-control-sm" name="price">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        <div class="col-md-10">
                                <div class="form-group">
                                    <label for="i1">Subtitle</label>
                                    <input type="text" name="title" class="form-control form-control-sm" autocomplete="on">
                                </div>
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="i5">Property description</label>
                                    <textarea name="details_short" rows="4" class="form-control">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" type="button" id="btnBasicInfo">
                            <i class="far fa-save"></i>
                            Save Basic Details</button>
                    </div>
                </div>
            </div>
           
        </div>
    </form>
</div>