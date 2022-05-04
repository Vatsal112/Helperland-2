<?php

if (isset($_SESSION["userdata"])) {
    $userdata = $_SESSION["userdata"];
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
    <link rel="stylesheet" href="static/css/homepage.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Helperland</title>
</head>

<body>
    <?php
    include("includes/login-modal.php");
    include("includes/forgotpsw-modal.php");
    include("includes/logout-modal.php");
    include("includes/header.php");
    ?>

    <div class="main" id="main">

        <section id="section-home">
            <div class="home-content">
                <div class="home-heading">
                    <h1>Do not feel like housework?</h1>
                    <p>Great Book Now for Helperland and enjoy the benefits</p>
                </div>
                <ul class="list">
                    <li><i class="fa fa-check"></i> Certified & insured helper</li>
                    <li><i class="fa fa-check"></i> easy booking procedure</li>
                    <li><i class="fa fa-check"></i> friendly customer service</li>
                    <li><i class="fa fa-check"></i> secure online payment method</li>
                </ul>
            </div>
            <div class="btn-lets">
                <div>
                    <?php if($usertypeid==1 || $usertypeid==""){?><button onclick="window.location = '<?= Config::BASE_URL.'?controller=Default&function=booknow' ?>'" class="btn btn-outline-light text-light">Book a helper!</button><?php }?>
                </div>
            </div>
            <div class="all-steps">
                <div class="step">
                    <div class="step-img">
                        <img src="static/images/step1.png" alt="">
                    </div>
                    <div class="step-text">
                        Enter Postal code
                    </div>
                    <div class="step-arrow">
                        <img src="static/images/step-down-arrow.png" alt="">
                    </div>
                </div>
                <div class="step">
                    <div class="step-img">
                        <img src="static/images/step2.png" alt="">
                    </div>
                    <div class="step-text">
                        Select desired date
                    </div>
                    <div class="step-arrow">
                        <img src="static/images/step-up-arrow.png" alt="">
                    </div>
                </div>
                <div class="step">
                    <div class="step-img">
                        <img src="static/images/step3.png" alt="">
                    </div>
                    <div class="step-text">
                        Secure online payment
                    </div>
                    <div class="step-arrow">
                        <img src="static/images/step-down-arrow.png" alt="">
                    </div>
                </div>
                <div class="step">
                    <div class="step-img">
                        <img src="static/images/step1.png" alt="">
                    </div>
                    <div class="step-text">
                        Feel at home
                    </div>
                </div>
            </div>
            <div class="btn-down">
                <div class="circle">
                    <img src="static/images/shape-1.png" alt="">
                </div>
            </div>
        </section>

        <section id="section-helper">

            <div class="head">
                <h2 class="helper-title">Convince yourself!</h2>
            </div>
            <div class="helpers">
                <div class="helper">
                    <div class="helper-image"><img class="image-rounded" src="static/images/helper1.png" alt=""></div>
                    <div class="helper-title">
                        <h3>Friendly & Certified Helpers</h3>
                    </div>
                    <div class="helper-content">
                        <p>We want you to be completly satisfied with our service and feel comfortable at home. in order to gaurantee this, our helpers go through a test procedure. Only when the cleaners meet our high standards, they may call themselves Helper.</p>
                    </div>
                </div>
                <div class="helper">
                    <div class="helper-image"><img src="static/images/helper2.png" alt=""></div>
                    <div class="helper-title">
                        <h3>Transparent and secure Payment</h3>
                    </div>
                    <div class="helper-content">
                        <p>We have transparent prices, you do not have to scratch money or money on the sideboard Leave it: Pay your helper easily and securly via the online payment method. You will also receive an invoice for each completed cleaning.</p>
                    </div>
                </div>
                <div class="helper">
                    <div class="helper-image"><img src="static/images/helper3.png" alt=""></div>
                    <div class="helper-title">
                        <h3>We're here for you</h3>
                    </div>
                    <div class="helper-content">
                        <p>You have a quetion or need assistance with th booking process? Our customer service is happy to help and advice you.How you car reach us you will find out when you look under "Contact". We look forward to hearing from you or reading.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-blog">

            <div class="sub-lorem row">
                <div class="col-md-12 col-xl-7">
                    <div class="title">
                        <h2 class="heading">We do not know what makes you happy, but ...</h2>
                    </div>
                    <div class="content">
                        <p>
                            If it's not dusting off, our friendly helpers will free you from this burden - do not worry anymore about spending valuable time doing housework, but savor life, you're well worth your time with beautiful experiences. Free yourself and enjoy the gained time: Go celebrate, relax, play with your children, meet friends or dare to jump on the bungee.Other leisure ideas and exclusive events can be found in our blog - guaranteed free from dust and cleaning tips!
                        </p>
                    </div>
                </div>
                <div class="col-md-12 col-xl-5 helper4">
                    <img src="static/images/helper4.png" alt="">
                </div>
            </div>
            <div class="sub-blog">
                <div class="blog-title text-center">
                    <h2>Our Blog</h2>
                </div>
                <div class="helpers">
                    <div class="blog card">
                        <img class="card-img-top" src="static/images/blog1.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                    2019</span></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                                metus pulvinar aliquet.</p>

                            <div class="help-more">Read The Post
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                                    <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="blog card">
                        <img class="card-img-top" src="static/images/blog2.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                    2019</span></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                                metus pulvinar aliquet.</p>

                            <div class="help-more">Read The Post
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                                    <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="blog card">
                        <img class="card-img-top" src="static/images/blog3.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                    2019</span></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                                metus pulvinar aliquet.</p>

                            <div class="help-more">Read The Post
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                                    <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-customer">
            <div class="say-heading">
                <h2>What Our Customers Say</h2>
            </div>
            <div class="says">
                <div class="say">
                    <div class="say-about">
                        <div class="say-profile">
                            <img src="static/images/profile1.png" alt="">
                        </div>
                        <div class="say-name">
                            <div>
                                <h3 class="name">Lary Waston</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="say-msg">
                            <img src="static/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="say-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="say-more">
                        Read More <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                            <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                        </svg>
                    </div>
                </div>
                <div class="say">
                    <div class="say-about">
                        <div class="say-profile">
                            <img src="static/images/profile2.png" alt="">
                        </div>
                        <div class="say-name">
                            <div>
                                <h3 class="name">John Smith</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="say-msg">
                            <img src="static/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="say-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="say-more">
                        Read More <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                            <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                        </svg>
                    </div>
                </div>
                <div class="say">
                    <div class="say-about">
                        <div class="say-profile">
                            <img src="static/images/profile3.png" alt="">
                        </div>
                        <div class="say-name">
                            <div>
                                <h3 class="name">Lars Johnson</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="say-msg">
                            <img src="static/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="say-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="say-more">
                        Read More <svg xmlns="http://www.w3.org/2000/svg" width="29" height="9">
                            <path fill-rule="evenodd" fill="#4F4F4F" d="M.1 3.708h21.392C20.456 2.246 19.94 1.292 19.887.6c2.357 1.634 5.421 2.8 9.213 3.897-3.792 1.051-6.721 2.334-9.213 4.803.573-1.708.589-2.562 1.637-4.117H.1V3.708z"></path>
                        </svg>
                    </div>
                </div>
            </div>

        </section>

        <div class="d-none" id="_modal">
            <?php 
                if (isset($_GET["parameter"])){
                  echo $_GET["parameter"];
                }
            ?>
        </div>

    </div>

    <?php include("includes/footer.php") ?>

    <script>
        $(document).ready(function() {

            var _modal = $.trim($("#_modal").text());
            
            if(_modal=="loginmodal"){
                openLoginModal();
            }else if(_modal=="logoutmodal"){
                openLogoutModal();
            }else if(_modal=="sessionmodal"){
                openSessionModal();
            }
            
            function openLogoutModal() {
                removeParameterFromURI();
                $("#exampleLogout").modal("show");
            }
            function openLoginModal() {
                removeParameterFromURI();
                $("#exampleModallogin").modal("show");
            }
            function openSessionModal() {
                removeParameterFromURI();
                $("#sessionexpired").modal("show");
            }
            function removeParameterFromURI(){
                var uri = window.location.toString();
                if (uri.indexOf("?") > 0) {
                    var clean_uri = uri.substring(0, uri.indexOf("?"));
                    window.history.replaceState({}, document.title, clean_uri);
                    uri = window.location.toString();
                }
            }
            $(".circle").click(function() {
                $('html, body').animate({
                    scrollTop: $("#section-helper").offset().top
                }, 1000);
            });
            $(".scroll-icon").click(function() {
                $('html, body').animate({
                    scrollTop: $("#section-home").offset().top
                }, 1000);
            });

        });
    </script>
    <script src="static/js/validation.js"></script>
    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
</body>

</html>