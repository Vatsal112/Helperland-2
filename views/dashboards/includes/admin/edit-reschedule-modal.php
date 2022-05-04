<!-- Model For Edit and Reschedule Service -->
<div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Edit Service Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-reschedule" action="<?= Config::BASE_URL . "?controller=ADashboard&function=EditServiceDetailes" ?>" method="POST">
                    <input type="hidden" name="serviceid" id="er-servid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <div class="div-date">
                                    <img src="static/images/admin-calendar.png" alt="">
                                    <input type="text" class="form-control" name="date" id="er-date" placeholder="dd/mm/yyyy" title="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group selecttime">
                                <label for="Time">Time</label>
                                <select name="time" class="form-select" id="er-time">
                                    <option value="8">8:00</option>
                                    <option value="8.5">8:30</option>
                                    <option value="9">9:00</option>
                                    <option value="9.5">9:30</option>
                                    <option value="10">10:00</option>
                                    <option value="10.5">10:30</option>
                                    <option value="11">11:00</option>
                                    <option value="11.5">11:30</option>
                                    <option value="12">12:00</option>
                                    <option value="12.5">12:30</option>
                                    <option value="13">13:00</option>
                                    <option value="13.5">13:30</option>
                                    <option value="14">14:00</option>
                                    <option value="14.5">14:30</option>
                                    <option value="15">15:00</option>
                                    <option value="15.5">15:30</option>
                                    <option value="16">16:00</option>
                                    <option value="16.5">16:30</option>
                                    <option value="17">17:00</option>
                                    <option value="17.5">17:30</option>
                                    <option value="18">18:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="divtitle">Service Address</div>
                    <input type="hidden" name="mobile" id="er-mobile">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="streetname">Street name</label>
                                <input type="text" name="streetname" class="form-control" id="er-street">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="housenumber">House number</label>
                                <input type="text" name="housenumber" class="form-control" id="er-house">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postalcode">Postal Code</label>
                                <input type="text" class="form-control" name="postalcode" id="er-postalcode">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select id="er-city" class="form-control">
                                    <option value="rajkot">Rajkot</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="divtitle">Invoice Address</div>
                    <div class="row">
                        <div class="col-md-6"><kbd>Same As a Service Address</kbd></div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="streetname">Street name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="housenumber">House number</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postalcode">Postal Code</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="" id="" class="form-control">
                                    <option value="rajkot">Rajkot</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <br>
                    <div class="divtitle">Why do you want to rechedule service requests?</div>
                    <div class="row">
                        <div class="col">
                            <textarea name="comment" id="er-comment" rows="3" class="form-control" placeholder="why do you want to rechedule service requests?"></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="divtitle">Call Center EMP notes</div>
                    <div class="row">
                        <div class="col">
                            <textarea name="" id="" rows="3" class="form-control" placeholder="Enter Notes?" disabled></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-modal form-control" id="btn-editandreschedule">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->