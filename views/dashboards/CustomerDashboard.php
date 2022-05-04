<?php
$userdata = [];
//$_SESSION["redirect_url"] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (isset($_SESSION["userdata"]) && $_SESSION["userdata"]["UserTypeId"] == Config::USER_TYPE_IDS[0]) {
    $userdata = $_SESSION["userdata"];
} else {
    header("Location: " . Config::BASE_URL . "?controller=default&function=homepage");
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
    <link rel="stylesheet" href="static/css/footer.css">
    <link rel="stylesheet" href="static/css/header1.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/cdashboard.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Customer Dashboard</title>
</head>

<body>

    <?php
    include("includes/customer/sprating-modal.php");
    include("includes/customer/service-detailes-modal.php");
    include("includes/customer/service-reschedule-modal.php");
    include("includes/customer/service-cancel-modal.php");
    include("includes/customer/address-modal.php");
    include("views/includes/header.php");
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

                    </div>
                </div>
                <div class="modal-footer" style="padding-top: 0;">
                    <button data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="header-image">Welcome, <span><?= $userdata["FirstName"] ?></span></div>

    <div class="main">
        <section id="section-cdashboard">
            <div class="div-main container-fluid">
                <?php include("includes/customer/sidebar.php") ?>
                <?php
                if ($parameter != "") {
                    $req = $parameter;
                    switch ($req) {
                        case "dashboard":
                            include("includes/customer/dashboard.php");
                            break;
                        case "service-history":
                            include("includes/customer/service-history.php");
                            break;
                        case "favorite-pros":
                            include("includes/customer/favorite-pros.php");
                            break;
                        case "setting":
                            include("includes/customer/my-setting.php");
                            break;
                        default:
                            include("includes/customer/dashboard.php");
                    }
                } else {
                    $req = "dashboard";
                    include("includes/customer/dashboard.php");
                }

                echo "<input type='hidden' id='req' name='req' value=" . $req . "></input>";
                ?>
            </div>
        </section>

    </div>
    <?php include("views/includes/footer.php") ?>

    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
    <script src="static/js/validation.js"></script>
    <script src="static/js/cdashboard.js"></script>
    <script>
        $(document).ready(function() {

            // var uri = window.location.toString();
            // if (uri.indexOf("?") > 0) {
            //     var clean_uri = uri.substring(0, uri.indexOf("?"));
            //     window.history.replaceState({}, document.title, clean_uri);
            //     uri = window.location.toString();
            // }        

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