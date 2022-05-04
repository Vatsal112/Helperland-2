<?php

require_once("modals/ServiceModal.php");
require_once("modals/UsersModal.php");
require_once("phpmailer/mail.php");
include_once("controllers/calendar/Calendar.php");

class SDashboardController
{
    public $validate;
    public $servicemodal, $usermodal;
    public $errors = [];

    public function __construct()
    {
        $this->data = $_POST;
        $this->servicemodal = new ServiceModal($this->data);
        $this->usermodal = new UsersModal($this->data);
    }


    public function ServiceRequest($request = "")
    {
        if (isset($_SESSION["userdata"])) {
            $result = [[], []];
            $html = "";
            $currentpage = isset($this->data["pagenumber"]) ? $this->data["pagenumber"] : 1;
            $limit = isset($this->data["limit"]) ? $this->data["limit"] : 1;
            $haspets = isset($this->data["haspets"]) ? $this->data["haspets"] : "";
            $offset = ($currentpage - 1) * $limit;
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            switch ($request) {
                case "dashboard":
                    $newservice = $this->servicemodal->TotalServiceRequestBySPId("(0,1)", $userid)[0];
                    $upcoming = $this->servicemodal->TotalServiceRequestBySPId("(2)", $userid)[0];
                    $paymentdue = 0;
                    $result[0] = ["new" => $newservice["Total"], "upcoming" => $upcoming["Total"], "paymentdue" => $paymentdue];
                    break;
                case "newservice":
                    $postal = (isset($this->data["postal"])) ? $this->data["postal"] : "all";
                    if($postal!="all"){
                        $result = $this->servicemodal->getPostalCode($postal);
                        if(count($result[1]) > 0){
                            $postal = "all";
                        }
                    }
                    $result = $this->servicemodal->getAllServiceRequstBySPId($offset, $limit, "(0,1)", $userid, $haspets, $postal);
                    break;
                case "upcoming":
                    $result = $this->servicemodal->getAllServiceRequstBySPId($offset, $limit, "(2)", $userid);
                    break;
                case "schedule":
                    if(isset($this->data["date"])){
                        $date = $this->data["date"];
                    }else{
                        $date = date("Y-m-d");
                    }
                    //echo $date;
                    $calendar = new Calendar($date);
                    $results = $this->servicemodal->getServiceByMonthAndYear($userid, $date, "(2)");
                    //print_r($result);
                    if(count($results)>0){
                        $i=0;
                        foreach($results as $result){
                            $service_starttime = $result["ServiceStartTime"];
                            $service_endtime = $this->convertStrToTime($result["ServiceHours"] + $this->convertTimeToStr($service_starttime));
                            $calendar->add_event($service_starttime." - ".$service_endtime, $result["StartDate"], 1, "appcolor",$i++);
                        }
                    }
                    $result = [$results, $this->errors];
                    $html = $calendar->getCalendarHTML();
                    break;
                case "history":
                    $status = "(3,4,5)";
                    if(isset($this->data["payment"])){
                        switch($this->data["payment"]){
                            case "cancelled": $status = "(3)"; break;
                            case "completed": $status = "(4)"; break;
                            case "refund": $status = "(5)"; break;
                            default: $status = "(3,4,5)"; 
                        }
                    }
                    $result = $this->servicemodal->getAllServiceRequstBySPId($offset, $limit, $status, $userid);
                    break;
                case "ratings":
                    $rating = 0;
                    if(isset($this->data["rating"])){
                        switch($this->data["rating"]){
                            case "excellent": $rating = 5; break;
                            case "verygood": $rating = 4; break;
                            case "good": $rating = 3; break;
                            case "poor": $rating = 2; break;
                            case "verypoor": $rating = 1; break;
                            default: $rating = 0; 
                        }
                    }
                    $result = $this->servicemodal->getAllRatingBySPId($offset, $limit, $userid, $rating);
                    break;
                case "block":
                    $result = $this->servicemodal->getAllFavBlockBySPId($offset, $limit, $userid);
                    break;
            }
            if (count($result[1]) > 0) {
                foreach ($result[1] as $key => $val) {
                    $this->addErrors($key, $val);
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors, "calendar"=>$html]);
    }

    public function UpdateBlockUser()
    {
        $result = [[], []];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $spid = $this->data["spid"];
            if (isset($this->data["b_id"]) && isset($this->data["b_is"]) && $userid==$spid) {
                $id = $this->data["b_id"];
                $is = strtolower($this->data["b_is"]);
                if (in_array($is, ["block", "unblock"])) {
                    $set = ($is == "block") ? 1 : 0;
                    $result[0] = $this->servicemodal->UpdateBlockUser($id, $set);
                } else {
                    $this->addErrors("Invalid", "Data is not valid!!");
                }
            } else {
                $this->addErrors("Invalid", "Somthing went wrong with the data!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);
    }

    public function TotalRequest($request = '')
    {
        $result = [[], []];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $haspets = isset($this->data["haspets"]) ? $this->data["haspets"] : "";
            switch ($request) {
                case "newservice":
                    $postal = (isset($this->data["postal"])) ? $this->data["postal"] : "all";
                    if($postal!="all"){
                        $result = $this->servicemodal->getPostalCode($postal);
                        if(count($result[1]) > 0){
                            $postal = "all";
                        }
                    }
                    $result = $this->servicemodal->TotalServiceRequestBySPId("(0,1)", $userid, $haspets, $postal);
                    break;
                case "upcoming":
                    $result = $this->servicemodal->TotalServiceRequestBySPId("(2)", $userid);
                    break;
                case "history":
                    $status = "(3,4,5)";
                    if(isset($this->data["payment"])){
                        switch($this->data["payment"]){
                            case "cancelled": $status = "(3)"; break;
                            case "completed": $status = "(4)"; break;
                            case "refund": $status = "(5)"; break;
                            default: $status = "(3,4,5)"; 
                        }
                    }
                    $result = $this->servicemodal->TotalServiceRequestBySPId($status, $userid);
                    break;
                case "ratings":
                    $rating = 0;
                    if(isset($this->data["rating"])){
                        switch($this->data["rating"]){
                            case "excellent": $rating = 5; break;
                            case "verygood": $rating = 4; break;
                            case "good": $rating = 3; break;
                            case "poor": $rating = 2; break;
                            case "verypoor": $rating = 1; break;
                            default: $rating = 0; 
                        }
                    }
                    $result = $this->servicemodal->getTotalRatingBySPId($userid, $rating);
                    break;
                case "block":
                    $result = $this->servicemodal->TotalFavoriteAndBlockBySPId($userid);
                    break;
                case "setting":
                    break;
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        if (count($result[1]) > 0) {
            foreach ($result[1] as $key => $val) {
                $this->addErrors($key, $val);
            }
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);
    }

    public function CompleteServiceRequest(){
        $result = 0;
        $mailmsg = "..";
        if (isset($_SESSION["userdata"])) {
            $mailmsg = "...";
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $serviceid = $this->data["serviceid"];
            $spid = $this->data["spid"];
            $service = $this->servicemodal->getServiceRequestById($serviceid);
            if (count($service) > 0 && $spid==$userid) {
                if (!$this->servicemodal->CompleteServiceRequestBySPId($serviceid, $userid)) {
                    $this->addErrors("SQLError", "Something went wrong with the SQL!!");
                }else{
                    $res=$this->servicemodal->InsertFavoriteAndBlocked($service["UserId"], $spid);
                    if(!$res){
                        $this->addErrors("SQLError", "Something went wrong with the SQL!!!");
                    }
                }
            }else{
                $this->addErrors("Invalid", "Service is not found!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors, "mail" => $mailmsg]);
    }

    public function CancelService(){
        $result = 0;
        $mailmsg = "";
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $serviceid = $this->data["serviceid"];
            $spid = $this->data["spid"];
            $comment = $this->data["comment"];
            $service = $this->servicemodal->getServiceRequestById($serviceid);
            if (count($service) > 0 && $spid==$userid) {
                if($service["Status"]==3){
                    $mailmsg = "....";
                    $modifiedby = $service["ModifiedBy"];
                    $modifydate = date("d-m-Y H:i",strtotime($service["ModifiedDate"]));
                    $user_r = $this->usermodal->getUserByUserId($modifiedby);
                    if(count($user_r) > 0){
                        $this->addErrors("login", "Service Request is Cancelled by the ".$user_r['FirstName']." ".$user_r["LastName"]." at $modifydate!!!");
                    }else{
                        $this->addErrors("Invalid", "Service Request is cancelled by someone!!!");
                    }
                }else{
                    $result = $this->servicemodal->CancelServiceBySPId($userid, $serviceid, $comment);
                    if ($result == 1) {
                        $body = "<h1>Service Request <b>" . $service["ServiceRequestId"] . "</h1></b> has been <kbd style='color:red;'><b>cancelled</b></kbd> by the User( $userid ).";
                        $mailmsg = sendmail([$service["CEmail"], Config::ADMIN_EMAIL], "Service Cancelled", $body);
                    }
                }
            }else{
                $this->addErrors("Invalid", "Service is not found!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }
        echo json_encode(["result" => $result, "errors" => $this->errors, "mail" => $mailmsg]);
    }

    public function AcceptServiceRequest()
    {
        $result = [[], []];
        $mailmsg = "";
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $serviceid = $this->data["serviceid"];
            if (count($this->servicemodal->IsAcceptedByAnySP($serviceid)) < 1) {
                $service = $this->servicemodal->getServiceRequestById($serviceid);
                $postalcode = $service["ZipCode"];
                if (count($service) > 0) {
                    if (in_array($service["Status"], [0, 1])) {
                        $startdate = date('Y-m-d', strtotime($service["ServiceStartDate"]));
                        $starttime = date('H:i', strtotime($service["ServiceStartDate"]));
                        $check_status = '(2)';
                        $results = $this->servicemodal->IsUpdateServiceSchedulePossibleOnDate($userid, $startdate, $check_status);
                        if (count($results[1]) > 0) {
                            foreach ($results[1] as $key => $val) {
                                $this->addErrors($key, $val);
                            }
                        } else {
                            $select_starttime = $this->convertTimeToStr($starttime);
                            $select_totalhour = $service["ServiceHours"][0];
                            $select_endtime =  $select_starttime + $select_totalhour;
                            if ($select_starttime + $select_totalhour > 21.0) {
                                $this->addErrors("Invalid", "Could not completed the service request, because service booking request is must be completed within 21:00 time");
                            } else {
                                for ($i = 0; $i < count($results[0]); $i++) {
                                    $res = $results[0][$i];
                                    if ($res["ServiceRequestId"] == $serviceid) {
                                        continue;
                                    }
                                    $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                                    $service_hour = $res["ServiceHours"];
                                    $service_endtime = $service_starttime + $service_hour;
                                    $service_gape = Config::SERVICE_ACCEPT_GAPE;
                                    if (
                                        $select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime ||
                                        (($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime < $service_starttime && ($service_starttime - $select_endtime) < $service_gape)) ||
                                        (($select_starttime > $service_starttime && $select_starttime < $service_endtime) || ($select_starttime > $service_starttime && ($select_starttime - $service_endtime) < $service_gape))
                                    ){
                                        $this->addErrors("Invalid", "Another service request " . substr("000" . $res["ServiceRequestId"], -4) . " has already been assigned which has time overlap with this service request. You can’t pick this one!");
                                        break;
                                    }
                                }
                            }
                        }
                        if (count($this->errors) < 1) {
                            if (!$this->servicemodal->AcceptServiceRequest($serviceid, $userid)) {
                                $this->addErrors("SQLError", "Somthing went wrong with the sql!!!");
                            }else{
                                $emails = [];
                                if(!empty($postalcode)){
                                    $servicers = $this->servicemodal->getServicerEmailByPostalCode($postalcode);
                                    foreach ($servicers as $servicer) {
                                        if($servicer["UserId"]==$userid){
                                            continue;
                                        }
                                        array_push($emails, $servicer["Email"]);
                                    }
                                    $mailmsg = sendmail($emails, "Service is Acepted", "<h2>service request ".substr("000".$serviceid, -4)."  has already been <kbd><b>accepted</b></kbd> by someone and is no more available to you</h2>");
                                }
                                $mailmsg = sendmail([$service["CEmail"]], "Service is Acepted", "<h2>Your service request ".substr("000".$serviceid, -4)." <kbd><b>is accepted</b></kbd> by the servicer<br><kbd>Check Your Dashboard</kbd></h2>");
                            }
                        }
                    }else{
                        $this->addErrors("NotFound", "Service is not longer available!!!");
                    }
                } else {
                    $this->addErrors("NotFound", "Service is not found!!!");
                }
            } else {
                $this->addErrors("accepted", "This service request is no more available. It has been assigned to another provider!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors, "mail" => $mailmsg]);
    }

    /*---------------- Cancel The reque ----------------*/

    /*------------ Convert time(10:30) format to num(10.5) -------------*/
    private function convertTimeToStr($time)
    {
        $time = explode(":", $time);
        $hour = +$time[0];
        $min = 0.0;
        if (count($time) == 2) {
            $min = +$time[1];
            if ($min != 0) {
                $min = 0.5;
            }
        }
        return $hour + $min;
    }

    /*------------ Convert  format num(10.5) to time(10:30) -------------*/
    private function convertStrToTime($str)
    {
        $hour = substr("0" + floor($str), -2);
        $min = "00";
        if ($hour < $str) {
            $min = "30";
        }
        return $hour . ":" . $min;
    }

    /*------------- Set error ------------*/
    private function addErrors($key, $val)
    {
        $this->errors[$key] = $val;
    }

    /*-------------- Show Error -----------*/
    public function showError($title, $errors = [])
    {
        $_SESSION["error_title"] = $title;
        $_SESSION["error_array"] = $errors;
        header("Location: " . Config::BASE_URL . "?controller=Default&function=error");
        exit();
    }
}
