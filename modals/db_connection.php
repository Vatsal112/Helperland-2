<?php 
    class Connection{
        public function connect(){
            $conn = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
            if($conn->connect_errno){
                
                header("Location: ../errors.php?error=Connection Failed!! ".$conn->connect_error);
                die("Something went wrong");
            }
            return $conn;
        }
    }

?>