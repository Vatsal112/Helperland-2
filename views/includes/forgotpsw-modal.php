<!-- Model For Forgot Password -->
<div class="modal fade" id="exampleModalfpwd" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Forgot Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?=Config::BASE_URL."/?controller=Users&function=forgotpassword"?>" method="POST">
                        <div class="mb-3 form-group icon-textbox">
                            <input type="email" class="form-control" id="forgotemail" name="Email" placeholder="Email">
                            <img alt="email" src="static/images/user.png">
                        </div>

                        <button class="submit-button mb-3" type="submit" id="forgotpassword" name="forgot" onclick="showLoader()">Submit</button>
                        <div class="text-center mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModallogin" data-bs-dismiss="modal">Login now</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Model -->