
<?php

if (isset($_SESSION["userdata"])) {
    $userdata = $_SESSION["userdata"];
    //print_r($userdata);
}
?>
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
    <link rel="stylesheet" href="static/css/prices.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Prices</title>
</head>

<body>


<?php 
        include("includes/login-modal.php");
        include("includes/forgotpsw-modal.php");
        include("includes/header.php")
    ?>

    <div id="main">
        <div class="header-image"></div>

        <section id="section-prices">
            <div class="prices-title">
                <h1>Prices</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
                <div class="prices-card">
                    <div class="p-card">
                        <div class="p-title text-light">
                            <h2 style="color: white;">One Time</h2>
                        </div>
                        <div class="p-body">

                            <div class="p-price">€18<span>/hr</span></div>
                            <div class="p-detailes">
                                <div class="p-inside">
                                    <div class="p-detaile"><img src="static/images/blue-right.png" alt="">
                                        <p>Lower Prices</p>
                                    </div>
                                    <div class="p-detaile"><img src="static/images/blue-right.png" alt="">
                                        <p>Easy Online & Secure Payment</p>
                                    </div>
                                    <div class="p-detaile"><img src="static/images/blue-right.png" alt="">
                                        <p>Lower Prices</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-extraservices">
            <div class="extra-services">
                <h1>Extra Services</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
                <div class="extra-services-list row">
                    <div class="e-service col-xl-2 col-md-2">
                        <div class="e-img">
                            <img src="static/images/cabinet.png">
                        </div>
                        <div class="e-title">
                            <p>Inside Cabinet</p>
                        </div>
                        <div class="e-time">
                            <p>30 minutes</p>
                        </div>
                    </div>
                    <div class="e-service col-xl-2 col-md-2">
                        <div class="e-img">
                            <img src="static/images/freeze.png" alt="">
                        </div>
                        <div class="e-title">
                            <p>Inside fridge</p>
                        </div>
                        <div class="e-time">
                            <p>30 minutes</p>
                        </div>
                    </div>
                    <div class="e-service col-xl-2 col-md-2">
                        <div class="e-img">
                            <img src="static/images/oven.png" alt="">
                        </div>
                        <div class="e-title">
                            <p>Inside oven</p>
                        </div>
                        <div class="e-time">
                            <p>30 minutes</p>
                        </div>
                    </div>
                    <div class="e-service col-xl-2 col-md-2">
                        <div class="e-img">
                            <img src="static/images/washing-machine.png" alt="">
                        </div>
                        <div class="e-title">
                            <p>Laundry wash & dry</p>
                        </div>
                        <div class="e-time">
                            <p>30 minutes</p>
                        </div>
                    </div>
                    <div class="e-service col-xl-2 col-md-2">
                        <div class="e-img">
                            <img src="static/images/window.png" alt="">
                        </div>
                        <div class="e-title">
                            <p>Interior windows</p>
                        </div>
                        <div class="e-time">
                            <p>30 minutes</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-cleaning">
            <div class="cleaning-services">
                <div class="cleaning-header">
                    <h1>What we include in cleaning</h1>
                    <div class="h-line">
                        <img src="static/images/line.png" alt="" class="line">
                        <img src="static/images/star.png" alt="" class="star">
                        <img src="static/images/line.png" alt="" class="line">
                    </div>
                </div>
                <div class="row cleaning-areas">
                    <div class="col-lg-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/room.png" alt="">
                        </div>
                        <div class="c-content">
                            <div class="content-title">Badroom And Living Room</div>
                            <div class="content-includes">
                                <ul class="content-list">
                                    <li><img src="static/images/arrow-right.png" alt=""> Dust all accessible surfaces
                                    </li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Wipe down all mirrors and
                                        glass fixtures</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Clean all floor surfaces</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Take out garbage and
                                        recycling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/bathroom.png" alt="">
                        </div>
                        <div class="c-content">
                            <div class="content-title">Bathrooms</div>
                            <div class="content-includes">
                                <ul class="content-list">
                                    <li><img src="static/images/arrow-right.png" alt=""> Wash and sanitize the toilet,
                                        shower, tub, sink</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Dust all accessible surfaces
                                    </li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Wipe down all mirrors and
                                        glass fixtures</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Clean all floor surfaces</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Take out garbage and
                                        recycling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="c-img">
                            <img src="static/images/kitchen.png" alt="">
                        </div>
                        <div class="c-content">
                            <div class="content-title">Kitchen</div>
                            <div class="content-includes">
                                <ul class="content-list">
                                    <li><img src="static/images/arrow-right.png" alt=""> Dust all accessible surfaces
                                    </li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Empty sink and load up
                                        dishwasher</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Wipe down all mirrors and
                                        glass fixtures</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Clean all floor surfaces</li>
                                    <li><img src="static/images/arrow-right.png" alt=""> Take out garbage and
                                        recycling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-whyhelper">
            <div class="s-whyhelper">
                <div class="whyhelper-header">
                    <h1>Why Helperland</h1>
                    <div class="h-line">
                        <img src="static/images/line.png" alt="" class="line">
                        <img src="static/images/star.png" alt="" class="star">
                        <img src="static/images/line.png" alt="" class="line">
                    </div>
                </div>

                <div class="row c-helperland">
                    <div class="col-lg-4 content-left">
                        <div class="d-first">
                            <h2>Experienced and vetted professionals</h2>
                            <p>dominate the industry in scale and scope with an adaptable, extensive network that
                                consistently delivers exceptional results.</p>
                        </div>
                        <div class="d-second">
                            <h2>Dedicated customer service</h2>
                            <p>to our customers and are guided in all we do by their needs. The team is always happy to
                                support you and offer all the information. you need.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 whyhelper-banner text-center">
                        <img src="static/images/best-cleaning-title.png" alt="">
                    </div>
                    <div class="col-lg-4 content-right">
                        <div class="d-first">
                            <h2>Every cleaning is insured</h2>
                            <p>and seek to provide exceptional service and engage in proactive behavior. We‘d be happy
                                to clean your homes.</p>
                        </div>
                        <div class="d-second">
                            <h2>Secure online payment</h2>
                            <p>Payment is processed securely online. Customers pay safely online and manage the booking.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>

    <?php include("includes/footer.php") ?>

    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
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