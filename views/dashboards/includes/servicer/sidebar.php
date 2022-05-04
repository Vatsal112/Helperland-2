<?php
$req = $parameter;
?>
<!-- <div class="div-sidebar">
    <a href="./servicer-dashboard.php?req=dashboard" class="<?php if($req=='dashboard' or $req==''){ echo "active"; } ?>">Dashboard</a>
    <a href="./servicer-dashboard.php?req=newservice" class="<?php if($req=='newservice'){ echo "active"; } ?>">New Service Requests</a>
    <a href="./servicer-dashboard.php?req=upcoming" class="<?php if($req=='upcoming'){ echo "active"; } ?>">Upcoming Service</a>
    <a href="./servicer-dashboard.php?req=schedule" class="<?php if($req=='schedule'){ echo "active"; } ?>">Service Schedule</a>
    <a href="./servicer-dashboard.php?req=history" class="<?php if($req=='history'){ echo "active"; } ?>">Service History</a>
    <a href="./servicer-dashboard.php?req=ratings" class="<?php if($req=='ratings'){ echo "active"; } ?>">My Ratings</a>
    <a href="./servicer-dashboard.php?req=block" class="<?php if($req=='block'){ echo "active"; } ?>">Block Customer</a>
    <div class="sidebar-toggle">
        <i class="fa fa-angle-double-right"></i>
    </div>
</div> -->

<div class="div-sidebar">
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=dashboard"?>" class="<?php if($req=='dashboard' or $req==''){ echo "active"; } ?>">Dashboard</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=newservice"?>" class="<?php if($req=='newservice'){ echo "active"; } ?>">New Service Requests</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=upcoming"?>" class="<?php if($req=='upcoming'){ echo "active"; } ?>">Upcoming Service</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=schedule"?>" class="<?php if($req=='schedule'){ echo "active"; } ?>">Service Schedule</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=history"?>" class="<?php if($req=='history'){ echo "active"; } ?>">Service History</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=ratings"?>" class="<?php if($req=='ratings'){ echo "active"; } ?>">My Ratings</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=block"?>" class="<?php if($req=='block'){ echo "active"; } ?>">Block Customer</a>
    <div class="sidebar-toggle">
        <i class="fa fa-angle-double-right"></i>
    </div>
</div>
