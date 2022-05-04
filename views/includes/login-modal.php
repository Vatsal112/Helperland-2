<?php
$error = "";
$success = "";
$email = "";
if (isset($_SESSION["error"])) {
    $email = $_SESSION["error"][0];
    $error = $_SESSION["error"][1];
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    $email = $_SESSION["success"][0];
    $success = $_SESSION["success"][1];
    unset($_SESSION["success"]);
}
?>
<!-- Model For Login -->
<div class="modal fade" id="exampleModallogin" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title" id="staticBackdropLabel">Login to your account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $msg = "";
                if (!empty($success)) {
                    $class = "alert-success";
                    $msg = $success;
                } else if (!empty($error)) {
                    $class = "alert-danger";
                    $msg = $error;
                } 
                
                if(!empty($msg)){
                ?>
                    <div class="alert <?=$class?>" style="font-size:small" role="alert">
                        <?=$msg?>
                    </div>
                <?php } ?>
                <form action="<?= Config::BASE_URL . "/?controller=Users&function=signin" ?>" id="loginmodal" method="POST">
                    <div class="mb-3 form-group icon-textbox">
                        <input type="email" name="UserName" id="signinemail" class="form-control" placeholder="Email" value="
                            <?php
                            if (isset($_COOKIE['username'])) {
                                echo $_COOKIE["username"];
                            } else {
                                if (!empty($email)) {
                                    echo $email;
                                }
                            }
                            ?>
                            ">
                        <img alt="email" src="static/images/user.png">
                    </div>
                    <div class="mb-3 form-group icon-textbox">
                        <input type="password" id="password" name="Password" class="form-control" placeholder="Password" value="<?php if (isset($_COOKIE['password'])) {
                                                                                                                        echo $_COOKIE["password"];
                                                                                                                    } ?>">
                        <img alt="Password" src="static/images/lock.png">
                    </div>
                    <div class="form-check mt-3 mb-3">
                        <input class="form-check-input" type="checkbox" name="RememberMe" id="flexCheckChecked" <?php if (isset($_COOKIE['rememberme'])) {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                        <label class="form-check-label" for="flexCheckChecked">
                            Remember Me
                        </label>
                    </div>
                    <button class="submit-button mb-3" type="submit" id="signin" name="signin" onclick="showLoader()">Login</button>
                    <div class="text-center mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalfpwd" data-bs-dismiss="modal">Forgot Password</a></div>
                    <div class="text-center">Don't have an account? <a href="<?= Config::BASE_URL . "/?controller=Default&function=user_registration" ?>">Create an
                            account</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->