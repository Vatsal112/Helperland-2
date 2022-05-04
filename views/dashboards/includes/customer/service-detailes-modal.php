<!-- Model For Service Reschedule & Cancel -->
<div class="modal fade" id="exampleModalServiceDetailes" tabindex="-1" aria-labelledby="exampleModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-7 modal-section-body">
                                <div class="row">
                                    <p class="m-head">Service Details</p>
                                    <p class="m-time"></p>
                                    <p>Duration: <span class='total-duration'></span> Hrs </p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="m-head">Service Id: <span class="sid"></span>.</p>
                                    <p>Extras: <span class='extraslist'></p>
                                    <p>Total Payment: <span class="m-currency"></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <!-- <p class="m-head">Customer Name: Gaurang Patel.</p> -->
                                    <p>Service Address: <span class='saddress'></span></p>
                                    <p>Billing Address: Same as cleaning address</p>
                                    <p>Phone: +49 <span class="smobile"></span></p>
                                    <p class="semail"></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="m-head">Comments</p>
                                    <p class="haspets"><span class="fa fa-times-circle-o"></span> I dont't have pets at home</p>
                                </div>
                                <hr>
                                <div class="row modal-button">
                                    <div class="col">
                                        <button class="modal-button-complete sreschedule" data-bs-toggle="modal" data-bs-target="#exampleModalServiceReschedule" data-bs-dismiss="modal">Reschedule</button>
                                        <button class="modal-button-cancel scancel" data-bs-toggle="modal" data-bs-target="#exampleModalServiceCancel" data-bs-dismiss="modal">Cancel</button>    
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Model -->