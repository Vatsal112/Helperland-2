<?php

if (isset($_SESSION["userdata"])) {
    header("Location: " . Config::BASE_URL . "?controller=default&function=homepage");
    exit();
}
$error = "";
$success = "";
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"][1];
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"][1];
    unset($_SESSION["success"]);
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
    <link rel="stylesheet" href="static/css/homepage.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/spsignup.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <title>Become a Pro</title>
</head>

<body>

    <?php
    include("includes/header.php")
    ?>

    <div class="main">

        <section id="section-home">
            <div class="hero-image">
                <div id="form">
                    <div class="form">
                        <div class="text-center">
                            <span>Register Now!</span>
                        </div>
                        <?php
                        $msg = "";
                        if (!empty($success)) {
                            $class = "alert-success";
                            $msg = $success;
                        } else if (!empty($error)) {
                            $class = "alert-danger";
                            $msg = $error;
                        }

                        if (!empty($msg)) {
                        ?>
                            <div class="alert <?= $class ?>" style="font-size:small" role="alert">
                                <?= $msg ?>
                            </div>
                        <?php } ?>
                        <form action="<?= Config::BASE_URL . "/?controller=Users&function=signup" ?>" method="POST">
                            <input type="hidden" name="UserTypeId" value=2>
                            <div class="row">
                                <div class="">
                                    <input class="form-control" name="FirstName" id="firstname" placeholder="First name" type="text" autofocus />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input class="form-control" name="LastName" id="lastname" placeholder="Last name" type="text" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input class="form-control" name="Email" id="email" placeholder="Email Address" type="email" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+46</div>
                                        </div>
                                        <input type="number" name="Mobile" class="form-control" id="phonenumber" placeholder="Phone number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input class="form-control" name="Password" id="password" placeholder="Password" type="password" autofocus />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input class="form-control" name="RePassword" id="repassword" placeholder="Confirm Password" type="password" />
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="Policy" id="policy" required>
                                <label class="form-check-label" for="policy">
                                    I accept <span>terms and conditions </span>&<span> privacy policy</span>
                                </label>
                            </div>
                            <div class="get-started text-center row">
                                <button type="submit" id="register" name="signup" onclick="showLoader()">Getting Started <img src="static/images/shape-3.png" alt=""></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="btn-down">
                    <div class="circle">
                        <a href="#section-howitworks">
                            <img src="static/images/shape-1.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-howitworks">
            <div class="how_it_works">
                <div class="text-center">
                    <span>How it works</span>
                </div>
                <div class="cards">
                    <div class="single-card">
                        <div class="card-img">
                            <img src="static/images/group-16.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Register yourself</h2>
                            <p>Provide your basic information to register
                                yourself as a service provider.</p>
                            <p class="arrow">Read more <img src="static/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                    <div class="single-card">
                        <div class="card-img">
                            <img src="static/images/group-17.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Get service requests</h2>
                            <p>You will get service requests from
                                customes depend on service area and profile.</p>
                            <p class="arrow">Read more <img src="static/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                    <div class="single-card">
                        <div class="card-img">
                            <img src="static/images/group-18.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Complete service</h2>
                            <p>Accept service requests from your customers
                                and complete your work.</p>
                            <p class="arrow">Read more <img src="static/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="left-img">
                <img src="static/images/blog-left-bg.png" alt="">
            </div>
            <div class="right-img">
                <img src="static/images/blog-right-bg.png" alt="">
            </div>
        </section>

    </div>

    <?php include("includes/footer.php") ?>

    <script>
        $(document).ready(function() {

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