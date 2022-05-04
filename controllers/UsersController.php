<?php

require_once("validation/usersvalidator.php");
require_once("./modals/UsersModal.php");
require_once("phpmailer/mail.php");

class UsersController
{
    public $validate;
    public $usermodal;
    public $errors = [];

    public function __construct()
    {
        $this->validate = new UsersValidator($_POST);
        $this->usermodal = new UsersModal($_POST);
    }

    /*-------------- For Signup -------------*/
    public function signup()
    {
        if (isset($_POST["signup"])) {
            $errors = $this->validate->isSignupFormValidate();
            if ((!count($errors) > 0)) {
                $result = $this->usermodal->insertUser();
                if (!count($result[1]) > 0) {
                    $this->unsetCookieSignin();
                    $_SESSION["success"] = array($_POST["Email"], "User is created successfully");
                    header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
                    exit();
                } else {
                    $this->showError("Somthing went wrong!!!!", $result[1]);
                }
            } else {
                $this->showError("Form is not validated!!", $errors);
            }
        } else {
            $this->showError("Failed to register!!!", array("Invalid field name!!!"));
        }
    }

    /*------------- For Signin ------------*/
    public function signin()
    {
        if (isset($_POST["signin"])) {
            $errors = $this->validate->isSigninFormValidate();
            if (!count($errors) > 0) {
                $result = $this->usermodal->getUserDetailes($_POST["UserName"], $_POST["Password"]);
                if (!count($result[1]) > 0) {
                    $redirect_location = "";
                    $usertypeid = $result[0]["UserTypeId"];

                    // cheked that user is approved by the admin or not
                    if (!$this->usermodal->isUserVerified($result[0]["Email"])) {
                        $this->unsetCookieSignin();
                        $_SESSION["error"] = array($result[0]["Email"], "wait until you get approved by the admin");
                        header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
                        exit();
                    }

                    if ($usertypeid == Config::USER_TYPE_IDS[0]) {
                        $redirect_location = "customer_dashboard";
                    } else if ($usertypeid == Config::USER_TYPE_IDS[1]) {
                        $redirect_location = "servicer_dashboard";
                    } else if ($usertypeid == Config::USER_TYPE_IDS[2]) {
                        $redirect_location = "admin_dashboard";
                    } else {
                        echo "Somthing went wrong";
                        exit();
                    }
                    $_SESSION["userdata"] = $result[0];
                    $_SESSION["redirect"] = $redirect_location;
                    $_SESSION["expire"] = time();

                    // if user check remember me then set the signin credential
                    $this->setCookieForSignin();
                    $redirect_loc = "";
                    if (isset($_SESSION["redirect_url"])) {
                        $redirect_loc = $_SESSION["redirect_url"];
                        unset($_SESSION["redirect_url"]);
                    }

                    if ($redirect_loc == "") {
                        header("Location: " . Config::BASE_URL . "?controller=Default&function=$redirect_location");
                    } else {
                        header("Location: " . $redirect_loc);
                    }
                    exit();
                } else {
                    $this->showError("Form is not validated!!!", array("Userename or password is incorrect!!"));
                }
            } else {
                $this->showError("Form is not validated!!!", $errors);
            }
        } else {
            $this->showError("Failed to login!!!", array("Invalid field name!!!"));
        }
    }

    /*-------------- For Logout --------------*/
    public function logout()
    {
        if (isset($_SESSION["expire"]) && isset($_SESSION["userdata"])) {
            unset($_SESSION["expire"]);
            unset($_SESSION["userdata"]);
        }
        header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=logoutmodal");
        exit();
    }

    /*------------ Change Password -----------*/
    public function changepassword()
    {
        if (isset($_POST["change"])) {
            if (isset($_SESSION["changeuser"])) {
                if (isset($_POST["Password"]) && isset($_POST["RePassword"])) {
                    $psw = $_POST["Password"];
                    $repsw = $_POST["RePassword"];
                    $this->validate->passwordMatching($psw, $repsw);
                    if (empty($this->validate->errors)) {
                        $email = $_SESSION["changeuser"]["Email"];
                        if ($this->usermodal->changePassword($email, $psw)) {
                            $this->unsetCookieSignin();
                            unset($_SESSION["changeuser"]);
                            $_SESSION["success"] = array($email, "password reset successfully");
                            header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
                            exit();
                        }
                    } else {
                        $this->showError("Form is not validate", $this->validate->errors);
                    }
                } else {
                    $this->showError("Somthing went wrong", array("Invalid field name!!!"));
                }
            } else {
                $this->showError("Somthing went wrong", array("link is expried!! try again"));
            }
        } else if (isset($_GET["parameter"]) && $_GET["parameter"] == "openform") {
            include("views/ChangePassword.php");
        } else {
            $this->showError("Failed to change password!!!", array("Invalid field name!!!"));
        }
    }

