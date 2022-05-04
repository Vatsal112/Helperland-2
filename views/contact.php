<?php

$user_id = "";
if (isset($_SESSION["userdata"])) {
   $userdata = $_SESSION["userdata"];
   $user_id = $userdata["UserTypeId"];
}
$isSuccess = "";
if (isset($_COOKIE["contact_success"])) {
    setcookie("contact_success", "", time() - 3600, '/');
    $isSuccess = "success";
?>

<?php
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/footer.css">
    <link rel="stylesheet" href="static/css/header1.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/contact.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Contact Us</title>
</head>

<body>

    <?php
    include("includes/login-modal.php");
    include("includes/forgotpsw-modal.php");
    include("includes/header.php")
    ?>

    <div id="main">
        <div class="header-image"></div>

        <section id="section-contactus">
            <div class="contactus-services">
                <h1>Contact Us</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
                <div class="contact-list row">
                    <div class="c-list col-xl-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/location-pin.png">
                        </div>
                        <div class="c-title">
                            <p>1111 Lorem ipsum text 100,<br> Lorem ipsum AB</p>
                        </div>
                    </div>
                    <div class="c-list col-xl-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/phone-call.png" alt="">
                        </div>
                        <div class="c-title">
                            <p>+49 (40) 123 56 7890<br>+49 (40) 987 56 0000</p>
                        </div>
                    </div>
                    <div class="c-list col-xl-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/email.png" alt="">
                        </div>
                        <div class="c-title">
                            <p>info@helperland.com</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <hr class="hr-sepretor">

        <section id="section-contactform" class="contact-form">
            <div class="form-title">
                <h1>Get in touch with us</h1>
            </div>
            <div class="c-form">
                <form action="<?=$base_url.'?controller=ContactUs&function=insertContactForm'?>" method="post" enctype="multipart/form-data">
                    <?php
                        if(!empty($user_id)){
                            ?>
                            <input type="hidden" name="UserId" value="<?=$user_id?>">
                            <?php
                        }
                    ?>
                    <div class="modal-body">
                        <?php
                        if (!empty($isSuccess)) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Your query has been submitted successfully. Our helpdesk team will contact you soon!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                <input class="form-control" id="firstname" name="FirstName" placeholder="Firstname" type="text" required autofocus />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                <input class="form-control" id="lastname" name="LastName" placeholder="Lastname" type="text" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+49</div>
                                    </div>
                                    <input type="number" class="form-control" name="Mobile" id="phonenumber" placeholder="Mobile number">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                <input class="form-control" id="email" name="Email" placeholder="Email address" type="email" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                                <div class="form-group">
                                    <select id="inputState" id="subject" name="Subject" class="form-control">
                                        <option value="general">General</option>
                                        <option value="inquiry">Inquiry</option>
                                        <option value="renewal">Renewal</option>
                                        <option value="revocation">Revocation</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <textarea style="resize:vertical;" id="message" class="form-control" name="Message" placeholder="Message..." rows="3" name="comment" required></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group">
                                <label for="fileupload">Attachment</label>
                                <input type="file" name="Attachment" id="attachment" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="Policy" id="policy" value="policy">
                                <label class="form-check-label" for="policy" id="policylabel">
                                    I hearby agree that my data entered into the contact form will be store electronically
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="submit-btn">
                        <button type="submit" name="contactus" id="contactus" value="contactus" onclick="showLoader()">Submit</button>
                    </div>
                </form>
            </div>
        </section>

    </div>

    <section id="section-map">
        <iframe allowfullscreen="" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJxzZgCD_hvkcRTC-2Pt6bXt0&amp;key=AIzaSyAag-Mf1I5xbhdVHiJmgvBsPfw7mCqwBKU"></iframe>
    </section>

    <?php include("includes/footer.php") ?>

    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
    <script src="static/js/validation.js"></script>
    <script>
        $(document).ready(function() {

            //remove sticky class
            if (window.scrollY > 30) {
                $(".navbar").removeClass("sticky");
            }
            $(window).scroll(function() {
                if (this.scrollY > 30) {
                    $(".navbar").removeClass("sticky");
                }
            });
        });
    </script>

</body>

</html>