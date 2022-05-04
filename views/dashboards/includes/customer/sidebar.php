<?php
$req = $parameter;
?>
<!-- <div class="div-sidebar">
    <a href="./customer-dashboard.php?req=dashboard" class="<?php if($req=='dashboard' or $req==''){ echo "active"; } ?>">Dashboard</a>
    <a href="./customer-dashboard.php?req=service-history" class="<?php if($req=='service-history'){ echo "active"; } ?>">Service History</a>
    <a href="#">Service Schedule</a>
    <a href="./customer-dashboard.php?req=favorite-pros" class="<?php if($req=='favorite-pros'){ echo "active"; } ?>">Favourite Pros</a>
    <a href="#">Invoices</a>
    <a href="#">Notification</a>
    <div class="sidebar-toggle">
        <i class="fa fa-angle-double-right"></i>
    </div>
</div> -->

<div class="div-sidebar">
    <a href="<?=Config::BASE_URL."?controller=Default&function=customer_dashboard&parameter=dashboard"?>" class="<?php if($req=='dashboard' or $req==''){ echo "active"; } ?>">Dashboard</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=customer_dashboard&parameter=service-history"?>" class="<?php if($req=='service-history'){ echo "active"; } ?>">Service History</a>
    <a href="#">Service Schedule</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=customer_dashboard&parameter=favorite-pros"?>" class="<?php if($req=='favorite-pros'){ echo "active"; } ?>">Favourite Pros</a>
    <a href="#">Invoices</a>
    <a href="#">Notification</a>
    <div class="sidebar-toggle">
        <i class="fa fa-angle-double-right"></i>
    </div>
</div>