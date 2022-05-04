$(document).ready(function(){
    
    window.isValid = true;
    
    /* VALIDATION FOR CONTACT US FORM */
    $('#contactus').click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phonenumber = $('#phonenumber').val();
        var email = $('#email').val();
        var message = $('#message').val();
        var policy = $('#policy:checked').length;
        validateFirstName(firstname);
        validateLastName(lastname);
        validatePhoneNumber(phonenumber);
        validateEmail("#email",email);
        validateMessage(message);
        validatePolicy(policy);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#btn_refund").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("Comment", ".refund-comment");
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#btn-editandreschedule").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var mobile = $("#er-mobile").val();
        var postal = $("#er-postalcode").val();
        isFieldEmpty("Street name", "#er-street");
        isFieldEmpty("House name", "#er-house");
        isFieldEmpty("Comments", "#er-comment");
        isDateFormatValid("#er-date");
        validateCityOption("#er-city");
        validatePhoneNumber(mobile, "#er-mobile");
        isValidPostalCode(postal, "#er-postalcode");
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#btn_address").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var mobile = $("#add-mobile").val();
        var postal = $("#add-postal").val();
        var city = $("add-city").val();
        isFieldEmpty("Street name", "#add-street");
        isFieldEmpty("House name", "#add-house");
        validateCityOption("#add-city");
        validatePhoneNumber(mobile, "#add-mobile");
        isValidPostalCode(postal, "#add-postal");
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#btn-saveuser").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phonenumber = $('#phonenumber').val();
        var email = $('#email').val();
        var birthdate = $('#birthdate').val();
        validateFirstName(firstname);
        validateLastName(lastname);
        validatePhoneNumber(phonenumber);
        validateEmail("#email",email);
        validateBirthDate(birthdate);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#servicersave").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phonenumber = $('#phonenumber').val();
        var email = $('#email').val();
        var birthdate = $('#birthdate').val();
        var postal = $("#add-postal").val();
        isFieldEmpty("Street name", "#add-street");
        isFieldEmpty("House name", "#add-house");
        validateCityOption("#city");
        isValidPostalCode(postal, "#add-postal");
        validateFirstName(firstname);
        validateLastName(lastname);
        validatePhoneNumber(phonenumber);
        validateEmail("#email",email);
        validateBirthDate(birthdate);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    $("#btn-updatepassword").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var oldpassword = $('#oldpsw').val();
        var password = $("#password").val();
        var repassword = $("#repassword").val();
        validatePassword("#oldpsw", oldpassword);
        passwordMatched(password, repassword);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    /* VALIDATION FOR SIGNIN FORM */
    $("#signin").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var email = $('#signinemail').val();
        var password = $('#password').val();
        validateEmail("#signinemail",email);
        validatePassword("#password", password);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    /* VALIDATION FOR SIGNUP FORM */
    $("#register").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phonenumber = $('#phonenumber').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        var policy = $('#policy:checked').length;
        validateFirstName(firstname);
        validateLastName(lastname);
        validatePhoneNumber(phonenumber);
        validateEmail("#email",email);
        passwordMatched(password, repassword);
        validatePolicy(policy);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    /* VALIDATION FOR FORGOT PASSWORD FORM */
    $("#forgotpassword").click(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var email = $('#forgotemail').val();
        validateEmail("#forgotemail",email);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    /* VALIDATION FOR CHANGE PASSWORD FORM */
    $("#form-changepassword").submit(function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        passwordMatched(password, repassword);
        //alert(window.isValid);
        if(!window.isValid){
            e.preventDefault();
            $.LoadingOverlay("hide");
        }
    });

    function isDateFormatValid(id){
        var date = $(id).val();
        var reg = /^(((0[1-9]|[12][0-9]|30)[-/]?(0[13-9]|1[012])|31[-/]?(0[13578]|1[02])|(0[1-9]|1[0-9]|2[0-8])[-/]?02)[-/]?[0-9]{4}|29[-/]?02[-/]?([0-9]{2}(([2468][048]|[02468][48])|[13579][26])|([13579][26]|[02468][048]|0[0-9]|1[0-6])00))$/;
        if(date.length < 1){
            $(id).parent().after("<span class='error'>*This field can't be empty</span>");
            window.isValid = false;
            return;
        }else if(!reg.test(date)){
            $(id).parent().after("<span class='error'>*Date Format must be dd/mm/yyyy</span>");
            window.isValid = false;
            return;
        }
    }

    function isFieldEmpty(fieldname, id){
        var val = $(id).val();
        if(val.length < 1){
            $(id).after("<span class='error'>*Enter the "+fieldname+"</span>");
            window.isValid = false;
            return;
        }
    }
    function validateFirstName(firstname){
        if(firstname.length < 1){
            $('#firstname').after("<span class='error'>*Enter the first name</span>");
            window.isValid = false;
            return;
        }
        
    }
    function validateLastName(lastname){
        if(lastname.length < 1){
            $('#lastname').after("<span class='error'>*Enter the last name</span>");
            window.isValid = false;
            return;
        }
    }
    function validatePhoneNumber(phonenumber, id="#phonenumber"){
        var reg = /^[\d]{10}$/;
        if(phonenumber.length < 1){
            $(id).parent().after("<span class='error'>*Enter the mobile number</span>");
            window.isValid = false;
            return;
        }else if(!reg.test(phonenumber)){
            $(id).parent().after("<span class='error'>*Mobile must be 10 charcters long</span>");
            window.isValid = false;
            return;
        }
    }
    function validateEmail(id,email){
        var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(email.length < 1){
            $(id).after("<span class='error'>*Email field cant be empty</span>");
            window.isValid = false;
            return;
        }else if(!reg.test(email)){
            $(id).after("<span class='error'>*Enter a valid email</span>");
            window.isValid = false;
            return;
        }
    }

    function isValidPostalCode(val, id="#postalcode") {
        var len = val.length;
        if (len <= 0) {
            $(id).after("<span class='error'>Field can`t be empty</span>");
            window.isValid = false;
            return;
        } else if (len != 5) {
            $(id).after("<span class='error'>Postal code must be 5 characters long</span>");
            window.isValid = false;
            return;
        } 
      }

    function validateMessage(message, id="#message"){
        if(message.length < 1){
            $(id).after("<span class='error'>*Message can't be empty</span>");
            window.isValid = false;
            return;
        }
    }
    function validatePolicy(policy){
        if(policy==0){
            alert("Policy must be accepeted");
            window.isValid = false;
            return;
        }
    }
    function validateCityOption(id){
        if(!$(id).find("option").is(':selected')){
            $(id).after("<span class='error'>*Select the city first</span>");
            window.isValid = false;
            return;
        }
    }
    function validatePassword(id, password){
        var reg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/;
        if(password.length < 1){
            $(id).after("<span class='error'>*"+id.replace("#", "")+" can't be empty</span>");
            window.isValid = false;
            return;
        }else{
            if(!reg.test(password)){
                $(id).after("<span class='error'>*At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer</span>");
                window.isValid = false;
                return;
            }
        }
        window.passwordValid = true;
    }

    function passwordMatched(pass, repass){
        window.passwordValid = false;
        validatePassword("#password",pass);
        validatePassword("#repassword",repass);
        if(window.passwordValid && pass!=repass){
            $("#password").after("<span class='error'>*password and repassword must be matched</span>");
            window.isValid = false;
            return;
        }
    }

    function validateBirthDate(birthdate, id="#birthdate"){
        var selectdate = new Date(birthdate);
        var cmpryear = new Date();
        cmpryear.setFullYear(cmpryear.getFullYear()-18);
        if(cmpryear.getTime() < selectdate.getTime()){
            $(id).parent().after("<span class='error'>*Below 18 cannot be customer</span>");
            window.isValid = false;
            return;
        }
    }
});