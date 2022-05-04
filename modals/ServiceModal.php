<?php
require_once("db_connection.php");

class ServiceModal extends Connection
{
    public $data;
    public $conn;
    public $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
        $this->conn = $this->connect();
    }

    // check service is accepted by any servicer provider
    public function IsAcceptedByAnySP($serviceid)
    {
        $sql = "SELECT * FROM servicerequest WHERE ServiceRequestId=$serviceid AND Status=2";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    // update service time slot
    public function IsUpdateServiceSchedulePossibleOnDate($favsp, $startdate, $status)
    {
        // if service is already assign to service provider then check 
        // slot will be available on selected slot
        if (!is_null($favsp)) {
            $services = $this->getServiceByStartDateSPAndStatus($favsp, $startdate, $status);
        } else {
            $services = [];
        }
        return [$services, $this->errors];
    }

    // accept the service request
    public function AcceptServiceRequest($serviceid, $spid)
    {
        $record_version = 0;
        $sql = "UPDATE servicerequest SET ServiceProviderId=$spid, SPAcceptedDate=now(), RecordVersion=$record_version, Status=2 WHERE ServiceRequestId=$serviceid";
        //echo $sql;
        return $this->conn->query($sql);
    }

    // complete the service request
    public function CompleteServiceRequestBySPId($serviceid, $spid)
    {
        $sql = "UPDATE servicerequest SET Status=4 WHERE ServiceRequestId=$serviceid AND ServiceProviderId=$spid";
        //echo $sql;
        return $this->conn->query($sql);
    }

    //
    public function UpdateFavouriteUser($f_id, $set)
    {
        if ($set == 1) {
            $sql = "UPDATE favoriteandblocked SET IsFavorite=$set, IsBlocked=0 WHERE Id=$f_id;";
        } else {
            $sql = "UPDATE favoriteandblocked SET IsFavorite=$set WHERE Id=$f_id;";
        }
        $result = $this->conn->query($sql);
        if ($result) {
            return $set;
        }
    }
    public function UpdateBlockUser($b_id, $set)
    {
        if ($set == 1) {
            $sql = "UPDATE favoriteandblocked SET IsBlocked=$set, IsFavorite=0   WHERE Id=$b_id;";
        } else {
            $sql = "UPDATE favoriteandblocked SET IsBlocked=$set WHERE Id=$b_id;";
        }
        $result = $this->conn->query($sql);
        if ($result) {
            return $set;
        }
    }

    public function UpdateSerivceScheduleById($startdate, $starttime, $serviceId, $modifiedby, $status, $record_version, $comment = "")
    {

        // for fromatting datetime
        $date = new DateTime($startdate);
        $date->setTime(floor($starttime), floor($starttime) == $starttime ? "00" : (("0." . substr($starttime, -1) * 60) * 100));
        $datetime = $date->format('Y-m-d H:i:s');

        $sql = "UPDATE servicerequest SET ServiceStartDate='$datetime', ModifiedBy=$modifiedby, ModifiedDate=now(), Status=$status, RecordVersion=$record_version, Comments='$comment' WHERE ServiceRequestId=$serviceId";
        //echo $sql;
        $result = $this->conn->query($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function RefundAmount($modifiedby, $serviceid, $refunded_amt, $comment)
    {
        $sql = "UPDATE servicerequest SET RefundedAmount=RefundedAmount+$refunded_amt, ModifiedBy=$modifiedby, ModifiedDate=now(), Status=5, Comments='$comment' WHERE ServiceRequestId=$serviceid";
        //echo $sql;
        $result = $this->conn->query($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getServiceByMonthAndYear($spid, $startdate, $status)
    {
        $startdate = date("Y-m", strtotime($startdate));
        //$sql = "SELECT sr.ServiceRequestId, DATE_FORMAT(sr.ServiceStartDate, '%H:%i') as ServiceStartTime,DATE_FORMAT(sr.ServiceStartDate, '%Y-%m-%d') as StartDate, sr.ServiceHours, sr.Status, user.Email FROM servicerequest AS sr JOIN user ON user.UserId = sr.ServiceProviderId WHERE sr.ServiceProviderId = $favsp AND sr.Status IN $status AND sr.ServiceStartDate LIKE '%$startdate%';";
        $sql = "SELECT sr.ServiceRequestId, DATE_FORMAT(sr.ServiceStartDate, '%H:%i') as ServiceStartTime,DATE_FORMAT(sr.ServiceStartDate, '%Y-%m-%d') as StartDate, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate,sr.ServiceHours,sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status,sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sre.ServiceExtraId, user.FirstName, user.LastName, user.Email FROM servicerequest AS sr JOIN user ON user.UserId = sr.UserId JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId WHERE sr.ServiceProviderId = $spid AND sr.Status IN $status AND sr.ServiceStartDate LIKE '%$startdate%';";
        $services = $this->conn->query($sql);
        $rows = [];
        //echo $sql;
        if ($services->num_rows > 0) {
            // check any slot time with selected time
            while ($row = $services->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return $rows;
    }

    public function getServiceByStartDateSPAndStatus($favsp, $startdate, $status)
    {
        $sql = "SELECT sr.ServiceRequestId, DATE_FORMAT(sr.ServiceStartDate, '%H:%i') as ServiceStartTime,DATE_FORMAT(sr.ServiceStartDate, '%Y-%m-%d') as ServiceStartDate, sr.ServiceHours, sr.Status, sr.ServiceProviderId, user.Email FROM servicerequest AS sr JOIN user ON user.UserId = sr.ServiceProviderId WHERE sr.ServiceProviderId = $favsp AND sr.Status IN $status AND sr.ServiceStartDate LIKE '%$startdate%';";
        $services = $this->conn->query($sql);
        $rows = [];
        //echo $sql;
        if ($services->num_rows > 0) {
            while ($row = $services->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return $rows;
    }

    public function isFavoriteBlockedExits($custid, $spid)
    {
        $sql = "SELECT * FROM favoriteandblocked WHERE UserId=$custid AND TargetUserId=$spid";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function IsUserBlockedByTheCustomerORServicer($custid, $spid)
    {
        if ($this->isFavoriteBlockedExits($custid, $spid)) {
            $sql = "SELECT * FROM favoriteandblocked WHERE UserId=$custid AND TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE UserId=$spid AND TargetUserId=$custid AND IsBlocked=0) AND IsBlocked=0";
            $result = $this->conn->query($sql);
            //echo $sql;
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function getAllPostalWhereServiceAvailable($status = "(0,1)")
    {
        $sql = "SELECT DISTINCT sra.PostalCode FROM servicerequestaddress AS sra JOIN servicerequest AS sr ON sra.ServiceRequestId = sr.ServiceRequestId WHERE sr.Status IN $status";
        $result = $this->conn->query($sql);
        $postal = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($postal, $row["PostalCode"]);
            }
        }
        return $postal;
    }

    public function getAllServiceRequstBySPId($offset, $limit, $status, $spid, $haspets = "", $postal = "all")
    {
        $haspets = ($haspets != "" && $haspets == 0) ? "(0)" : "(0,1)";
        if ($status == "(0,1)") {
            //$sql = "SELECT sr.ServiceRequestId, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId, user.FirstName, user.LastName FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId JOIN user ON user.UserId=sr.UserId WHERE sr.HasPets IN $haspets AND (sr.ServiceProviderId IS NULL OR sr.ServiceProviderId=$spid) AND  sr.Status IN $status ORDER BY sr.ServiceRequestId DESC LIMIT $offset, $limit";
            if ($postal == "all") {
                $sql = "SELECT sr.ServiceRequestId, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId, user.FirstName, user.LastName FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId JOIN user ON user.UserId=sr.UserId LEFT JOIN favoriteandblocked AS f1 ON f1.UserId = sr.UserId LEFT JOIN favoriteandblocked AS f2 ON f2.TargetUserId = sr.UserId WHERE sr.HasPets IN $haspets AND ((f2.UserId = $spid AND f1.TargetUserId=$spid AND f1.IsBlocked = 0 AND f2.IsBlocked = 0) OR (f1.TargetUserId IS NULL OR f1.TargetUserId IN (SELECT UserId FROM user WHERE UserTypeId = 2 AND IsApproved=1))) AND (sr.ServiceProviderId IS NULL OR sr.ServiceProviderId=$spid) AND  sr.Status IN $status GROUP BY sr.ServiceRequestId ORDER BY sr.ServiceRequestId DESC LIMIT $offset, $limit";
            } else {
                $sql = "SELECT DISTINCT sr.ServiceRequestId, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId, user.FirstName, user.LastName FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId JOIN user ON user.UserId=sr.UserId LEFT JOIN favoriteandblocked AS f1 ON f1.UserId = sr.UserId LEFT JOIN favoriteandblocked AS f2 ON f2.TargetUserId = sr.UserId WHERE sra.PostalCode=$postal AND sr.HasPets IN $haspets AND ((f2.UserId = $spid AND f1.TargetUserId=$spid AND f1.IsBlocked = 0 AND f2.IsBlocked = 0) OR (f1.TargetUserId IS NULL OR f1.TargetUserId IN (SELECT UserId FROM user WHERE UserTypeId = 2 AND IsApproved=1))) AND (sr.ServiceProviderId IS NULL OR sr.ServiceProviderId=$spid) AND  sr.Status IN $status GROUP BY sr.ServiceRequestId ORDER BY sr.ServiceRequestId DESC LIMIT $offset, $limit";
            }
        } else {
            $sql = "SELECT sr.ServiceRequestId, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId, user.FirstName, user.LastName FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId JOIN user ON user.UserId=sr.UserId WHERE sr.HasPets IN $haspets AND (sr.ServiceProviderId = $spid AND sr.Status IN $status) ORDER BY sr.ServiceRequestId DESC LIMIT $offset, $limit";
        }
        $result = $this->conn->query($sql);
        $services = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!is_null($row["ServiceProviderId"])) {
                    $spid = $row["ServiceProviderId"];
                    $serviceid = $row["ServiceRequestId"];
                    $rating = $this->getRatingByIds($serviceid);
                    $spratings = $this->getSPDetailesBySPId($spid);
                    $row = $row + $spratings + $rating;
                }
                array_push($services, $row);
            }
        } else {
            $services = [];
        }
        return [$services, $this->errors];
    }

    // get servicer request by sp id 
    public function TotalServiceRequestBySPId($status, $spid, $haspets = "", $postal = "all")
    {
        $haspets = ($haspets != "" && $haspets == 0) ? "(0)" : "(0,1)";
        if ($status == "(0,1)") {
            //$sql = "SELECT COUNT(*) as Total FROM servicerequest WHERE HasPets IN $haspets AND (ServiceProviderId IS NULL OR ServiceProviderId=$spid) AND Status IN $status";
            if ($postal == "all") {
                $sql = "SELECT * FROM servicerequest AS sr WHERE sr.HasPets IN $haspets AND (sr.ServiceProviderId IS NULL OR sr.ServiceProviderId=$spid) AND sr.Status IN $status";
            } else {
                $sql = "SELECT sr.* FROM servicerequest AS sr JOIN servicerequestaddress as sra ON sra.ServiceRequestId = sr.ServiceRequestId WHERE sra.PostalCode=$postal AND sr.HasPets IN $haspets AND (sr.ServiceProviderId IS NULL OR sr.ServiceProviderId=$spid) AND sr.Status IN $status";
            }
            // echo $sql;
        } else {
            $sql = "SELECT * FROM servicerequest WHERE HasPets IN $haspets AND (ServiceProviderId=$spid AND Status IN $status)";
        }
        //echo $sql;
        $res = $this->conn->query($sql);
        $total = 0;
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $custid = $row["UserId"];
                if ($status == "(0,1)" && !$this->IsUserBlockedByTheCustomerORServicer($custid, $spid)) {
                    continue;
                }
                $total++;
            }
            //echo $total;
            $result["Total"] = $total;
        } else {
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    // get all rating detailes by sp id
    public function getAllRatingBySPId($offset, $limit, $spid, $rating = 0)
    {
        if ($rating == 0) {
            $sql = "SELECT rating.*, sr.ServiceStartDate, sr.ServiceHours, user.FirstName, user.LastName FROM rating JOIN servicerequest AS sr ON sr.ServiceRequestId = rating.ServiceRequestId JOIN user ON user.UserId = sr.UserId WHERE RatingTo=$spid AND Ratings>=0 AND Ratings<=5 LIMIT $offset, $limit";
        } else {
            $up = $rating + 1;
            $sql = "SELECT rating.*, sr.ServiceStartDate, sr.ServiceHours, user.FirstName, user.LastName FROM rating JOIN servicerequest AS sr ON sr.ServiceRequestId = rating.ServiceRequestId JOIN user ON user.UserId = sr.UserId WHERE RatingTo=$spid AND Ratings>=$rating AND Ratings<$up LIMIT $offset, $limit";
        }
        //echo $sql;
        $result = $this->conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return [$rows, $this->errors];
    }

    // get all favorite and blocked records by the spid 
    public function getAllFavBlockBySPId($offset, $limit, $spid)
    {
        $sql = "SELECT fb.*, CONCAT(user.FirstName,' ', user.LastName) as FullName, user.UserProfilePicture FROM favoriteandblocked as fb JOIN user ON user.UserId = fb.TargetUserId WHERE fb.UserId=$spid AND fb.TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE TargetUserId=$spid AND IsBlocked=0) LIMIT $offset, $limit";
        $result = $this->conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return [$rows, $this->errors];
    }

    // get all the service by service request id
    public function getAllServiceRequestByUserId($offset, $limit, $userid, $status = "")
    {
        if ($status != "") {
            $sql = "SELECT sr.ServiceRequestId, sr.ServiceStartDate, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId WHERE sr.UserId = $userid AND sr.Status IN $status LIMIT $offset, $limit";
            $result = $this->conn->query($sql);
            $services = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (!is_null($row["ServiceProviderId"])) {
                        $spid = $row["ServiceProviderId"];
                        $serviceid = $row["ServiceRequestId"];
                        $rating = $this->getRatingByIds($serviceid);
                        $spratings = $this->getSPDetailesBySPId($spid);
                        $row = $row + $spratings + $rating;
                    }
                    array_push($services, $row);
                }
            } else {
                $services = [];
            }
        } else {
            $this->addErrors("missing", "Paramter missing!!");
        }
        return [$services, $this->errors];
    }

    public function getFavoriteAndBlockedList($userid)
    {
        $sql = "SELECT fb.*, CONCAT(user.FirstName,' ', user.LastName) as FullName, user.UserProfilePicture FROM favoriteandblocked as fb JOIN user ON user.UserId = fb.TargetUserId WHERE fb.UserId=$userid AND fb.TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE TargetUserId=$userid AND IsBlocked=0);";
        //echo $sql;
        $result = $this->conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $spid = $row["TargetUserId"];
                $sprating = $this->getSPDetailesBySPId($spid);
                array_push($rows, $row + $sprating);
            }
        }
        return [$rows, $this->errors];
    }

    // get total rating records given to the customer
    public function getTotalRatingBySPId($spid, $rating = 0)
    {
        if ($rating == 0) {
            $sql = "SELECT count(*) AS Total FROM rating WHERE RatingTo=$spid AND Ratings>=0 AND Ratings<=5";
        } else {
            $up = $rating + 1;
            $sql = "SELECT count(*) AS Total FROM rating WHERE RatingTo=$spid AND Ratings>=$rating AND Ratings<$up";
        }
        //echo $sql;
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    // get total favorite and blocked by the servicer id
    public function TotalFavoriteAndBlockBySPId($spid)
    {
        $sql = "SELECT COUNT(*) as Total FROM favoriteandblocked WHERE TargetUserId=$spid AND IsBlocked=0";
        $result = $this->conn->query($sql);
        //echo $sql;
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    /* for admin special */
    public function getAllServiceRequestForAdmin($offset, $limit)
    {
        $service_id = isset($this->data["serviceid"]) ? (empty($this->data["serviceid"]) ? 1 : 'sr.ServiceRequestId = ' . $this->data["serviceid"]) : 1;
        $postal = isset($this->data["postal"]) ? (empty($this->data["postal"]) ? 1 : 'sra.PostalCode = ' . $this->data["postal"]) : 1;
        $email = isset($this->data["email"]) ? (empty($this->data["email"]) ? 1 : "sra.Email = '" . $this->data["email"] . "'") : 1;
        $custid = isset($this->data["custid"]) ? (empty($this->data["custid"]) ? 1 : 'cust.UserId = ' . $this->data["custid"]) : 1;
        $servid = isset($this->data["servid"]) ? (empty($this->data["servid"]) ? 1 : 'serv.UserId = ' . $this->data["servid"]) : 1;
        $status = isset($this->data["status"]) ? (empty($this->data["status"]) ? 1 : 'sr.Status = ' . (($this->data["status"] == -1) ? 0 : $this->data["status"])) : 1;
        $hasissue = isset($this->data["hasissue"]) ? (empty($this->data["hasissue"]) ? 1 : 'sr.HasIssue = ' . $this->data["hasissue"]) : 1;
        $todate =  isset($this->data["todate"]) ? (empty($this->data["todate"]) ? "3000-01-01" : $this->data["todate"]) : "3000-01-01";
        $fromdate =  isset($this->data["fromdate"]) ? (empty($this->data["fromdate"]) ? "1900-01-01" : $this->data["fromdate"]) : "1900-01-01";
        $sql = "SELECT sr.ServiceRequestId, sr.ServiceStartDate, sr.ServiceHourlyRate, sr.ServiceHours, sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status, sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.Comments, sr.RefundedAmount, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sra.Email, sre.ServiceExtraId, CONCAT(cust.FirstName,' ', cust.LastName) as CustName, CONCAT(serv.FirstName,' ', serv.LastName) as ServName FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId JOIN user AS cust ON cust.UserId = sr.UserId LEFT JOIN user AS serv ON serv.UserId = sr.ServiceProviderId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId 
         WHERE 1 AND $service_id AND $postal AND $email AND $custid AND $servid AND $status AND $hasissue AND DATE(sr.ServiceStartDate) >= '$fromdate' AND DATE(sr.ServiceStartDate) <= '$todate' ORDER BY sr.ServiceRequestId DESC LIMIT $offset, $limit";
        //echo $sql;
        $result = $this->conn->query($sql);
        $services = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!is_null($row["ServiceProviderId"])) {
                    $spid = $row["ServiceProviderId"];
                    $serviceid = $row["ServiceRequestId"];
                    $rating = $this->getRatingByIds($serviceid);
                    $spratings = $this->getSPDetailesBySPId($spid);
                    $row = $row + $spratings + $rating;
                }
                array_push($services, $row);
            }
        } else {
            $services = [];
        }
        return [$services, $this->errors];
    }

    public function TotalRequestForAdmin()
    {
        $service_id = isset($this->data["serviceid"]) ? (empty($this->data["serviceid"]) ? 1 : 'sr.ServiceRequestId = ' . $this->data["serviceid"]) : 1;
        $postal = isset($this->data["postal"]) ? (empty($this->data["postal"]) ? 1 : 'sra.PostalCode = ' . $this->data["postal"]) : 1;
        $email = isset($this->data["email"]) ? (empty($this->data["email"]) ? 1 : "sra.Email = '" . $this->data["email"] . "'") : 1;
        $custid = isset($this->data["custid"]) ? (empty($this->data["custid"]) ? 1 : 'cust.UserId = ' . $this->data["custid"]) : 1;
        $servid = isset($this->data["servid"]) ? (empty($this->data["servid"]) ? 1 : 'serv.UserId = ' . $this->data["servid"]) : 1;
        $status = isset($this->data["status"]) ? (empty($this->data["status"]) ? 1 : 'sr.Status = ' . (($this->data["status"] == -1) ? 0 : $this->data["status"])) : 1;
        $hasissue = isset($this->data["hasissue"]) ? (empty($this->data["hasissue"]) ? 1 : 'sr.HasIssue = ' . $this->data["hasissue"]) : 1;
        $todate =  isset($this->data["todate"]) ? (empty($this->data["todate"]) ? "3000-01-01" : $this->data["todate"]) : "3000-01-01";
        $fromdate =  isset($this->data["fromdate"]) ? (empty($this->data["fromdate"]) ? "1900-01-01" : $this->data["fromdate"]) : "1900-01-01";
        $sql = "SELECT COUNT(*) as Total FROM servicerequest AS sr JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId JOIN user AS cust ON cust.UserId = sr.UserId LEFT JOIN user AS serv ON serv.UserId = sr.ServiceProviderId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId WHERE 1 AND $service_id AND $postal AND $email AND $custid AND $servid AND $status AND $hasissue AND DATE(sr.ServiceStartDate) >= '$fromdate' AND DATE(sr.ServiceStartDate) <= '$todate'";
        //echo $sql;
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    public function TotalUsersForAdmin()
    {
        $userid = isset($this->data["username"]) ? (empty($this->data["username"]) ? 1 : 'user.UserId = ' . $this->data["username"]) : 1;
        $usertype = isset($this->data["usertype"]) ? (empty($this->data["usertype"]) ? 1 : 'user.UserTypeId = ' . $this->data["usertype"]) : 1;
        $mobile = isset($this->data["mobile"]) ? (empty($this->data["mobile"]) ? 1 : "user.Mobile = '" . $this->data["mobile"] . "'") : 1;
        $postal = isset($this->data["postal"]) ? (empty($this->data["postal"]) ? 1 : "ua.PostalCode = '" . $this->data["postal"] . "'") : 1;
        $email = isset($this->data["email"]) ? (empty($this->data["email"]) ? 1 : "user.Email = '" . $this->data["email"] . "'") : 1;
        $todate =  isset($this->data["todate"]) ? (empty($this->data["todate"]) ? "3000-01-01" : $this->data["todate"]) : "3000-01-01";
        $fromdate =  isset($this->data["fromdate"]) ? (empty($this->data["fromdate"]) ? "1900-01-01" : $this->data["fromdate"]) : "1900-01-01";
        $sql = "SELECT user.UserId FROM user LEFT JOIN useraddress AS ua ON user.UserId = ua.UserId WHERE 1 AND $userid AND $usertype AND $mobile AND $postal AND $email AND DATE(user.CreatedDate) >= '$fromdate' AND DATE(user.CreatedDate) <= '$todate' GROUP BY user.UserId ";
        //echo $sql;
        $result = $this->conn->query($sql);
        $res = [];
        $total = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total++;
            }
            $res["Total"] = $total;
        } else {
            $res["Total"] = 0;
        }
        return [$res, $this->errors];
    }

    public function getAllUsersForAdmin($offset, $limit)
    {
        $userid = isset($this->data["username"]) ? (empty($this->data["username"]) ? 1 : 'user.UserId = ' . $this->data["username"]) : 1;
        $usertype = isset($this->data["usertype"]) ? (empty($this->data["usertype"]) ? 1 : 'user.UserTypeId = ' . $this->data["usertype"]) : 1;
        $mobile = isset($this->data["mobile"]) ? (empty($this->data["mobile"]) ? 1 : "user.Mobile = '" . $this->data["mobile"] . "'") : 1;
        $postal = isset($this->data["postal"]) ? (empty($this->data["postal"]) ? 1 : "ua.PostalCode = '" . $this->data["postal"] . "'") : 1;
        $email = isset($this->data["email"]) ? (empty($this->data["email"]) ? 1 : "user.Email = '" . $this->data["email"] . "'") : 1;
        $todate =  isset($this->data["todate"]) ? (empty($this->data["todate"]) ? "3000-01-01" : $this->data["todate"]) : "3000-01-01";
        $fromdate =  isset($this->data["fromdate"]) ? (empty($this->data["fromdate"]) ? "1900-01-01" : $this->data["fromdate"]) : "1900-01-01";
        $sql = "SELECT user.UserId, CONCAT(user.FirstName,' ',user.LastName) AS UserName, user.Email, DATE_FORMAT(user.CreatedDate, '%d/%m/%Y') AS RegistrationDate, user.UserTypeId, user.Mobile, user.Status, user.IsApproved, ua.PostalCode FROM user LEFT JOIN useraddress AS ua ON user.UserId = ua.UserId WHERE 1 AND $userid AND $usertype AND $mobile AND $postal AND $email AND DATE(user.CreatedDate) >= '$fromdate' AND DATE(user.CreatedDate) <= '$todate' GROUP BY user.UserId LIMIT $offset, $limit";
        //echo $sql;
        $result = $this->conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($users, $row);
            }
        } else {
            $users = [];
        }
        return [$users, $this->errors];
    }

    public function getAllUsers()
    {
        $sql = "SELECT user.UserId, CONCAT(user.FirstName,' ',user.LastName) AS UserName FROM user";
        // echo $sql;
        $result = $this->conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($users, $row);
            }
        } else {
            $users = [];
        }
        return [$users, $this->errors];
    }
    // get total service request by user id
    public function TotalRequestByUserId($userid, $status)
    {
        $sql = "SELECT COUNT(*) as Total FROM servicerequest WHERE UserId = $userid AND Status IN $status";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    public function TotalFavoriteAndBlockByUserId($userid)
    {
        //$sql = "SELECT COUNT(*) as Total FROM favoriteandblocked WHERE UserId = $userid";
        $sql = "SELECT COUNT(*) as Total FROM favoriteandblocked AS fb JOIN user ON user.UserId = fb.UserId WHERE user.UserId = $userid AND fb.TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE TargetUserId=$userid AND IsBlocked=0)";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $result["Total"] = 0;
        }
        return [$result, $this->errors];
    }

    // cancel service request  by servcie id and userid
    public function CancelServiceById($userId, $serviceid, $comment = '')
    {
        $status = 3;
        $sql = "UPDATE servicerequest SET Comments='$comment', Status=$status, HasIssue=1, ModifiedDate=now(), ModifiedBy=$userId WHERE UserId=$userId AND ServiceRequestId=$serviceid";
        $result = $this->conn->query($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    // cancel service request  by servcie id and userid
    public function CancelServiceBySPId($spid, $serviceid, $comment = '')
    {
        $record_version = 0;
        $sp_setid = "NULL";
        $spacceptdate = "NULL";
        $sql = "UPDATE servicerequest SET Comments='$comment', Status=0, HasIssue=1, ModifiedDate=now(), ModifiedBy=$spid, RecordVersion=$record_version,ServiceProviderId=$sp_setid, SPAcceptedDate=$spacceptdate  WHERE ServiceProviderId=$spid AND ServiceRequestId=$serviceid";
        $result = $this->conn->query($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getRatingByIds($serviceid)
    {
        $sql = "SELECT rating.* FROM rating JOIN servicerequest ON servicerequest.ServiceRequestId=rating.ServiceRequestId WHERE servicerequest.ServiceRequestId=$serviceid";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    public function getSPDetailesBySPId($spid)
    {
        $sql = "SELECT COUNT(*) as TotalRating, AVG(rating.Ratings) as AverageRating, CONCAT(user.FirstName,' ',user.LastName) as Fullname, user.UserProfilePicture FROM rating JOIN user ON user.UserId = rating.RatingTo WHERE rating.RatingTo = $spid";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    public function getPostalCode($zipcode = "")
    {
        if ($zipcode == "") {
            $zipcode = $this->data["postalcode"];
        }
        //$sql = "SELECT zipcode.Id, city.Id, state.Id,zipcode.ZipcodeValue,city.CityName,state.StateName FROM zipcode JOIN city ON city.Id = zipcode.CityId JOIN state ON state.Id=city.StateId WHERE zipcode.ZipcodeValue = '$zipcode' ";
        $sql = "SELECT zipcode.Id, city.Id, state.Id, zipcode.ZipcodeValue,city.CityName,state.StateName FROM zipcode JOIN city ON city.Id = zipcode.CityId JOIN state ON state.Id = city.StateId JOIN useraddress ON zipcode.ZipcodeValue = useraddress.PostalCode JOIN user ON useraddress.UserId = user.UserId WHERE user.UserTypeId=2 AND useraddress.PostalCode = '$zipcode' AND useraddress.IsDeleted=0";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        } else {
            $result = [];
            $this->addErrors("ZipCode", "We regret to inform you that your selected zip code is not covered by Helperland services until now!");
        }
        return [$result, $this->errors];
    }

    public function getUserDetailesByUserId($userid)
    {
        $postalcode = $this->data["postalcode"];
        $sql = "SELECT user.UserTypeId, useraddress.* FROM user JOIN useraddress ON user.UserId = useraddress.UserId WHERE  useraddress.PostalCode='$postalcode' AND useraddress.IsDeleted=0  AND user.UserTypeId = 1 AND user.UserId = '$userid'";
        $result = $this->conn->query($sql);
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            $result = $rows;
        } else {
            $result = [];
        }
        return [$result, $this->errors];
    }

    public function getUserAllAddressByUserId($userid)
    {
        $sql = "SELECT * FROM useraddress WHERE UserId=$userid AND IsDeleted=0";

        $result = $this->conn->query($sql);
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            $result = $rows;
        } else {
            $result = [];
        }
        return $result;
    }

    public function getUserAddressByUserId($userid)
    {
        $sql = "SELECT * FROM useraddress WHERE UserId=$userid AND IsDeleted=0";
        $result = $this->conn->query($sql);
        if ($result->num_rows < 1) {
            $result = [];
            $this->addErrors("Address", "User address (id:$userid) is not exits or deleted ");
        } else {
            $result = $result->fetch_assoc();
        }
        return [$result, $this->errors];
    }

    public function getUserAddressById($addressid)
    {
        $sql = "SELECT * FROM useraddress WHERE AddressId=$addressid AND IsDeleted=0";
        $result = $this->conn->query($sql);
        if ($result->num_rows < 1) {
            $result = [];
            $this->addErrors("Address", "User address (id:$addressid) is not exits or deleted ");
        } else {
            $result = $result->fetch_assoc();
        }
        return [$result, $this->errors];
    }

    public function getFavoriteSP($userid, $workwithpet)
    {
        $sql = "SELECT fb.*, user.UserProfilePicture, concat(user.FirstName, ' ', user.LastName) AS FullName FROM favoriteandblocked AS fb JOIN user ON user.UserId = fb.TargetUserId WHERE fb.UserId=$userid AND fb.TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE TargetUserId=$userid AND IsBlocked=0) AND user.IsApproved = 1 AND user.IsDeleted = 0 AND fb.IsFavorite = 1 AND fb.IsBlocked = 0 AND user.WorksWithPets >= 0";
        $result = $this->conn->query($sql);
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            $result = $rows;
        } else {
            $result = [];
        }
        return $result;
    }

    // check record is exits or not in favorite and blocked table
    public function IsFavBlockExits($userid, $targetid)
    {
        $sql = "SELECT * FROM favoriteandblocked WHERE (UserId=$userid AND TargetUserId=$targetid) OR (UserId=$targetid AND TargetUserId=$userid)";
        $result = $this->conn->query($sql);
        //echo "<br>".$sql;
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    // insert favorite and blocked records
    public function InsertFavoriteAndBlocked($userid, $targetid)
    {
        //echo $userid." ".$targetid."<br>";
        if (!$this->IsFavBlockExits($userid, $targetid)) {
            try {
                $this->conn->begin_transaction();
                $this->conn->query("INSERT INTO favoriteandblocked (UserId, TargetUserId) VALUES ($userid, $targetid)");
                $this->conn->query("INSERT INTO favoriteandblocked (UserId, TargetUserId) VALUES ($targetid, $userid)");
                $this->conn->commit();
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            return true;
        }
    }

    public function insertUserAddress($userid, $email)
    {
        $addline1 = trim($this->data["housenumber"]);
        $addline2 = trim($this->data["streetname"]);
        $cityname = trim($this->data["cityname"]);
        $statename = $this->data["statename"];
        $postalcode = $this->data["postalcode"];
        $mobile = $this->data["phonenumber"];
        $sql = "INSERT INTO useraddress (UserId, AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email) VALUES ($userid, '$addline1', '$addline2', '$cityname', '$statename', '$postalcode', '$mobile', '$email') ";
        $result = $this->conn->query($sql);
        if (!$result) {
            $result = [];
            $this->addErrors("insert", "Somthing went wrong with the $sql or connection");
        } else {
            $result = $this->getUserDetailesByUserId($userid);
            if (count($result[1]) > 0) {
                $result = [];
                foreach ($result[1] as $key => $val) {
                    $this->addErrors($key, $val);
                }
            } else {
                $result = $result[0];
            }
        }
        return [$result, $this->errors];
    }

    public function isServiceAvailable($addressid, $ondate, $userid)
    {
        $address = $this->getUserAddressById($addressid);
        if (count($address[1]) > 0) {
            $result = [];
            foreach ($address[1] as $key => $val) {
                $this->addErrors($key, $val);
            }
        } else {
            $addline1 = $address[0]["AddressLine1"];
            $addline2 = $address[0]["AddressLine2"];
            $city = $address[0]["City"];
            $state = $address[0]["State"];
            $postalcode = $address[0]["PostalCode"];
            $sql = "SELECT DATE_FORMAT(servicerequest.ServiceStartDate, '%Y-%m-%d') as ServiceStartDate, servicerequest.Status FROM servicerequest JOIN servicerequestaddress ON servicerequestaddress.ServiceRequestId = servicerequest.ServiceRequestId WHERE servicerequest.UserId = $userid AND servicerequestaddress.AddressLine1='$addline1' AND servicerequestaddress.AddressLine2='$addline2' AND servicerequestaddress.City='$city' AND servicerequestaddress.State='$state' AND servicerequestaddress.PostalCode = $postalcode  AND DATE_FORMAT(servicerequest.ServiceStartDate, '%Y-%m-%d') = '$ondate'";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $result = $result->fetch_assoc();
                if ($result["Status"] != 5 && $result["ServiceStartDate"] == $ondate) {
                    $result = [];
                    $this->addErrors("Booked", "Another service request has been logged for this address on this date. Please select a different date.");
                }
            }
        }
        return [$result, $this->errors];
    }

    public function insertServiceRequestExtra($servicerequestid)
    {
        $sql = "";
        if (isset($this->data["extra"])) {
            $extras = +implode("", $this->data["extra"]);
            $sql = "INSERT INTO servicerequestextra (ServiceRequestId, ServiceExtraId) VALUES ($servicerequestid, $extras)";
            if (!$this->conn->query($sql)) {
                $this->addErrors("SQL", "Somthing went wrong with the $sql");
            }
        }
        return [$sql, $this->errors];
    }

    public function insertServiceRequestAddress($servicerequestid, $addressid)
    {
        $sql = "INSERT INTO servicerequestaddress (ServiceRequestId, AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email) SELECT $servicerequestid, AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email FROM useraddress WHERE useraddress.AddressId=$addressid AND useraddress.IsDeleted=0";
        $result = $this->conn->query($sql);
        if (!$result) {
            $this->addErrors("SQL", "Somthing went wrong with the $sql");
        }
        return [$sql, $this->errors];
    }

    public function insertServiceRequest()
    {
        $postalcode = $this->data["postalcode"];
        $startdate = $this->data["cleaningstartdate"];
        $cleaningstarttime = $this->data["cleaningstarttime"];
        $addressid = $this->data["address"];
        $comment = $this->data["comments"];
        $success = [];

        // set data format 
        $date = new DateTime($startdate);
        $date->setTime(floor($cleaningstarttime), floor($cleaningstarttime) == $cleaningstarttime ? "00" : (("0." . substr($cleaningstarttime, -1) * 60) * 100));
        $cleaningstartdate = $date->format('Y-m-d H:i:s');

        $cleaningworkinghour = $this->data["cleaningworkinghour"];
        $extrahour = 0;
        $workwitpets = 0;
        $spid = "NULL";
        $status = 0;
        $paymentdone = 1;
        $discount = 0;
        $userid = $_SESSION["userdata"]["UserId"];
        $spacceptdate = "NULL";
        $paymentdone = 1;
        $refunded_amt = 0;

        if (isset($this->data["extra"])) {
            $extrahour = count($this->data["extra"]) * 0.5;
        }
        if (isset($this->data["workswithpet"])) {
            $workwitpets = 1;
        }
        if (isset($this->data["favsp"])) {
            $spid = $this->data["favsp"];
            $status = 1;
        }

        $servicehourlyrate = Config::SERVICE_HOURLY_RATE;
        $subtotal = $cleaningworkinghour * $servicehourlyrate;
        $totalpayment = $subtotal - $discount;
        $last_id = 0;

        $result = $this->isServiceAvailable($addressid, $startdate, $userid);
        if (count($result[1]) < 1) {
            // step 1: insert record into the servicerequest table
            $sql = "INSERT INTO servicerequest (UserId, ServiceStartDate, ZipCode, ServiceHourlyRate, ServiceHours, ExtraHours, SubTotal, Discount, TotalCost, Comments, ServiceProviderId, SPAcceptedDate, HasPets, Status, CreatedDate, PaymentDone, RefundedAmount) 
                VALUES ($userid, '$cleaningstartdate', '$postalcode', $servicehourlyrate, $cleaningworkinghour, $extrahour, $subtotal, $discount, $totalpayment, '$comment', $spid, $spacceptdate, $workwitpets, $status, now(), $paymentdone, $refunded_amt);";
            $service_req = $this->conn->query($sql);
            if (!$service_req) {
                $this->addErrors("SQL", "Somthing went wrong with the $sql");
            } else {
                array_push($success, true);
                $last_id = $this->conn->insert_id;
                // step 2: insert selected address into the servicerequestaddress table
                $address_req = $this->insertServiceRequestAddress($last_id, $addressid);
                if (count($address_req[1]) > 0) {
                    $this->addErrors("SQL", "Somthing went wrong with the $address_req[0]");
                } else {
                    array_push($success, true);
                    // step 3: insert extra service into the servicerequestextra table
                    $extras_req = $this->insertServiceRequestExtra($last_id);
                    if (count($extras_req[1]) > 0) {
                        $this->addErrors("SQL", "Somthing went wrong with the $extras_req[0]");
                    } else {
                        array_push($success, true);
                    }
                }
            }
        } else {
            array_push($success, false);
            foreach ($result[1] as $key => $val) {
                $this->addErrors($key, $val);
            }
        }

        $result = [];
        $result["ServiceRequestId"] = $last_id;
        $result["FavoriteServicerId"] = $spid;
        $result["workwitpets"] = $workwitpets;

        return [$result, $this->errors];
    }

    public function getServiceRequestById($serviceid)
    {
        $sql = "SELECT sr.*, sra.*, Serv.Email AS SPEmail, Cust.Email AS CEmail, Cust.UserId AS UserId FROM servicerequest as sr JOIN servicerequestaddress as sra ON sra.ServiceRequestId = sr.ServiceRequestId JOIN user AS Cust ON Cust.UserId=sr.UserId LEFT JOIN user AS Serv ON Serv.UserId=sr.ServiceProviderId WHERE sr.ServiceRequestId = $serviceid";
        $service = $this->conn->query($sql);
        if ($service->num_rows > 0) {
            $result = $service->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    public function getServicerByServiceRequestId($serviceid, $workwitpets = 0)
    {
        $sql = "SELECT * FROM user JOIN servicerequest ON servicerequest.ServiceProviderId = user.UserId WHERE servicerequest.ServiceRequestId = $serviceid AND user.WorksWithPets >= $workwitpets";
        $servicer = $this->conn->query($sql);
        if ($servicer->num_rows > 0) {
            $result = $servicer->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    public function getAllServicer($userid)
    {
        //$sql = "SELECT * FROM user WHERE UserTypeId=2 AND IsApproved=1 AND IsDeleted=0 AND WorksWithPets >= $workwithpets";
        $sql = "SELECT user.* FROM user WHERE user.UserTypeId=2 AND user.IsApproved = 1 AND user.IsDeleted = 0 AND user.WorksWithPets >= 0";
        //echo $sql;
        $result = $this->conn->query($sql);
        $servicers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($servicers, $row);
            }
        }
        return $servicers;
    }

    public function getServicerEmailByPostalCode($postalcode)
    {
        $sql = "SELECT * FROM user JOIN useraddress ON useraddress.UserId=user.UserId WHERE user.UserTypeId=2 AND user.IsApproved=1 AND user.IsDeleted=0 AND user.WorksWithPets >= 0"; //AND useraddress.PostalCode=$postalcode";
        $result = $this->conn->query($sql);
        $servicers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($servicers, $row);
            }
        }
        return $servicers;
    }

    public function getAllCustomerForAdmin()
    {
        $sql = "SELECT UserId, CONCAT(FirstName,' ',LastName) AS UserName, Email FROM user WHERE UserTypeId=1";
        $result = $this->conn->query($sql);
        $cust = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($cust, $row);
            }
        } else {
            $cust = [];
        }
        return [$cust, $this->errors];
    }

    public function getAllServicerForAdmin()
    {
        $sql = "SELECT UserId, CONCAT(FirstName,' ',LastName) AS UserName, Email FROM user WHERE UserTypeId=2";
        $result = $this->conn->query($sql);
        $serv = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($serv, $row);
            }
        } else {
            $serv = [];
        }
        return [$serv, $this->errors];
    }

    private function addErrors($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
