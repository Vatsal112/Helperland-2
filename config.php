<?php 
class Config{
    
    /*------------ Database Constant ------------*/
    const DB_HOST = "localhost:3307";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_NAME = "helperland";
    
    /*------------ Users Constant--------------*/
    const SESSION_DESTROY_TIME = 60*60*12; // 1 hour (60sec * 60min * 1hour)
    const USER_TYPE_IDS = [1, 2, 3]; // ["customer", "servicer", "admin"]

    /*------------- FOR SMTP --------------*/
    const SMTP_HOST = "smtp.gmail.com";
    
    //Enter Email and Password to activate smtp service
    const SMTP_EMAIL = "vatsaldendpara001@gmail.com";
    const SMTP_PASS = "Vatsal@9998085586";
    
    /*-------------Contact US ------------*/
    const SUBJECT_TYPE = ['general', 'inquiry', 'renewal', 'revocation'];
    const MESSAGE_MAX_LENGTH = 250; // 250 characters long

    /*-------------- File Upload Validation ----------------*/
    const FILE_MAX_SIZE = 1*1024*1024*4; //(bit*byte*kb*mb) max_size = 4mb
    const FILE_EXTENSION = ['jpg', 'jpeg', 'png', 'docx', 'pdf', 'gif'];

    /*---------------- Application Leval Constant --------------------*/
    const ADMIN_EMAIL = "vatsaldendpara001@gmail.com";
    const BASE_URL = "http://localhost/HelperLand/";
    const PROFILE_PICTURES = ['avatar-hat','avatar-female','avatar-male','avatar-car','avatar-iron','avatar-ship'];
    const RESET_LINK_EXPIRY = 1;
    const EXTRA_SERVICES = ["Inside cabinet", "Inside fridge", "Inside Oven", "Laundry wash & dry", "Interior windows"];

    /*-------------------- Service Request ---------------------*/
    const SERVICE_HOURLY_RATE = 18; // per hour
    const SERVICE_ACCEPT_GAPE = 1; // 1 hour gape
    const EXTRA_PER_SERVICE_RATE = self::SERVICE_HOURLY_RATE/2;
    const EXTRA_PER_SERVICE_TIME = 30; // in minute
    const SERVICE_STATUS = ["new", "assigned", "accepted", "reschedule", "completed", "cancelled"];

}
?>