    /*---------- For Forgot Password ------------*/
    public function forgotpassword()
    {
        if (isset($_POST["forgot"]) && isset($_POST["Email"])) {
            $this->validate->validateEmail($_POST["Email"]);
            if (empty($this->validate->errors)) {
                // check user is exits or not
                $user = $this->usermodal->getUserByEmail(trim($_POST["Email"]));
                if (count($user) > 0) {
                    $reciepent = $user["Email"];
                    $subject = "Helperland (Forgot Password)";
                    $body = "<div><h1><a href=" . Config::BASE_URL . "?controller=Users&function=changepassword&parameter=openform" . ">Reset Password</a></h1></div><div style='color:red'>( one time password reset link )</div>";
                    $mail = sendmail([$reciepent], $subject, $body);

                    $expFormat = mktime(date("H") + 1, date("i"), date("s"), date("m"), date("d"), date("Y"));
                    $_SESSION["changeuser"] = array("exp_date" => date("Y-m-d H:i:s", $expFormat), "Email" => $reciepent);

                    // redirect to the homepage with the success message
                    $this->unsetCookieSignin();
                    $_SESSION["success"] = array($user["Email"], "Reset link sent to the " . $user['Email']);
                    header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
                    exit();
                } else {
                    $_SESSION["error"] = array("", "User( " . $_POST['Email'] . ") isn`t exits!!");
                    header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
                    exit();
                }
            }
        } else {
            $this->showError("Failed to forgot password!!!", array("Invalid field name!!!"));
        }
    }

    /*------------- Update User Detailes ------------*/
    public function UpdateUserDetailes()
    {
        $result = [];
        $res = [];
        $addid = 0;
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $usertype = $user["UserTypeId"];
            $userid = $user["UserId"];
            $email = $user["Email"];
            if ($usertype == 2) {
                if (isset($_POST["addid"]) && !empty($_POST["addid"])) {
                    $addid = $_POST["addid"];
                    $res = $this->usermodal->updateUserAddress($userid, $addid);
                    if(count($res[1]) > 0){
                        foreach ($res[1] as $key => $val) {
                            $this->addErrors($key, $val);
                        }
                    }
                } else {
                    $addid =$this->usermodal->insertUserAddress($userid, $email);
                    if($addid==0){
                        $this->addErrors("Insert", "Failed to insert User address!!!");
                    }
                }
            }
            if(count($this->errors) < 1){
                $result = $this->usermodal->UpdateUserDetailes($userid);
                if ($result == 1) {
                    $result = $this->usermodal->getUserByEmail($_POST["Email"]);
                    if (count($result) > 0) {
                        $_SESSION["userdata"] = $result;
                    } else {
                        $this->addErrors('user', 'User is not found');
                    }
                } else {
                    $this->addErrors("Update", "Update Failed!!!");
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors, "addid"=>$addid]);
    }

