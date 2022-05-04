<?php

class DefaultController{
    function homepage(){
        include("views/Homepage.php");
    }
    function faqs(){
        include("views/FAQ.php");
    }
    function about(){
        include("views/About.php");
    }
    function contact(){
        include("views/Contact.php");
    }
    function price(){
        include("views/Prices.php");
    }
    function booknow(){
        include("views/Booknow.php");
    }
    function user_registration(){
        include("views/UserRegistration.php");
    }
    function servicer_registration(){
        include("views/ServicerRegistration.php");
    }

    function customer_dashboard($parameter=""){
        include("views/dashboards/CustomerDashboard.php");
    }

    function servicer_dashboard($parameter=""){
        include("views/Dashboards/ServicerDashboard.php");
    }

    function admin_dashboard($parameter=""){
        include("views/Dashboards/AdminDashboard.php");
    }

    function error(){
        include("errors.php");
    }

}
?>