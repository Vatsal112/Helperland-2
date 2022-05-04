<?php

require_once("validation/contactusvalidator.php");
require_once("phpmailer/mail.php");
require_once("modals/ContactUsModal.php");

class ContactUsController
{
    public $data;
    public $contactModal;
    function __construct()
    {
        $this->data = $_POST;
        $this->contactModal = new ContactUsModal($this->data);
    }
    function insertContactForm()
    {
        //server side validation
        if (isset($_POST["contactus"])) {
            $validator = new ContactUsValidator($_POST);
            $errors = $validator->isContactUsFormValidate();
            if (!count($errors) > 0) {
                //store attachemnet if available
                $newfilename = "";
                $target_dir = "";
                if (isset($_FILES["Attachment"]) && !empty($_FILES["Attachment"]["name"])) {
                    $validate_error = $validator->isFileValidate($_FILES);
                    if (!count($validate_error) > 0) {
                        $newfilename = $_FILES["Attachment"]["name"];
                        $target_dir = "static/attachments/" . $newfilename;
                        $file_temp_loc = $_FILES["Attachment"]["tmp_name"];
                        if (!move_uploaded_file($file_temp_loc, $target_dir)) {
                            $this->showError("file failed to upload!!", [] );
                        }
                    } else {
                        $this->showError("File is not validate", $validate_error );
                    }
                }
                //insert data into the database
                $this->data["FileName"] = $newfilename;
                $this->data["FileLocation"] = $target_dir;
                $data = $this->contactModal->insertContactData($newfilename, $target_dir);
                if (!count($data[1]) > 0) {
                    //send mail to the admin
                    $this->sendEmailToAdmin();
                } else {
                    $this->showError("somthing went wrong", $data[1] );
                }
                setcookie("contact_success", "successfully", time() + 3600, '/');
                header("Location: " . Config::BASE_URL . "?controller=Default&function=contact");
            } else {
                $this->showError("Form is not validated", $errors);
            }
        } else {
            $this->showError("Failed to register!!!", array("Invalid field name!!!"));
        }
    }

    private function sendEmailToAdmin()
    {

        $name = ucwords($this->data["FirstName"] . " " . $this->data["LastName"]);
        date_default_timezone_set("Asia/Kolkata");
        $current_time = date("Y-m-d h:i:sa");
        $phonenumber = $this->data["Mobile"];
        $email = $this->data["Email"];
        $subject = $this->data["Subject"];
        $message = strtolower($this->data["Message"]);
        $html = "
            <div>
                <h1 style='border-bottom:1px solid #6e6e6e; font-weight:300;'>Contacer Detailes</h1>
                <h2 style='margin:5px 2px;'>$name <span style='color:#4287f5; font-size:14px;'>( $current_time )</span></h2>
                <h4 style='margin:5px 2px;'>Mobile: $phonenumber</h4>
                <h4 style='margin:5px 2px;'>Email: $email</h4>
                
            </div>
            <div>
                <h2 style='border-bottom:1px solid #6e6e6e; font-weight:300;'>Message</h2>
                <h3 style='color:black;'>\"$message\"</h3>
            </div>
        ";
        $attachment = "";
        if (!empty($this->data["FileName"])) {
            $attachment = $this->data["FileLocation"];
            $html = $html . "
                <div>
                    **You can see my attachment for more clearity**
                </div>
            ";
        }
        sendmail([Config::ADMIN_EMAIL], $subject, $html, $attachment);
    }

    /*-------------- Show Error -----------*/
    public function showError($title, $errors = [])
    {
        $_SESSION["error_title"] = $title;
        $_SESSION["error_array"] = $errors;
        header("Location: ".Config::BASE_URL."?controller=Default&function=error");
        exit();
    }
}
