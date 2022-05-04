    <!--Model For Navbar toggle-->
    <div class="modal fade navbar-tmodel" id="exampleModalnavbartoggle" tabindex="-1"
        aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Welcome, <br><b><?=$userdata["FirstName"] . " " . $userdata["LastName"]?></b> </h4>
                </div>
                <div class="modal-body">
                    <a href="<?=Config::BASE_URL.'?controller=Default&function=price'?>">Prices & Services</a>
                    <a href="#">Warranty</a>
                    <a href="#">Blog</a>
                    <a href="<?=Config::BASE_URL.'?controller=Default&function=contact'?>">Contact</a>
                    <a href="<?=Config::BASE_URL."/?controller=Users&function=logout"?>">logout <i class="fa fa-sign-out" style="color: #1fb6ff;"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!--End Model-->