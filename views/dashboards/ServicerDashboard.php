<?php
$userdata = [];
//$_SESSION["redirect_url"] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (isset($_SESSION["userdata"]) && $_SESSION["userdata"]["UserTypeId"] == Config::USER_TYPE_IDS[1]) {
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
    <link rel="stylesheet" href="static/css/calendar.css">
    <link rel="stylesheet" href="static/css/spdashboard.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Servicer Dashboard</title>
</head>

<body>

    <?php
    include("includes/servicer/cancel-modal.php");
    include("includes/servicer/accept-modal.php");
    include("includes/servicer/service-cancel-modal.php");
    include("views/includes/header.php")
    ?>

    <div class="modal fade" id="servicerequest" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-dialog-centered justify-content-center">
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
                <div class="modal-footer" style="justify-content:center;padding-top:10px;">
                    <button data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="header-image">Welcome, <span><?= $userdata["FirstName"] ?></div>
    <div class="main">
        <section id="section-spdashboard">
            <div class="div-main container-fluid">
                <?php
                include("includes/servicer/sidebar.php");
                if ($parameter != "") {
                    $req = $parameter;
                    switch ($req) {
                        case "dashboard":
                            include("includes/servicer/dashboard.php");
                            break;
                        case "newservice":
                            include("includes/servicer/new-service-req.php");
                            break;
                        case "upcoming":
                            include("includes/servicer/upcoming-service.php");
                            break;
                        case "schedule":
                            include("includes/servicer/service-schedule.php");
                            break;
                        case "history":
                            include("includes/servicer/service-history.php");
                            break;
                        case "ratings":
                            include("includes/servicer/my-ratings.php");
                            break;
                        case "block":
                            include("includes/servicer/block-customer.php");
                            break;
                        case "setting":
                            include("includes/servicer/my-setting.php");
                            break;
                        default:
                            include("includes/servicer/new-service-req.php");
                    }
                } else {
                    $req = "dashboard";
                    include("includes/servicer/dashboard.php");
                }

                echo "<input type='hidden' id='req' name='req' value=" . $req . "></input>";
                echo "<input type='hidden' id='spid' name='spid' value=" . $userdata["UserId"] . "></input>";
                ?>
            </div>
        </section>
    </div>

    <?php include("views/includes/footer.php") ?>

    <script src="static/js/header.js"></script>
    <script src="static/js/footer.js"></script>
    <script src="static/js/validation.js"></script>
    <script src="static/js/sdashboard.js"></script>
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