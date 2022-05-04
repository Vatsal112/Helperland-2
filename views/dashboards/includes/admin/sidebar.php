<?php
$req = $parameter;
?>
<div class="div-sidebar" style="position:fixed">
    <a href="<?=Config::BASE_URL."?controller=Default&function=admin_dashboard&parameter=servicerequest"?>" class="<?php if($req=='servicerequest' or $req==''){ echo "sidebar-active"; } ?>">Service Requests</a>
    <a href="<?=Config::BASE_URL."?controller=Default&function=admin_dashboard&parameter=usermanagement"?>" class="<?php if($req=='usermanagement'){ echo "sidebar-active"; } ?>">User Mangement</a>
    <div class="sidebar-toggle">
        <i class="fa fa-angle-double-right"></i>
    </div>
</div>