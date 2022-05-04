<?php

require_once("modals/ServiceModal.php");
require_once("modals/UsersModal.php");
require_once("phpmailer/mail.php");

class ADashboardController
{
    public $validate;
    public $servicemodal, $usersmodal;
    public $errors = [];

    public function __construct()
    {
        $this->data = $_POST;
        $this->servicemodal = new ServiceModal($this->data);
        $this->usersmodal = new UsersModal($this->data);
    }

    public function TotalRequest($request = '')
    {
        $result = [[], []];
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            switch ($request) {
                case "usermanagement":
                    $result = $this->servicemodal->TotalUsersForAdmin();
                    break;
                default:
                    $result = $this->servicemodal->TotalRequestForAdmin();
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

    public function ServiceRequest($request = "")
    {
        if (isset($_SESSION["userdata"])) {
            $result = [[], []];
            $currentpage = $this->data["pagenumber"];
            $limit = $this->data["limit"];
            $offset = ($currentpage - 1) * $limit;
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $cust = [[], []];
            $serv = [[], []];
            $allusers = [[], []];
            switch ($request) {
                case "usermanagement":
                    $result = $this->servicemodal->getAllUsersForAdmin($offset, $limit);
                    $allusers = $this->servicemodal->getAllUsers();
                    break;
                default:
                    $result = $this->servicemodal->getAllServiceRequestForAdmin($offset, $limit);
                    $cust = $this->servicemodal->getAllCustomerForAdmin();
                    $serv = $this->servicemodal->getAllServicerForAdmin();
            }
            if (count($result[1]) > 0 || count($cust[1]) > 0 || count($serv[1]) > 0) {
                $errors = $result[1] + $cust[1] + $serv[1];
                foreach ($errors as $key => $val) {
                    $this->addErrors($key, $val);
                }
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "Customer" => $cust[0], "Servicer" => $serv[0], "alluser" => $allusers[0], "errors" => $this->errors]);
    }

    public function RefundAmount(){
        $result = [[], []];
        $mailmsg = "";
        if (isset($_SESSION["userdata"]) && isset($this->data["adid"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $adid = $this->data["adid"];
            if ($userid == $adid) {
                if (isset($this->data["re-servid"])) {
                    $serviceid = $this->data["re-servid"];
                    $service = $this->servicemodal->getServiceRequestById($serviceid);
                    if (count($service) > 0) {
                        $refunded = $this->data["re-total"];
                        $refunded_amt = is_null($service["RefundedAmount"])? 0 : $service["RefundedAmount"];
                        if($refunded <= ($service["TotalCost"]-$refunded_amt)){
                            $comment = $this->data["re-comment"];
                            if(!$this->servicemodal->RefundAmount($adid, $serviceid, $refunded, $comment)){
                                $this->addErrors("SQLError", "Somthing Went wrong with the SQL");
                            }
                        }else{
                            $this->addErrors("Invalid", "Invalid Amount");
                        }
                    }else {
                        $this->addErrors("Invalid", "Service Request Not Found");
                    }
                } else {
                    $this->addErrors("Invalid", "Service Id is not found!!!");
                }
            } else {
                $this->addErrors("Invalid", "Invalid Request");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors, "mail" => $mailmsg]);
    }

    public function EditServiceDetailes()
    {
        $result = [[], []];
        $mailmsg = "";
        if (isset($_SESSION["userdata"]) && isset($this->data["adid"])) {
            $user = $_SESSION["userdata"];
            $userid = $user["UserId"];
            $adid = $this->data["adid"];
            if ($userid == $adid) {
                if (isset($this->data["serviceid"])) {
                    $serviceid = $this->data["serviceid"];
                    $service = $this->servicemodal->getServiceRequestById($serviceid);
                    if (count($service) > 0) {
                        $startdate = date('Y-m-d', strtotime(str_replace('/', '-', $this->data["date"])));
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
                                    if ($res["ServiceRequestId"] == $serviceid) {
                                        continue;
                                    }
                                    $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                                    $service_hour = $res["ServiceHours"][0];
                                    $service_endtime = $service_starttime + $service_hour;
                                    $service_gape = Config::SERVICE_ACCEPT_GAPE;
                                    if(
                                        $select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime ||
                                        (($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime < $service_starttime && ($service_starttime - $select_endtime) < $service_gape)) ||
                                        (($select_starttime > $service_starttime && $select_starttime < $service_endtime) || ($select_starttime > $service_starttime && ($select_starttime - $service_endtime) < $service_gape))
                                    ){
                                        $this->addErrors("Invalid", "Another service request " . substr("000" . $res["ServiceRequestId"], -4) . " has already been assigned to Servicer(ID: ".$res['ServiceProviderId'].") which has time overlap with this service request. You can’t Reschdule this one!");
                                        break;
                                    }
                                }
                            }

                            // check user is already request to reschedule service
                            $record_version = 0;
                            $status = $service["Status"];
                            if ($service["Status"] == 2 && (is_null($service["RecordVersion"]) || $service["RecordVersion"] == 0)) {
                                $record_version = 1;
                                $status = 1;
                            } else if ($service["Status"] == 1 && $service["RecordVersion"] == 1) {
                                $this->addErrors("Service", "You already reschdule a service wait untill the servicer accept it");
                            }

                            // if no errors then update date and time
                            $mailmsg = "";
                            if (!(count($this->errors) > 0)) {
                                $comment = isset($this->data["comment"]) ? $this->data["comment"] : "";
                                $update = $this->servicemodal->UpdateSerivceScheduleById($startdate, $select_starttime, $serviceid, $userid, $status, $record_version, $comment);
                                if (!$update) {
                                    $this->addErrors("Wrong", "Somthing went wrong with the update schedule");
                                } else {
                                    $updateaddress = $this->usersmodal->updateServiceRequestAddress($service["ServiceRequestId"]);
                                    if (count($updateaddress[1]) > 0) {
                                        $this->addErrors("Wrong", "Somthing went wrong with the update useraddress");
                                    } else {
                                        $body = "<h1>Service Request <b>" . $service["ServiceRequestId"] . "</h1></b> has been rescheduled by Admin. New date and time are <b>$startdate " . $this->convertStrToTime($select_starttime) . "</b>";
                                        $emails = [$service["CEmail"]];
                                        if (!is_null($service["SPEmail"])) {
                                            $emails[] = $service["SPEmail"];
                                        }
                                        $mailmsg = sendmail($emails, "Service Edit & Reschedule", $body);
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
                $this->addErrors("Invalid", "Invalid Request");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }

        echo json_encode(["result" => $result[0], "errors" => $this->errors, "mail" => $mailmsg]);
    }

    public function SetApprovedByAdmin()
    {
        $result = 0;
        if (isset($_SESSION["userdata"])) {
            $user = $_SESSION["userdata"];
            if (isset($this->data["aid"]) && isset($this->data["userid"]) && $this->data["aid"] == $user["UserId"]) {
                $userid = $this->data["userid"];
                $adminid = $this->data["aid"];
                if ($this->usersmodal->IsUserExists($userid)) {
                    if ($this->usersmodal->UpdateApprovalByAdmin($adminid, $userid)) {
                        $result = 1;
                    } else {
                        $this->addErrors("SQLError", "Somthing Went Wrong with the SQL!!!");
                    }
                } else {
                    $this->addErrors("Invalid", "Invalid Reuqest!!!");
                }
            } else {
                $this->addErrors("Invalid", "Invalid Reuqest!!!");
            }
        } else {
            $this->addErrors("login", "User is not login!!!");
        }
        echo json_encode(["result" => $result, "errors" => $this->errors]);
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
