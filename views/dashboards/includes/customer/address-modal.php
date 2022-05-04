<!-- Model For Address Edit -->
<div class="modal fade" id="exampleModalAddress" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel"><span class="add-title"></span> Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=Config::BASE_URL."?controller=Users&function="?>" method="POST" id="form_address">
                    <input type="hidden" name="addid" id="addid">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="">Street name</label>
                                <input type="text" class="form-control" name="streetname" id="add-street">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Hourse number</label>
                                <input type="text" class="form-control" name="housenumber" id="add-house">
                            </div>
                        </div>
                    
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="">Postal Code</label>
                                <input type="number" class="form-control" name="postalcode" id="add-postal">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">City</label>
                                <select type="text" class="form-control" id="add-city">
                        
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+49</div>
                                    </div>
                                    <input type="number" name="mobile" class="form-control" id="add-mobile" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="submit-button mb-3" type="submit" id="btn_address">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->