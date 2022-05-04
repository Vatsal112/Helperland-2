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
    <link rel="stylesheet" href="static/css/faqs.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>FAQ</title>
</head>

<body>

<?php 
        include("includes/login-modal.php");
        include("includes/forgotpsw-modal.php");
        include("includes/header.php")
    ?>

    <div id="main">
        <div class="header-image"></div>
        <section id="section-faqs">
            <div class="faqs-header">
                <h1>FAQs</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
                <div class="content">
                    Whether you are Customer or Service provider,<br>
                    We have tried our best to solve all your queries and questions.
                </div>
            </div>
            <div class="faqs-division">
                <div class="division-button">
                    <button class="btn-customer btn-active">For Customer</button>
                    <button class="btn-serviceprovider">For Service Provider</button>
                </div>
                <div class="faqs">
                    <div class="faq for-customer">

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo1">
                                    <img src="static/images/arrow-down.png">
                                    <p>
                                    What's included in a cleaning?</p>

                                </button>
                            </div>
                            <div id="demo1" class="faq-answer collapse show">
                            Bedroom, Living Room & Common Areas, Bathrooms, Kitchen, Extras
                            </div>
                        </div>

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo2">
                                    <img src="static/images/arrow-right.png">
                                    <p>
                                    Which Helperland professional will come to my place?</p>
                                </button>
                            </div>
                            <div id="demo2" class="faq-answer collapse in">
                            Helperland has a vast network of experienced, top-rated cleaners. Based on the time and date of your request, we work to assign the best professional available. Like working with a specific pro? Add them to your Pro Team from the mobile app and they'll be requested first for all future bookings. You will receive an email with details about your professional prior to your appointment.</div>
                        </div>

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo3">
                                    <img src="static/images/arrow-right.png">
                                    <p>
                                    Can I skip or reschedule bookings?</p>

                                </button>
                            </div>
                            <div id="demo3" class="faq-answer collapse in">
                            You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit the value of the booking to your account. You can use this credit on future cleanings and other Helperland services.</div>
                        </div>

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo4">
                                    <img src="static/images/arrow-right.png">
                                    <p>
                                    Do I need to be home for the booking?</p>
                                </button>
                            </div>
                            <div id="demo4" class="faq-answer collapse in">
                            We strongly recommend that you are home for the first clean of your booking to show your cleaner around. Some customers choose to give a spare key to their cleaner, but this decision is based on individual preferences.</div>
                        </div>

                    </div>
                    <div class="faq for-service" style="display: none;">

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo-1">
                                    <img src="static/images/arrow-down.png">
                                    <p>How much do service providers earn?</p>
                                </button>
                            </div>
                            <div id="demo-1" class="faq-answer collapse show">
                            The self-employed service providers working with Helperland set their own payouts, this means that they decide how much they earn per hour.</div>
                        </div>

                        <div class="faq-quetions">
                            <div class="faq-quetion">
                                <button type="button" class="btn btn-col" data-toggle="collapse" data-target="#demo-2">
                                    <img src="static/images/arrow-right.png">
                                    <p>
                                    What support do you provide to the service providers?</p>
                                </button>
                            </div>
                            <div id="demo-2" class="faq-answer collapse in">
                            Our call-centre is available to assist the service providers with all queries or issues in regards to their bookings during office hours. Before a service provider starts receiving jobs, every individual partner receives an orientation session to familiarise with the online platform and their profile.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

   <?php include("includes/footer.php")?>

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

            // Add down arrow icon for collapse element which is open by default
            $(".collapse.show").each(function() {
                $(this).prev(".faq-quetion").find("img").attr('src', 'static/images/arrow-down.png');
            });

            // Toggle right and down arrow icon on show hide of collapse element
            $('.btn-col').on('click', function() {
                if ($(this).parent().parent().find(".collapse.show").length) {
                    $(this).children('img').attr('src', "static/images/arrow-right.png");
                } else {
                    $(this).children('img').attr('src', "static/images/arrow-down.png");
                }
            });

            $(".btn-customer").click(function() {
                $(".for-service").css("display", "none");
                $(".for-customer").css("display", "block");
                $(this).addClass("btn-active");
                $(".btn-serviceprovider").removeClass("btn-active");
            });
            $(".btn-serviceprovider").click(function() {
                $(".for-service").css("display", "block");
                $(".for-customer").css("display", "none");
                $(this).addClass("btn-active");
                $(".btn-customer").removeClass("btn-active");
            });

            $(".faq-quetion").click(function() {
                if (!$(this).parent().find(".faq-answer").hasClass("show")) {
                    const answerlist = document.getElementsByClassName("faq-answer")
                    const quetionlist = document.getElementsByClassName("faq-quetion");
                    for (var i = 0; i < answerlist.length; i++) {
                        answerlist[i].classList.remove("show");
                        quetionlist[i].querySelector("button").setAttribute("aria-expanded", "false");
                    }
                } else {
                    $(this).find("button").attr("aria-expanded", "true");
                }
            });
        });
    </script>
</body>

</html>