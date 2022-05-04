<?php

$userdata = [];
if (isset($_SESSION["userdata"]) && $_SESSION["userdata"]["UserTypeId"] == Config::USER_TYPE_IDS[2]) {
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
    <link rel="stylesheet" href="static/css/header2.css">
    <link rel="stylesheet" href="static/css/modal.css">
    <link rel="stylesheet" href="static/css/cdashboard.css">
    <link rel="stylesheet" href="static/css/adashboard.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <!-- script and link for loader -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>admin-dashboard</title>
</head>

<body>
    <?php
    include("includes/admin/navbar-modal.php");
    include("includes/admin/edit-reschedule-modal.php");
    include("includes/admin/refund-amount-modal.php");
    include("views/includes/header2.php");
    ?>

    <div class="main">
        <section id="section-adashboard">
            <div class="div-main">
                <?php include("includes/admin/sidebar.php") ?>
                <div class="differ-section">
                    <?php
                    if ($parameter != "") {
                        $req = $parameter;
                        switch ($req) {
                            case "usermanagement":
                                include("includes/admin/user-management.php");
                                break;
                            default:
                                include("includes/admin/service-requests.php");
                        }
                    } else {
                        include("includes/admin/service-requests.php");
                    }
                    echo "<input type='hidden' id='aid' name='aid' value=" . $userdata["UserId"] . "></input>";
                    echo "<input type='hidden' id='req' name='req' value=" . $req . "></input>";
                    ?>
                </div>
            </div>
        </section>

    </div>
    <script>
        $(document).ready(function() {
            $(".sidebar-toggle").on("click", function() {
                $(".div-sidebar").toggleClass("toggle");
                $(".sidebar-toggle i").toggleClass("toggle");
            });
        });
    </script>
    <script src="static/js/validation.js"></script>
    <script src="static/js/adashboard.js"></script>

</body>

</html>