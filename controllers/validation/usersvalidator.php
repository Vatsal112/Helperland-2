<?php 

class UsersValidator{
    public $errors = [];
    private static $signup_fields = ["FirstName", "LastName", "Email", "Mobile", "Password", "RePassword", "UserTypeId"];
    private static $signin_fields = ["UserName", "Password"];
    public $data;
    public function __construct($post)
    {
        $this->data = $post;
    }
    
    /*--------------- Signin form validation ------------- */

    public function isSigninFormValidate(){

        foreach(self::$signin_fields as $field){
            if(!array_key_exists($field, $this->data)){
                $this->addErrors("field","$field is not exists");
                return $this->errors;
            }
        }

        $this->validateUsername(trim($this->data["UserName"]));
        $this->validatePass(trim($this->data["Password"]));
        return $this->errors;
    }

    public function validatePass($password){
        if(empty($password)){
            $this->addErrors("password","field can't be empty");
        }else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,}$/',$password)){
            $this->addErrors("password","Invalid Password Format!");
        }
    }

    public function validateUsername($username){
        if(empty($username)){
            $this->addErrors("username","field can`t be empty");
        }else{
            if(!filter_var($username,FILTER_VALIDATE_EMAIL)){
                $this->addErrors("username","Invalid Email!");
            }
        }
    }

    /*--------------- Signup form validation ------------- */
    public function isSignupFormValidate(){
        foreach(self::$signup_fields as $field){
            if(!array_key_exists($field, $this->data)){
                $this->addErrors("field","$field is not exists");
                return $this->errors;
            }
        }

        $this->validateFirstname(trim($this->data["FirstName"]));
        $this->validateLastname(trim($this->data["LastName"]));
        $this->validateEmail(trim($this->data["Email"]));
        $this->validateMobile(trim($this->data["Mobile"]));
        $this->validatePolicy(trim($this->data["Policy"]));
        $this->validateUserId(trim($this->data["UserTypeId"]));
        $this->passwordMatching(trim($this->data["Password"]), trim($this->data["RePassword"]));
        return $this->errors;
    }

    public function validateFirstname($fname){
        if(empty($fname)){
            $this->addErrors("firstname","field can`t be empty");
        }else{
            if(!preg_match("/^[^@$!%*#?&]+$/", $fname)){
                $this->addErrors("firstname","special charcater can't be accepted");
            }
        }
    }

    public function validateLastname($lname){
        if(empty($lname)){
            $this->addErrors("lastname","field can`t be empty");
        }else{
            if(!preg_match("/^[^@$!%*#?&]+$/", $lname)){
                $this->addErrors("lastname","special charcater can't be accepted");
            }
        }
    }
    public function validateEmail($email){
        if(empty($email)){
            $this->addErrors("email","field can`t be empty");
        }else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $this->addErrors("email","email must be valid email");
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

    public function passwordMatching($repwd, $pwd){
        $this->validatePassword($pwd);
        $this->validateRepassword($repwd);
        if(!strcmp($repwd,$pwd)==0){
            $this->addErrors("pwdnoteql","password must be match with confirm password");
        } 
    }

    public function validatePassword($pwd){
        if(empty($pwd)){
            $this->addErrors("password","field can`t be empty");
        }else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/',$pwd)){
            $this->addErrors("password","At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer");
        }
    }

    public function validateRepassword($repwd){
        if(empty($repwd)){
            $this->addErrors("repassword","field can`t be empty");
        }else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/',$repwd)){
            $this->addErrors("repassword","At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer");
        }
    }

    public function validatePolicy($policy){
        if(empty($policy)){
            $this->addErrors("policy","privacy & policy must be accepted");
        }
    }

    public function validateUserId($id){
        if(empty($id)){
            $this->addErrors("UserTypeId","field can't be empty");
        }else if(!in_array($id, Config::USER_TYPE_IDS)){
            $this->addErrors("UserTypeId","User type id is not matched");
        }

    }

    public function addErrors($key,$val){
        $this->errors[$key] = $val;
    }
}
