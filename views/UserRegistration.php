<?php

if (isset($_SESSION["userdata"])) {
    header("Location: " . Config::BASE_URL . "/?controller=Default&function=Homepage");
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/footer.css">
    <link rel="stylesheet" href="static/css/header1.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/user-registration.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>User Registration</title>
</head>

<body>

    <?php
    include("includes/header.php")
    ?>

    <div id="main">
        <div class="header-image"></div>

        <section id="section-form">
            <div class="fewwords-title">
                <h1>Create an account</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
            </div>
            <div class="form">
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
                    <input type="hidden" name="UserTypeId" value=1>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <input class="form-control" name="FirstName" id="firstname" placeholder="First name" type="text" autofocus />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <input class="form-control" name="LastName" id="lastname" placeholder="Last name" type="text" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <input class="form-control" name="Email" id="email" placeholder="Email address" type="email" />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+49</div>
                                </div>
                                <input type="number" class="form-control" name="Mobile" id="phonenumber" placeholder="Mobile number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <input class="form-control" name="Password" id="password" placeholder="Password" type="password" autofocus />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 15px;">
                            <input class="form-control" name="RePassword" id="repassword" placeholder="Confirm Password" type="password" />
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="Policy" type="checkbox" id="policy" required>
                        <label class="form-check-label" for="policy">
                            I have read the <a href="#">privacy policy </a>
                        </label>
                    </div>
                    <div class="submit text-center">
                        <button type="submit" id="register" name="signup" onclick="showLoader()">Register</button>
                        <p>Already registered? <a href="<?= Config::BASE_URL . "/?controller=Default&function=Homepage&parameter=loginmodal" ?>">Login now</a></p>
                    </div>
                </form>
            </div>
        </section>

    </div>

    <?php include("includes/footer.php") ?>
    <script src="static/js/validation.js"></script>
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