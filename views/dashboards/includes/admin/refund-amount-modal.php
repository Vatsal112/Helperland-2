<!-- Model For Refund Amount -->
<div class="modal fade" id="exampleModalRedund" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Refund Amount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=Config::BASE_URL."?controller=ADashboard&function=RefundAmount"?>" id="form-refund" method="POST">
                    <input type="hidden" name="re-servid" id="refund_serv_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    Paid Amount<br>
                                    <span class="paid-amt">54.00</span>€
                                </div>
                                <div class="col-6">
                                    Refunded Amount<br>
                                    <span class="refunded-amt">0.00</span>€
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            In Balance Amount<br>
                            <span class="inbalance-amt">54.00</span>€
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="re-amount" class="form-control calculate-amount" aria-label="Text input with dropdown button">
                                    <select name="method" name="re-method" id="select-method">
                                        <option value="0" selected>Percentage</option>
                                        <option value="1">Euro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Calculate (In €)</label>
                                <input type="text" name="re-total" class="form-control" id="calculated-amt" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="divtitle">Why you want to refund amount?</div>
                    <div class="row">
                        <div class="col">
                            <textarea name="re-comment" rows="3" class="form-control refund-comment" placeholder="Why you want to refund amount?"></textarea>
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
                            <button class="btn btn-modal form-control" name="refund" id="btn_refund">Refund</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->