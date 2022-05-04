<?php
if (isset($_SESSION["userdata"])) {
    $userdata = $_SESSION["userdata"];
    if ($userdata["UserTypeId"] == 2 || $userdata["UserTypeId"] == 3) {
        $_SESSION["error"] = array($userdata["Email"], "Only customers can access this part of the system");
        unset($_SESSION["userdata"]);
        header("Location: " . Config::BASE_URL . '?controller=default&function=homepage&parameter=loginmodal');
    }
} else {
    $_SESSION["redirect_url"] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . Config::BASE_URL . '?controller=default&function=homepage&parameter=loginmodal');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/header1.css">
    <link rel="stylesheet" href="static/css/footer.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/booknow.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Book Now | Helperland</title>
</head>

<body>

    <?php
    include("includes/payment-summary.php");
    include("includes/header.php")
    ?>

<div class="modal fade" id="servicerequest" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="success-icon">
                    <div class="img-wrapper">
                        <img src="static/images/correct-white-medium.png" alt="">
                    </div>
                </div>
                <div class="success-msg">
                    You have successfully logged out
                </div>
            </div>
            <div class="modal-footer" style="padding-top: 0;">
                <button data-bs-dismiss="modal" onclick="window.location = ' <?= (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : Config::BASE_URL.'controller=Default&function=Homepage' ?>'">Ok</button>
                <?php unset($_SESSION["redirect_url"])?>
            </div>
        </div>
    </div>
