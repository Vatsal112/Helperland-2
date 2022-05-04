<?php
    class ServiceValidator{
        public $data;
        public $errors = [];
        private static $postalcodefeild = ["postalcode"];
        private static $newaddressfield = ["postalcode", "cityname", "statename","streetname", "housenumber", "phonenumber"];
        private static $servicerequestfield = ["postalcode", "cleaningstartdate", "cleaningstarttime", "cleaningworkinghour", "address"];

        function __construct($data){
            $this->data = $data;
        }
        function isPostalCodeValid(){

            foreach(self::$postalcodefeild as $field){
                if(!array_key_exists($field, $this->data)){
                    $this->addErrors("$field","$field is not exists");
                    return $this->errors;
                }
            }
            $this->validatePostalCode(trim($this->data["postalcode"]));
            return $this->errors;
        } 

        function isNewAddressValidate(){
            foreach(self::$newaddressfield as $field){
                if(!array_key_exists($field, $this->data)){
                    $this->addErrors("$field","$field is not exists");
                    return $this->errors;
                }
            }
            $this->validatePostalCode(trim($this->data["postalcode"]));
            $this->validateCityName(trim($this->data["cityname"]));
            $this->validateStateName(trim($this->data["statename"]));
            $this->validateStreetName(trim($this->data["streetname"]));
            $this->validateHouseNumber(trim($this->data["housenumber"]));
            $this->validateMobile(trim($this->data["phonenumber"]));
            return $this->errors;
        }

        function isServiceRequestValidate(){
            foreach(self::$servicerequestfield as $field){
                if(!array_key_exists($field, $this->data)){
                    $this->addErrors("$field","$field is not exists");
                }
            }
            return $this->errors;
        }

        public function validateCityName($cityname){
            if(empty($cityname)){
                $this->addErrors("cityname", "field can`t be empty");
            }
        }
        public function validateStateName($statename){
            if(empty($statename)){
                $this->addErrors("statename", "field can`t be empty");
            }
        }
        public function validateStreetName($streetname){
            if(empty($streetname)){
                $this->addErrors("streetname", "field can`t be empty");
            }
        }
        public function validateHouseNumber($housenumber){
            if(empty($housenumber)){
                $this->addErrors("housenumber", "field can`t be empty");
            }
        }


        public function validatePostalCode($postalcode){
            if(empty($postalcode)){
                $this->addErrors("postalcode","field can`t be empty");
            }else{
                if(!preg_match("/^[0-9]{5}+$/", $postalcode)){
                    $this->addErrors("postalcode","Invalid Postal Code!!!");
                }
            }
        }

        public function validateMobile($mobile){
            if(empty($mobile)){
                $this->addErrors("mobile","field can`t be empty");
            }else{
                if(!preg_match('/^[0-9]{10}$/',$mobile)){
                    $this->addErrors("mobile","length must be 10 chars & number");
                }
            }
        }

        public function validateMessage($message){
            if(empty($message)){
                $this->addErrors("message","field can`t be empty");
            }else{
                if(strlen($message) > Config::MESSAGE_MAX_LENGTH){
                    $this->addErrors("message","Message can't be longer than ".Config::MESSAGE_MAX_LENGTH." characters");
                } 
            }
        }

        public function validatePolicy($policy){
            if(empty($policy)){
                $this->addErrors("policy","privacy & policy must be accepted");
            }
        }
    

        private function addErrors($key, $value){
            $this->errors[$key] = $value;
        }
    }
?>  