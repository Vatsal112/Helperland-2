<?php
require_once("db_connection.php");

class ContactUsModal extends Connection
{
    public $data;
    public $conn;
    public $errors = [];

    public function __construct($data){
        $this->data = $data;
        $this->conn = $this->connect();
    }

    public function insertContactData($UploadFileName, $filelocation){
        $Name = $this->data["FirstName"]." ".$this->data["LastName"];
        $Email = $this->data["Email"];
        $SubjectType = $this->data["Subject"];
        $PhoneNumber = $this->data["Mobile"];
        $Message = $this->data["Message"];
        if(isset($this->data["UserId"])){
            $user_id = $this->data["UserId"];
            $sql = "INSERT INTO contactus (Name, Email, Subject, PhoneNumber, Message, UploadFileName, CreatedOn, CreatedBy,FileName) VALUES ('$Name', '$Email', '$SubjectType', '$PhoneNumber', '$Message', '$UploadFileName', now(), $user_id, '$filelocation')";
        }else{
            $sql = "INSERT INTO contactus (Name, Email, Subject, PhoneNumber, Message, UploadFileName, CreatedOn,FileName) VALUES ('$Name', '$Email', '$SubjectType', '$PhoneNumber', '$Message', '$UploadFileName', now(), '$filelocation')";
        }
        
        $result = $this->conn->query($sql);
        if(!$result){
            $this->addErrors("insert", "Somthing went wrong with $sql");
        }
        return [$result, $this->errors];
    }

    private function addErrors($key, $val){
        $this->errors[$key] = $val;
    }
}
