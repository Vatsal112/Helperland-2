<!--Model For Customer's Rating for Service Provider-->
<!-- <div class="modal fade navbar-tmodel" id="exampleModalRateSP" tabindex="-1" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
         <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="td-rating">
                        <div class="rating-user"><img src="./static/images/icon-cap.png" alt="">
                        </div>
                        <div class="rating-info">
                            <div class="info-name">Lyum Watson</div>
                            <div class="info-ratings">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-o"></span>
                                4
                            </div>
                        </div>
                    </div>

                    <div class="m-heading">
                        Rate Your Service Provider
                    </div>
                    <hr>
                    <div class="m-form">
                        <form action="#">
                            <div class="m-ratings">
                                <p>On Time Arrival</p>
                                <div class="info-ratings">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-o"></span>
                                </div>
                            </div>
                            <div class="m-ratings">
                                <p>Friendy</p>
                                <div class="info-ratings">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-o"></span>
                                </div>
                            </div>
                            <div class="m-ratings">
                                <p>Quality of Service</p>
                                <div class="info-ratings">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-o"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feedback">Feedback on Service Provider</label>
                                <textarea name="" id="" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="m-button">
                                <button>Submit</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div> -->
<!--End Model-->

<!-- rate sp model -->
<div class="modal fade" id="Ratesp" tabindex="-1" aria-labelledby="Ratesp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="td-rating">
                    <div class="rating-user"><img src="./static/images/icon-cap.png" alt="">
                    </div>
                    <div class="rating-info">
                        <div class="info-name">Lyum Watson</div>
                        <div class="info-ratings">
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star-o"></span>
                            4
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="rate-title">Rate your service provider</p>
                <hr>
                <div class="rate">
                    <div class="rate-heading">
                        <p>On time arrival</p>
                        <p>Friendly</p>
                        <p>Quality of service</p>
                    </div>
                    <div>
                        <div class='rating-stars text-center'>
                            <ul id='stars' class="ontimearrival">
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>
                        <div class='rating-stars text-center'>
                            <ul id='stars' class="friendly">
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>
                        <div class='rating-stars text-center'>
                            <ul id='stars' class="quality">
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <form action="<?=Config::BASE_URL."?controller=Users&function=RateServiceProvider"?>" id="form_ratesp">
                    <p class='rating-index' style='display:none;'></p>
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="ratingid" id="ratingid">
                    <label for="Feedback" class="form-label">Feedback on service provider</label>
                    <textarea class="form-control" name="rateing_feed" id="rate_feedback"></textarea>
                    <div class="submit mt-3">
                        <button id="btn_ratesp">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>