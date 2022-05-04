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
    <link rel="stylesheet" href="static/css/about.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="static/js/header.js"></script>

    <title>About</title>
</head>

<body>

    <?php
    include("includes/login-modal.php");
    include("includes/forgotpsw-modal.php");
    include("includes/header.php")
    ?>

    <div id="main">
        <div class="header-image"></div>

        <section id="section-fewwords">
            <div class="fewwords-title">
                <h1>A Few words about us</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
            </div>
            <div class="fewwords-content">
                We are providers of professional home cleaning services, offering hourly based house cleaning options, which mean that you don’t have to fret about getting your house cleaned anymore. We will handle everything for you, so that you can focus on spending your precious time with your family members.

                We have a number of experienced cleaners to help you make cleaning out or shifting your home an easy affair.

            </div>
        </section>

        <section id="section-ourstory">
            <div class="fewwords-title">
                <h1>Our Story</h1>
                <div class="h-line">
                    <img src="static/images/line.png" alt="" class="line">
                    <img src="static/images/star.png" alt="" class="star">
                    <img src="static/images/line.png" alt="" class="line">
                </div>
            </div>

            <div class="fewwords-content">
                A cleaner is a type of industrial or domestic worker who cleans homes or commercial premises for payment. Cleaners may specialise in cleaning particular things or places, such as window cleaners. Cleaners often work when the people who otherwise occupy the space are not around. They may clean offices at night or houses during the workday.
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