    /*----------- Changed Password if Old validate -----------*/
    public function ChangedPassword()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $email = $user["Email"];
            if (isset($_POST["oldpassword"]) && isset($_POST["userid"])) {
                $result = $this->usermodal->getUserByUserId($_POST["userid"]);
                if (count($result) > 0) {
                    if (!password_verify($_POST["oldpassword"], $result["Password"])) {
                        $this->addErrors("password", "Old password is wrong!!!");
                    } else {
                        if (isset($_POST["newpassword"]) && isset($_POST["repassword"])) {
                            $psw = $_POST["newpassword"];
                            $repsw = $_POST["repassword"];
                            $this->validate->passwordMatching($psw, $repsw);
                            if (empty($this->validate->errors)) {
                                $result = $this->usermodal->changePassword($email, $psw);
                            } else {
                                foreach ($this->validate->errors as $key => $val) {
                                    $this->addErrors($key, $val);
                                }
                            }
                        } else {
                            $this->addErrors("invalid", "Invalid field name!!");
                        }
                    }
                } else {
                    $this->addErrors("User", "User is not found!!!");
                }
            } else {
                $this->addErrors("invalid", "Invalid field name!!!" . $_POST["userid"]);
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /* get user address by user address id */
    public function getUserAddress()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            if (isset($_POST["addid"])) {
                $addid = $_POST["addid"];
                $result = $this->usermodal->getUserAddressById($addid);
                if (count($result) <= 0) {
                    $this->addErrors("NotFound", "Somthing went wrong with the sql!!");
                }
            } else {
                $this->addErrors("Invalid", "Somthing went wrong with the field name!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*-------------- Get city by postal code --------------*/
    public function getCityByPostal()
    {
        $result = [];
        if (isset($_POST["postalcode"])) {
            $postal = $_POST["postalcode"];
            $result = $this->usermodal->getCityByPostal($postal);
            if (count($result) <= 0) {
                $this->addErrors("Invalid", "invalid postal code!!");
            }
        }
        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*------------- Insert New User Address -------------*/
    public function InsertUserAddress()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $email = $user["Email"];
            $result = $this->usermodal->InsertUserAddress($userid, $email);
            if ($result!=0) {
                $result = $this->usermodal->getAllUserAddressByUserId($userid)[0];
            } else {
                $result = ["addid"=>$result];
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*------------- Update User Address By Address Id ------------*/
    public function UpdateUserAddress()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $addid = isset($_POST["addid"]) ? $_POST["addid"] : 0;
            if (count($this->usermodal->isExistsUserAddress($userid, $addid)) > 0) {
                $result = $this->usermodal->UpdateUserAddress($userid, $addid);
                if ($result[0] && count($result[1]) <= 1) {
                    $result = $this->usermodal->getAllUserAddressByUserId($userid)[0];
                } else {
                    $result = [];
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*-------------- Delete User address by Addressid -----------*/
    public function DeleteUserAddress()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            if (isset($_POST["addid"])) {
                $addid = $_POST["addid"];
                $result = $this->usermodal->DeleteUserAddress($userid, $addid);
                if ($result) {
                    $result = $this->usermodal->getAllUserAddressByUserId($userid)[0];
                } else {
                    $result = [];
                }
            } else {
                $this->addErrors("Invalid", "Somthing went wrong with the field name!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*--------------- Get User Rating ---------------*/
    public function GetUserRating()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            if (isset($_POST["ratingid"])) {
                $ratingid =  $_POST["ratingid"];
                $result = $this->usermodal->getUserRatingByIds($ratingid);
                if (count($result) < 1) {
                    $this->addErrors("DatabaseError", "Somthing went wrong with SQL!!!");
                }
            } else {
                $this->addErrors("FieldName", "Invalid field name!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*-------------- Insert User Rating -------------*/
    public function InsertRating()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $ontime = $_POST["ontimearrival"];
            $friendly = $_POST["friendly"];
            $quality = $_POST["quality"];
            $feedback = $_POST["rateing_feed"];
            $serviceid =  $_POST["serviceid"];
            $result = $this->usermodal->InsertRating($userid, $serviceid, $ontime, $friendly, $quality, $feedback);
            if (count($result) < 1) {
                $this->addErrors("DatabaseError", "Somthing went wrong with the error!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*-------------- Update User Rating -------------*/
    public function UpdateRating()
    {
        $result = [];
        if (isset($_SESSION["userdata"])) {
            $ontime = $_POST["ontimearrival"];
            $friendly = $_POST["friendly"];
            $quality = $_POST["quality"];
            $feedback = $_POST["rateing_feed"];
            if (isset($_POST["ratingid"])) {
                $ratingid =  $_POST["ratingid"];
                $result = $this->usermodal->UpdateRating($ratingid, $ontime, $friendly, $quality, $feedback);
                if (count($result) < 1) {
                    $this->addErrors("DatabaseError", "Somthing went wrong with SQL!!!");
                }
            } else {
                $this->addErrors("FieldName", "Invalid field name!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors]);
    }

    /*-------------- setcookie -------------*/
    public function setCookieForSignin()
    {
        if (!empty($_POST["RememberMe"])) {
            $settime =  time() + (60 * 60 * 24 * 365);
            setcookie("username", $_POST["UserName"], $settime, '/');
            setcookie("password", $_POST["Password"], $settime, '/');
            setcookie("rememberme", $_POST["RememberMe"], $settime, '/');
        } else {
            $this->unsetCookieSignin();
        }
    }

    public function unsetCookieSignin()
    {
        $unsettime = time() - 3600;
        setcookie("username", "", $unsettime, '/');
        setcookie("password", "", $unsettime, '/');
        setcookie("rememberme", "", $unsettime, '/');
    }

    /*-------------- Show Error -----------*/
    public function showError($title, $errors = [])
    {
        $_SESSION["error_title"] = $title;
        $_SESSION["error_array"] = $errors;
        header("Location: " . Config::BASE_URL . "?controller=Default&function=error");
        exit();
    }

    /*------------- Set error ------------*/
    private function addErrors($key, $val)
    {
        $this->errors[$key] = $val;
    }

    /*-------------- Check Session is exprired or not -----------*/
    public function CheckSession()
    {
        $current_time = time();
        if (isset($_SESSION["expire"]) && ($current_time - $_SESSION["expire"]) > Config::SESSION_DESTROY_TIME) {
            unset($_SESSION["expire"]);
            unset($_SESSION["userdata"]);
            echo "1";
        } else {
            echo "0";
        }
    }
}