</div>

    <div id="main">
        <div class="header-image"></div>
        <section id="section-bookservice">
            <div class="book-header">
                <h1>Set up your cleaning service</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
            </div>
            <div class="custome-container">
                <div class="row book">
                    <div class="col-8 book-main">
                        <div class="book-steps nav nav-tabs" id="nav-tab" role="tablist">
                            <div class="bookstep-setup nav-link active" id="nav-setup-tab" data-bs-toggle="tab" data-bs-target="#nav-setup" type="button" role="tab" aria-controls="nav-setup" aria-selected="true">
                                <div class="img-crop">
                                    <img src="static/images/setup-service.png" alt="">
                                </div>
                                <div>Setup Service</div>
                            </div>
                            <div class="bookstep-schedule nav-link" id="nav-schedule-tab" data-bs-toggle="tab" data-bs-target="#nav-schedule" type="button" role="tab" aria-controls="nav-schedule" aria-selected="false">
                                <div class="img-crop">
                                    <img src="static/images/schedule-plan.png" alt="">
                                </div>
                                <div>Schedule & Plan</div>
                            </div>
                            <div class="bookstep-detailes nav-link" id="nav-detailes-tab" data-bs-toggle="tab" data-bs-target="#nav-detailes" type="button" role="tab" aria-controls="nav-detailes" aria-selected="false">
                                <div class="img-crop">
                                    <img src="static/images/user-details.png" alt="">
                                </div>
                                <div>Your Detailes</div>
                            </div>
                            <div class="bookstep-payment nav-link" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment" type="button" role="tab" aria-controls="nav-payment" aria-selected="false">
                                <div class="img-crop">
                                    <img src="static/images/make-payment.png" alt="">
                                </div>
                                <div>Make Payment</div>
                            </div>
                        </div>
                        <div class="book-forms tab-content" id="nav-tabContent">
                            <div class="form-setup tab-pane show active" id="nav-setup" role="tabpanel" aria-labelledby="nav-setup-tab">
                                <form action="<?= Config::BASE_URL . "?controller=BookNow&function=CheckPostalCode" ?>" id="form-setup" method="POST" onsubmit="return false;">
                                    <div class="form-group">
                                        <label for="postalcode">Enter your Postal Code</label>
                                        <div class="d-flex" style="height: 46px;">
                                            <input type="text" name="postalcode" id="postalcode" class="form-control">
                                            <button class="form-submit" id="step1_submit" onClick="showLoader()">Check Availablity</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-schedule tab-pane" id="nav-schedule" role="tabpanel" aria-labelledby="nav-schedule-tab">
                                <form id="scheduleform">
                                    <div class="row schedule-timing">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="timing">When do you need the cleaner?</label>
                                                <div class="d-flex">
                                                    <input type="date" id="service-date" name="cleaningstartdate" class="form-control">
                                                    <select name="cleaningstarttime" id="service-time" class="form-select">
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
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="timing">How long do you need your cleaner to stay?</label>
                                                <select name="cleaningworkinghour" id="service-hour" class="form-select">
                                                    <option value="3">3.0 Hrs</option>
                                                    <option value="3.5">3.5 Hrs</option>
                                                    <option value="4">4.0 Hrs</option>
                                                    <option value="4.5">4.5 Hrs</option>
                                                    <option value="5">5.0 Hrs</option>
                                                    <option value="5.5">5.5 Hrs</option>
                                                    <option value="6">6.0 Hrs</option>
                                                    <option value="6.5">6.5 Hrs</option>
                                                    <option value="7">7.0 Hrs</option>
                                                    <option value="7.5">7.5 Hrs</option>
                                                    <option value="8">8.0 Hrs</option>
                                                    <option value="8.5">8.5 Hrs</option>
                                                    <option value="9">9.0 Hrs</option>
                                                    <option value="9.5">9.5 Hrs</option>
                                                    <option value="10">10.0 Hrs</option>
                                                    <option value="10.5">10.5 Hrs</option>
                                                    <option value="11">11.0 Hrs</option>
                                                    <option value="11.5">11.5 Hrs</option>
                                                    <option value="12">12.0 Hrs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="schedule-extra">
                                        <div class="schedule-title">
                                            Extra Services
                                        </div>
                                        <div class="extra-div" id="extra-div">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check-cabinet" name="extra[]" value="1">
                                                <label for="check-cabinet" class="form-check-label">
                                                    <div class="extra-round">
                                                        <img src="static/images/cabinet.png" alt="">
                                                    </div>
                                                    <div class="extra-title" id="cabinet">Inside cabinet</div>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check-fridge" name="extra[]" value="2">
                                                <label for="check-fridge" class="form-check-label">
                                                    <div class="extra-round">
                                                        <img src="static/images/freeze.png" alt="">
                                                    </div>
                                                    <div class="extra-title " id="fridge">Inside fridge</div>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check-oven" name="extra[]" value="3">
                                                <label for="check-oven" class="form-check-label">
                                                    <div class="extra-round">
                                                        <img src="./static/images/oven.png" alt="">
                                                    </div>
                                                    <div class="extra-title " id="oven">Inside Oven</div>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check-wash" name="extra[]" value="4">
                                                <label for="check-wash" class="form-check-label">
                                                    <div class="extra-round">
                                                        <img src="static/images/washing-machine.png" alt="">
                                                    </div>
                                                    <div class="extra-title " id="laundry">Laundry wash & dry</div>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="check-window" name="extra[]" value="5">
                                                <label for="check-window" class="form-check-label">
                                                    <div class="extra-round">
                                                        <img src="static/images/window.png" alt="">
                                                    </div>
                                                    <div class="extra-title " id="windows">Interior windows</div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row schedule-comment">
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <textarea name="comments" id="comments" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="workswithpet" id="petathome" value="1">
                                            <label class="form-check-label" for="petathome">
                                                I have a pets at home
                                            </label>
                                        </div>
                                    </div>
                                    <div class="schedule-submit">
                                        <button class="form-submit" id="step2_submit" onClick="showLoader()">Continue</button>
                                    </div>
                                </form>
                            </div>
                            <div class="form-detailes tab-pane" id="nav-detailes" role="tabpanel" aria-labelledby="nav-detailes-tab">

                                <div class="detailes-title">
                                    Enter your contact details, so we can serve you in better way!
                                </div>
                                <div class="detailes-address" id="detailes-address">

                                </div>
                                <div class="detailes-new-address">
                                    <div class="new-address-button">
                                        <button type="button" data-bs-toggle="collapse" data-bs-target="#new-address" aria-expanded="false" aria-controls="new-address"><i class="fa fa-plus"></i> Add New Address</button>
                                    </div>
                                    <div class="collapse" id="new-address">
                                        <div class="card card-body">
                                            <form action="<?= Config::BASE_URL . "?controller=BookNow&function=addNewAddress" ?>" id="addform">
                                                <div class="row">
                                                    <input type="hidden" name="postalcode" class="pstlcode">
                                                    <input type="hidden" name="cityname" class="cityname">
                                                    <input type="hidden" name="statename" class="statename">

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="streetname">Street name</label>
                                                            <input type="text" name="streetname" id="streetname" class="form-control" placeholder="street name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="House number">House number</label>
                                                            <input type="text" name="housenumber" id="housenumber" class="form-control" placeholder="street name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Postal code">Postal code</label>
                                                            <input type="text" class="form-control pstlcode" placeholder="postal code" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="City Name">City</label>
                                                            <input type="text" class="form-control cityname" placeholder="city name" disabled>
                                                            <!-- <label for="city">City</label>
                                                            <select class="form-select mb-3" id="cities">
                                                                <option selected>Troisdrof</option>
                                                            </select> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group mb-3">
                                                            <label for="phone number">Phone number</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1">+49</span>
                                                                <input type="text" class="form-control" name="phonenumber" id="phonenumber" placeholder="phone number" aria-describedby="basic-addon1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-address-buttons">
                                                    <button class="btn-save" id="savenewaddress" name="saveaddress" type="submit" value="saveaddress" onClick="showLoader()">Save</button>
                                                    <p class="btn-cancel" id="cancelnewaddress" data-bs-toggle="collapse" data-bs-target="#new-address">Cancel</p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="fav-service-provicer">
                                    <div class="fav-title">Your Favorite Service Provider</div>
                                    <div class="fav-subtitle">You can choose your favorite service provider from the below list</div>
                                    <div class="fav-sp-list" id="fav-sp-list">

                                    </div>
                                </div>
                                <div class="schedule-submit">
                                    <button class="form-submit" id="step3_submit" onClick="showLoader()">Continue</button>
                                </div>
                            </div>
                            <div class="form-payment tab-pane" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                            <form action="<?= Config::BASE_URL . "?controller=BookNow&function=insertServiceRequest" ?>" id='paymentform'>
                                <div class=" payment-title">
                                    Pay securely with Helperland payment gateway!
                                </div>
                                <div class="form-group promocode">
                                    <label for="promocode">Promo code (optional)</label>
                                    <div>
                                        <input type="text" placeholder="Promo code (optional)" disabled>
                                        <button>Apply</button>
                                    </div>
                                </div>
                                <div class="payment-card">
                                    <div class="card-number">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <input type="text" id="cnumber" placeholder="Card number" disabled>
                                    </div>
                                    <div class="card-detailes">
                                        <div>
                                            <input type="text" placeholder="MM/YY" id="cmonth" disabled>
                                        </div>
                                        <div>
                                            <input type="text" placeholder="CVC" id="ccvc" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="accept-policy">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="booknowpolicy">
                                        <label class="form-check-label" for="booknowpolicy">
                                            I accepted <a href='#'>terms and conditions</a>, the <a href="#">cancellation policy</a> and the <a href="#">privacy policy</a>. I confirm that Helperland starts to execute the contract before the expiry of the withdrawal period and I lose my right of withdrawal as a consumer with full performance of the contract.
                                        </label>
                                    </div>
                                </div>
                                <div class="schedule-submit">
                                    <button class="form-submit" id="step4_submit" type="submit" onClick="showLoader()">Complete Booking</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="book-quetions wizard">
                        <div class="quetions-title">
                            Quetions?
                        </div>
                        <div class="accordion" id="accordionExample1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        What's included in a cleaning?

                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        Bedroom, Living Room & Common Areas,Bathrooms,Kitchen,Extras
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Which Helperland professional will come to my place?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        Helperland has a vast network of experienced, top-rated cleaners. Based on the time and date of your request, we work to assign the best professional available.Like working with a specific pro? Add them to your Pro Team from the mobile app and they'll be requested first for all future bookings.You will receive an email with details about your professional prior to your appointment.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Can I skip or reschedule bookings?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit the value of the booking to your account. You can use this credit on future cleanings and other Helperland services.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="for-more">
                            <a href="<?=Config::BASE_URL."?controller=Default&function=faqs"?>">For more help</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 side-payment-bar">
                    <div class="book-payment">
                        <div class="payment-header">
                            Payment Summary
                        </div>
                        <div class="payment-service-detailes">
                            <div class="payment-duration">
                                <span class="duration-date"></span>
                                <span class="duration-time"></span>
                                <div class="d-title">Duration</div>
                                <div class="duration-basic">
                                    <div class="title">Basic</div>
                                    <div class="total">0 Hrs</div>
                                </div>
                            </div>
                            <div class="payment-extras">
                                <div class="extras-title">Extras</div>

                            </div>
                            <div class="total-service-time">
                                <div class="title">Total Service Time</div>
                                <div class="total">3 Hrs</div>
                            </div>
                        </div>
                        <div class="per-cleaning">
                            <div class="title">Per Cleaning</div>
                            <div class="total">0,00 €</div>
                        </div>
                        <div class="total-payment">
                            <div class="title">Total Payment</div>
                            <div class="total">0,00 €</div>
                        </div>
                        <div class="always-included">
                            <img src="static/images/smiley.png" alt="">
                            <span>See what is always included</span>
                        </div>
                    </div>
                    <div class="book-quetions nwizard">
                        <div class="quetions-title">
                            Quetions?
                        </div>
                        <div class="accordion" id="accordionExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        What's included in a cleaning?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        Bedroom, Living Room & Common Areas,Bathrooms,Kitchen,Extras
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Which Helperland professional will come to my place?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        Helperland has a vast network of experienced, top-rated cleaners. Based on the time and date of your request, we work to assign the best professional available.Like working with a specific pro? Add them to your Pro Team from the mobile app and they'll be requested first for all future bookings.You will receive an email with details about your professional prior to your appointment.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Can I skip or reschedule bookings?

                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit the value of the booking to your account. You can use this credit on future cleanings and other Helperland services.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="for-more">
                            <a href="<?=Config::BASE_URL."?controller=Default&function=faqs"?>">For more help</a>
                        </div>
                    </div>
                </div>
                <div class="payment-summary-button" data-bs-toggle="modal" data-bs-target="#examplePaymentSummary" data-bs-dismiss="modal">
                    Payment Summary
                </div>
            </div>
    </div>
    </section>

    </div>

    <?php include("includes/footer.php") ?>

    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
    <script src="static/js/booknow.js"></script>
</body>

</html>