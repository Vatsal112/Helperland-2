<?php
$username = $userdata["FirstName"] . " " . $userdata["LastName"];
?>
<header id="section-header" class="d-block">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="<?= Config::BASE_URL . "/?controller=Default&function=homepage"?>">
            helperland
        </a>
        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalnavbartoggle" data-bs-dismiss="modal">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#"><img src="./static/images/admin-user.png" class="admin-user" alt=""><?= $username ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Config::BASE_URL . "/?controller=Users&function=logout" ?>"><img src="./static/images/icon-logout.png" alt=""></a>
                </li>
            </ul>
        </div>
    </nav>
</header>