<?php

require_once("modals/ServiceModal.php");
require_once("phpmailer/mail.php");

class CDashboardController
{
    public $validate;
    public $servicemodal;
    public $errors = [];

    public function __construct()
    {
        $this->data = $_POST;
        $this->servicemodal = new ServiceModal($this->data);
    }

    public function TotalRequest($request='')
    {   
        $result = [[],[]];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            switch ($request) {
                case "service-history":
                    $status = '(3,4,5)';
                    $result = $this->servicemodal->TotalRequestByUserId($userid, $status);
                    break;
                case "favorite-pros":
                    $result = $this->servicemodal->TotalFavoriteAndBlockByUserId($userid);
                    break;
                case "dashboard":
                    $status = '(0,1,2)';
                    $result = $this->servicemodal->TotalRequestByUserId($userid, $status);
                    break;
                default:
                    $status = '(0,1,2)';
                    $result = $this->servicemodal->TotalRequestByUserId($userid, $status);
            }
        }else {
            $this->addErrors("login", "User is not login!!!");
        }
            
        if (count($result[1]) > 0) {
            foreach ($result[1] as $key => $val) {
                $this->addErrors($key, $val);
            }
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);
    }

    public function ServiceRequest($request = "")
    {
        if (isset($_SESSION["userdata"])) {
            $result = [[], []];
            $currentpage = $this->data["pagenumber"];
            $limit = $this->data["limit"];
            $offset = ($currentpage - 1) * $limit;
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            switch ($request) {
                case "service-history":
                    $status = '(3,4,5)';
                    $result = $this->servicemodal->getAllServiceRequestByUserId($offset, $limit, $userid, $status);
                    break;
                case "favorite-pros":
                    $result = $this->servicemodal->getFavoriteAndBlockedList($userid);
                    break;
                case "dashboard":
                    $status = '(0,1,2)';
                    $result = $this->servicemodal->getAllServiceRequestByUserId($offset, $limit, $userid, $status);
                    break;
                default:
                    $status = '(0,1,2)';
                    $result = $this->servicemodal->getAllServiceRequestByUserId($offset, $limit, $userid, $status);
            }
            if (count($result[1]) > 0) {
                foreach ($result[1] as $key => $val) {
                    $this->addErrors($key, $val);
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);
    }

    public function UpdateServiceSchedule()
    {
        $result = [[], []];
        $mailmsg = "";
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            if (isset($this->data["serviceid"])) {
                $serviceid = $this->data["serviceid"];
                $service = $this->servicemodal->getServiceRequestById($serviceid);
                if (count($service) > 0) {
                    $startdate = date('Y-m-d', strtotime($this->data["date"]));
                    $spid = $service["ServiceProviderId"];
                    $check_status = '(0,1,2)';
                    $results = $this->servicemodal->IsUpdateServiceSchedulePossibleOnDate($spid, $startdate, $check_status);
                    if (count($results[1]) > 0) {
                        foreach ($results[1] as $key => $val) {
                            $this->addErrors($key, $val);
                        }
                    } else {
                        $select_starttime = $this->data["time"];
                        $select_totalhour = $service["ServiceHours"][0];
                        $select_endtime =  $select_starttime + $select_totalhour;
                        if ($select_starttime + $select_totalhour > 21.0) {
                            $this->addErrors("Invalid", "Could not completed the service request, because service booking request is must be completed within 21:00 time");
                        } else {
                            for ($i = 0; $i < count($results[0]); $i++) {
                                $res = $results[0][$i];
                                if($res["ServiceRequestId"]==$serviceid){
                                    continue;
                                }
                                $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                                $service_hour = $res["ServiceHours"][0];
                                $service_endtime = $service_starttime + $service_hour;
                                //if ($select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime || ($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime > $service_starttime && $select_starttime < $service_endtime)) {
                                if($select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime ||
                                   ($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($service_starttime-$select_endtime) < 1 ||
                                   ($select_starttime > $service_starttime && $select_starttime < $service_endtime) || ($select_starttime-$service_endtime) < 1){
                                    $this->addErrors("Invalid", "Another service request has been assigned to the service provider on $startdate from ".$this->convertStrToTime($service_starttime)." to ".$this->convertStrToTime($service_endtime).". Either choose another date or pick up a different time slot");
                                    break;
                                }
                            } 
                        }

                        // check user is laready request to reschude service
                        $record_version = 0;
                        $status = $service["Status"];
                        if($service["Status"]==2 && (is_null($service["RecordVersion"]) || $service["RecordVersion"]==0)){
                            $record_version = 1;
                            $status = 1;
                        }else if($service["Status"]==1 && $service["RecordVersion"]==1){
                            $this->addErrors("Service", "You can't rescheduled service request.untill Your SP will accept it");
                        }

                        // if no errors then update date and time
                        $mailmsg = ""; 
                        if(!(count($this->errors) > 0)){
                            $update = $this->servicemodal->UpdateSerivceScheduleById($startdate, $select_starttime, $serviceid, $userid, $status, $record_version);
                            if(!$update){
                                $this->addErrors("Wrong", "Somthing went wrong with the update");
                            }else{
                                if(!is_null($service["SPEmail"])){
                                    $body = "<h1>Service Request <b>".$service["ServiceRequestId"]."</h1></b> has been rescheduled by customer. New date and time are <b>$startdate ".$this->convertStrToTime($select_starttime)."</b>";
                                    $mailmsg = sendmail([$service["SPEmail"]], "Service Reschedule", $body);
                                }
                            }
                        }
                    }
                } else {
                    $this->addErrors("Invalid", "Service Request Not Found");
                }
            } else {
                $this->addErrors("Invalid", "Service Id is not found!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors, "mail" => $mailmsg]);
    }

    public function UpdateFavouriteUser(){
        $result = [[],[]];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            if(isset($this->data["f_id"]) && isset($this->data["f_is"])){
                $id = $this->data["f_id"];
                $is = strtolower($this->data["f_is"]);
                if(in_array($is, ["favourite", "unfavourite"])){
                    $set = ($is=='favourite') ? 1 : 0;
                    $result[0] = $this->servicemodal->UpdateFavouriteUser($id, $set);
                }else{
                    $this->addErrors("Invalid", "Data is not valid!!");
                }
            } else{
                $this->addErrors("Invalid", "Somthing went wrong with the data!!!");
            }
        }else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);   
    }
    public function UpdateBlockUser(){
        $result = [[],[]];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            if(isset($this->data["b_id"]) && isset($this->data["b_is"])){
                $id = $this->data["b_id"];
                $is = strtolower($this->data["b_is"]);
                if(in_array($is, ["block", "unblock"])){
                    $set = ($is=="block") ? 1 : 0;
                    $result[0] = $this->servicemodal->UpdateBlockUser($id, $set);
                }else{
                    $this->addErrors("Invalid", "Data is not valid!!");
                }
            } else{
                $this->addErrors("Invalid", "Somthing went wrong with the data!!!");
            }
        }else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors]);
    }

    public function CancelService(){
        $result = 0;
        $mailmsg = "";
        if(isset($_SESSION["userdata"])){
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $serviceid = $this->data["serviceid"];
            $comment = $this->data["comment"];
            $result = $this->servicemodal->CancelServiceById($userid, $serviceid, $comment);
            if($result==1){
                $service = $this->servicemodal->getServiceRequestById($serviceid);
                if(count($service) > 0){
                    $body = "<h1>Service Request <b>".$service["ServiceRequestId"]."</h1></b> has been <kbd style='color:red;'><b>cancelled</b></kbd> by the customer.";
                    $mailmsg = sendmail([$service["SPEmail"]], "Service Cancelled", $body);
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result, "errors" => $this->errors, "mail"=>$mailmsg]);
    }

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
    private function convertStrToTime($str){
        $hour = substr("0"+floor($str), -2);
        $min = "00";
        if($hour<$str){
            $min = "30";
        }
        return $hour.":".$min;
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
