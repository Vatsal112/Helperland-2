<!-- Model For Service Reschedule -->
<div class="modal fade" id="exampleModalServiceReschedule" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Reschedule Service Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-reschedule" action="<?= Config::BASE_URL . "?controller=CDashboard&function=UpdateServiceSchedule" ?>" method="POST">
                    <input type='hidden' name='serviceid' class="reschedule_sid">
                    <div class="mb-3 form-group">
                        <label for="">Select New Date & Time</label>
                        <div class="row">
                            <div class="col">
                                <input type="date" class="form-control" name="date">
                            </div>
                            <div class="col">
                                <select name="time" class="form-select">
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
                    <button class="submit-button mb-3" type="submit" name="reschedule" id="reschedule_update">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->