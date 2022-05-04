$(document).ready(function() {

    window.today = getTodayDate();

    //remove sticky class
    if (window.scrollY > 30) {
        $(".navbar").removeClass("sticky");
    }
    $(window).scroll(function() {
        if (this.scrollY > 30) {
            $(".navbar").removeClass("sticky");
        }
    });

    //card number validation
    $("#cnumber").on("keyup", function(event) {
        var value = $(this).val();
        if (value.length <= 17) {
            if (event.which >= 48 && event.which <= 57) {
                var temp = value.replace(/\s/g, "");
                var len = temp.length;
                if (len % 4 == 0) {
                    $(this).val(value + " ");
                    flag = 1;
                }
            } else {
                $(this).val(value.substring(0, value.length - 1));
            }
        } else {
            $(this).val(value.substring(0, 18));
            return false;
        }
    });

    //card date validation
    $("#cmonth").on("keyup", function(event) {
        var date = $(this).val();
        if (date.length <= 5) {
            if (event.which >= 48 && event.which <= 57) {
                if (date.length == 2) {
                    $(this).val(date + "/");
                }
            } else {
                $(this).val(date.substring(0, date.length - 1));
            }
        } else {
            $(this).val(date.substring(0, 5));
            return false;
        }
    });

    //card cvc validation
    $("#ccvc").on("keyup", function(event) {
        var cvc = $(this).val();
        if (event.which >= 48 && event.which <= 57) {
            if (!cvc.length <= 3) {
                $(this).val(cvc.substring(0, 3));
            }
        } else {
            $(this).val(cvc.substring(0, cvc.length - 1));
        }
    });

    // close modal when window size will below 1200px
    $(window).resize(function() {
        if ($(window).width() < 1200) {
            $("#examplePaymentSummary").modal("hide");
        }
    });

    // remove address button when click and added when cancel
    var address_btn = null;

    $(document).on("click", ".new-address-button button", function() {
        address_btn = $(this).parent().html();
        $(this).remove();
    });

    $(document).on("click", ".btn-cancel", function() {
        if (address_btn != null) {
            $(".new-address-button").html(address_btn);
            address_btn = null;
        }
    });

    // when click on nav-tabs
    $(".nav-link").on("click", function() {
        var navtabs = ["bookstep-setup", "bookstep-schedule", "bookstep-detailes", "bookstep-payment"];
        for (var i = 0; i < navtabs.length; i++) {
            if (!$(this).is($("." + navtabs[i]))) {
                //alert(i+" "+navtabs.indexOf(this.className.split(" ")[0]));
                if (i >= navtabs.indexOf(this.className.split(" ")[0])) {
                    $("." + navtabs[i]).removeClass("filled");
                }
            }
        }
        setClickableOnNavTabs();
    });

    $(document).on("click", "#fav-sp-list .form-check-label", function() {
        const radiolist = document.getElementById("fav-sp-list").getElementsByClassName("form-check");
        var flag = 0;
        for (var i = 0; i < radiolist.length; i++) {
            if ($(this).parent().is($((radiolist[i])))) {
                flag = i;
                continue;
            }
            radiolist[i].querySelector(".form-check-input").checked = false;
            radiolist[i].querySelector(".user-select").innerHTML = "Select";
            radiolist[i].querySelector(".user-select").classList.remove("selected");
        }
        if (!$(this).prev("input").is(":checked")) {
            $(this).find(".user-select").html("Selected");
        } else {
            $("#favsp" + flag).prop("checked", true);
            $(this).find(".user-select").html("Select");
        }

    });

    //when payment-summary-button clicked
    $(".payment-summary-button").on("click", function() {
        var payment_content = $(".side-payment-bar").html();
        var modal_body = $("#examplePaymentSummary .modal-content .modal-body");
        modal_body.html(payment_content);
        modal_body.find(".payment-header").remove();
    });

    $("#savenewaddress").on("click", function(e) {
        var isValid = true;
        const streetname = $("#streetname").val();
        const housenumber = $("#housenumber").val();
        const phonenumber = $("#phonenumber").val();
        const reg = /^[\d]{10}$/;

        // validate new address form
        $("#new-address .card .alert").remove();
        $("#new-address .error").remove();
        if (streetname.length < 1) {
            $("#streetname").after("<span class='error'>*Field can't be empty</span>");
            isValid = false;
        }
        if (housenumber.length < 1) {
            $("#housenumber").after("<span class='error'>*Field can't be empty</span>");
            isValid = false;
        }

        if (phonenumber.length < 1) {
            $("#phonenumber").parent().after("<div style='margin-bottom:10px'><span class='error'>*Field can't be empty</span></div>");
            isValid = false;
        } else if (!reg.test(phonenumber)) {
            $("#phonenumber").parent().after("<div style='margin-bottom:10px'><span class='error'>*numbe must be 10 character long</span></div>");
            isValid = false;
        }

        if (isValid) {
            var action = $("#addform").prop("action");
            $.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#addform").serialize(),
                success: function(data) {
                    $.LoadingOverlay("hide");
                    //console.log(data);
                    obj = JSON.parse(data);
                    //console.log(obj);
                    if (obj.errors.length == 0) {
                        getAndSetAddress(obj.result);
                        $("#new-address .card").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">New Address Saved Successfully!!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`
                        }
                        $("#new-address .card").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '<ul class="errorlist"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                    clearNewAddressForm();
                }
            });
        } else {
            $.LoadingOverlay("hide");
        }
        e.preventDefault();
    });

    // For Payment Summary
    $(document).on("click", "#step1_submit", function(e) {
        // validate step 1
        var postalcode = $("#postalcode").val();
        $(".error").remove();
        if (isValidPostalCode(postalcode)) {
            // ajax to check whether postal code is valid or not
            var action = $("#form-setup").attr("action");
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form-setup").serialize(),
                success: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data);
                    const obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        // set default value on new address form
                        $(".pstlcode").val(obj.result.ZipcodeValue);
                        $(".cityname").val(obj.result.CityName);
                        $(".statename").val(obj.result.StateName);

                        swithcTheTab("bookstep-setup", "bookstep-schedule", "nav-setup", "nav-schedule");
                        setClickableOnNavTabs();
                        setFormDefaultValue();
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`
                        }
                        $("#postalcode").parent().after("<span class='error'><ul style='padding-left:0px; list-style:none;margin-top:5px;'>" + errorlist + "</ul></span>");
                    }
                    return true;
                },
            });
        }
        e.preventDefault();
    });

    $(document).on("click", "#step2_submit", function(e) {
        var dataarray = $("#form-setup").serializeArray();
        dataarray.push({ name: 'workwithpets', value: $("#petathome").is(":checked") });
        if (window.form2error) {
            UpdatePaymentSummary();
        } else {
            // get user data 
            $(".error").remove();
            $.ajax({
                type: "POST",
                datatype: "json",
                data: dataarray,
                url: "http://localhost/HelperLand/?controller=BookNow&function=UserDetailes",
                success: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data);
                    const obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        setDataOnDetailesForm(obj.result, obj.favlist);
                        swithcTheTab("bookstep-schedule", "bookstep-detailes", "nav-schedule", "nav-detailes");
                        setClickableOnNavTabs();
                        $(".form-detailes .alert").remove();
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`
                        }
                        $(".schedule-timing").after("<span class='error'><ul style='padding-left:0px; list-style:none;margin-top:5px;'>" + errorlist + "</ul></span>");
                    }
                }
            });
        }
        e.preventDefault();
    });

    $(document).on("click", "#step3_submit", function(e) {
        $(".form-detailes .alert").remove();

        // store favsp and address id
        var address = getCheckedBoxValue("detailes-address");
        var favsp = getCheckedBoxValue("fav-sp-list");
        window.address = (address == '') ? '' : ("address=" + address);
        var flag = (address == '') ? false : true;
        window.favsp = (favsp == '') ? '' : ("favsp=" + favsp);

        if (flag) {
            var changedate = new Date($("#service-date").val());
            var date = changedate.getFullYear() + "-" + ("0" + (changedate.getMonth() + 1)).slice(-2) + "-" + ("0" + changedate.getDate()).slice(-2);
            $.ajax({
                type: "POST",
                datatype: "json",
                data: { "adid": address, "selecteddate": date },
                url: "http://localhost/HelperLand/?controller=BookNow&function=isServiceAvailable",
                success: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data);
                    const obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        swithcTheTab("bookstep-detailes", "bookstep-payment", "nav-detailes", "nav-payment");
                        setClickableOnNavTabs();
                        $(".accept-policy .form-check-input").prop("checked", false);
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`
                        }
                        $(".form-detailes").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                }
            });
        } else {
            $.LoadingOverlay("hide");
            if (address != '') {
                $(".form-detailes").prepend('<div class="alert alert-warning alert-dismissible fade show" role="alert">Add new address first!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            } else {
                $(".form-detailes").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert">Please select address!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }
        }
        e.preventDefault();
    });

    $(document).on("click", "#step4_submit", function(e) {
        $(".accept-policy .error").remove();
        if ($("#booknowpolicy").is(":checked")) {
            var allconstdata = $("#form-setup").serialize() + "&" + $("#scheduleform").serialize() + "&" + window.address + "&" + window.favsp;
            console.log(allconstdata);
            var action = $("#paymentform").prop("action");
            $.ajax({
                type: "POST",
                datatype: "json",
                data: allconstdata,
                url: action,
                success: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data);
                    const obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        $("#servicerequest .img-wrapper").css("background-color", "#67b644");
                        $("#servicerequest .img-wrapper img").prop("src", "static/images/correct-white-medium.png");
                        var serviceid = ("000" + obj.result.service.ServiceRequestId).slice(-4);
                        $("#servicerequest .success-msg").html("<h4>Booking has been successfully submitted</h4><br> service Request Id " + serviceid);
                        $("#servicerequest").modal("show");
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`
                        }
                        $("#servicerequest .img-wrapper").css("background-color", "#dd4f4f");
                        $("#servicerequest .img-wrapper img").prop("src", "static/images/wrong-white-medium.png");
                        $("#servicerequest .success-msg").html("<h4>Somthing Went Worng!!</h4><br> <ul class='errorlist'>" + errorlist + "</ul>");
                        $("#servicerequest").modal("show");
                    }
                }
            });

        } else {
            $.LoadingOverlay("hide");
            $("#booknowpolicy").parent().after("<p class='error'>* Accept the policy first!!!</p>");
        }
        e.preventDefault();
    });

    // form 2 onchange events
    $(document).on("change", "#service-date", function() {
        UpdatePaymentSummary();
    });
    $(document).on("change", "#service-time", function() {
        UpdatePaymentSummary();
    });
    $(document).on("change", "#service-hour", function() {

        var cuurent_hour = +$("#service-hour").val();
        if ((window.hour > cuurent_hour) && window.extratime != 0) {
            var remainhour = cuurent_hour - window.extratime;
            if (remainhour <= 3) {
                alert("Booking time is less than recommended, we may not be able to finish the job. Please confirm if you wish to proceed with your booking?");
                if (cuurent_hour == 3) {
                    var checkboxes = document.getElementById("extra-div").getElementsByClassName("form-check-input");
                    for (i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = false;
                    }
                    window.extratime = 0;
                    $(".payment-extras .extra").remove();
                } else {
                    if (!(cuurent_hour >= 3 + window.extratime)) {
                        $("#service-hour").val(window.hour);
                    }
                }
            }
        }

        UpdatePaymentSummary();
    });

    window.extratime = 0;
    $(".extra-div .form-check-label").on("click", function() {
        // set extra service
        var extraname = $(this).find(".extra-title").text();
        var extraid = $(this).find(".extra-title").prop("id");
        var extramin = "30 Min";
        var extradiv =
            '<div class="extra ' +
            extraid +
            '" ><div class="title">' +
            extraname +
            '</div><div class="total">' +
            extramin +
            "</div></div>";
        if (!$(this).parent().find("input").is(":checked")) {
            $(".payment-extras").append(extradiv);
            window.extratime += 0.5;
            $("#service-hour").val(+$("#service-hour").val() + 0.5);
        } else {
            $(".payment-extras ." + extraid).remove();
            window.extratime -= 0.5;
            $("#service-hour").val(+$("#service-hour").val() - 0.5);
        }
        UpdatePaymentSummary();
    });

    function getCheckedBoxValue(selector) {
        const checkedlist = document.getElementById(selector).getElementsByClassName("form-check-input");
        var value = '';
        for (var i = 0; i < checkedlist.length; i++) {
            if (checkedlist[i].checked) {
                value = checkedlist[i].value;
                break;
            }
        }
        return value;
    }

    function UpdatePaymentSummary() {
        window.form2error = 0;

        // update service date
        var changedate = new Date($("#service-date").val());
        var today = new Date(window.today);
        //alert(changedate.getTime()+" "+ today.getTime());
        if (changedate.getTime() >= today.getTime()) {
            var date = changedate.getFullYear() + "-" + ("0" + (changedate.getMonth() + 1)).slice(-2) + "-" + ("0" + changedate.getDate()).slice(-2);
            $(".duration-date").text(date);
        } else {
            $("#service-date").val(window.today);
            var date = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
            $(".duration-date").text(date);
            $.LoadingOverlay("hide");
            alert("Your input must be equal or bigger than today's date");
            window.form2error = 1;
        }

        // gwt service time and basic hour
        var time = +$("#service-time").val();
        //console.log(window.hour+" "+window.extratime);
        $(".error").remove();
        window.hour = +$("#service-hour").val();
        if (time + window.hour > 21) {
            $.LoadingOverlay("hide");
            $(".schedule-timing").after("<p class='error'>Could not completed the service request, because service booking request is must be completed within 21:00 time</p>");
            window.form2error = 1;
        } else {
            $(".duration-time").text($("#service-time option[value='" + time + "']").text());
            //alert($("#service-hour").val());
            $(".duration-basic .total").text(($("#service-hour").val() - window.extratime).toFixed(1) + " Hrs.");
        }

        // update total service time, per cleaning and total payment
        $(".total-service-time .total").text(window.hour + " Hrs.");
        $(".per-cleaning .total").text(window.hour * 18 + ",00 €");
        $(".total-payment .total").text(window.hour * 18 + ",00 €");
    }

    function setClickableOnNavTabs() {
        var clslist = document
            .getElementById("nav-tab")
            .getElementsByClassName("nav-link");
        for (var i = 0; i < clslist.length; i++) {
            if (clslist[i].classList.contains("filled")) {
                clslist[i].style.pointerEvents = "auto";
            } else {
                clslist[i].style.pointerEvents = "none";
            }
        }
    }

    function setFormDefaultValue() {
        var service_start_at = "8";
        var working_hour = "3";
        window.hour = working_hour;
        var total_payment = "54";
        var default_extra =
            '<div class="extras-title">Extras</div><div class="extra"><div class="title"></div><div class="total"></div></div>';

        // set default value on form of step2
        $("#service-date").val(window.today);
        $("#service-time").val(service_start_at);
        $("#service-hour").val(working_hour);
        $(".extra-div input:checkbox").prop("checked", false);
        $("#comments").val("");
        $("#petathome").prop("checked", false);

        // get default value from form of step2

        //set default value for payment summary
        $(".duration-date").text(window.today);
        $(".duration-time").text(
            $("#service-time option[value='" + service_start_at + "']").text()
        );
        $(".duration-basic .total").text(
            $("#service-hour option[value='" + working_hour + "']").text()
        );
        $(".payment-extras").html(default_extra);
        $(".total-service-time .total").text(
            $("#service-hour option[value='" + working_hour + "']").text()
        );
        $(".per-cleaning .total").text(total_payment + ",00 €");
        $(".total-payment .total").text(total_payment + ",00 €");
    }

    function getTodayDate() {
        var myDate = new Date();
        var dt =
            myDate.getFullYear() +
            "-" +
            ("0" + (myDate.getMonth() + 1)).slice(-2) +
            "-" +
            ("0" + myDate.getDate()).slice(-2);
        return dt;
    }

    function isValidPostalCode(postal) {
        var len = postal.length;
        if (len <= 0) {
            $("#postalcode")
                .parent()
                .after("<span class='error'>Field can`t be empty</span>");
            $.LoadingOverlay("hide");
            return false;
        } else if (len != 5) {
            $("#postalcode")
                .parent()
                .after(
                    "<span class='error'>Postal code must be 5 characters long</span>"
                );
            $.LoadingOverlay("hide");
            return false;
        } else {
            return true;
        }
    }

    function swithcTheTab(from1, to1, from2, to2) {
        // from 1
        $("." + from1).addClass("filled");
        $("." + from1).removeClass("active");
        $("." + from1 + ".filled").attr("aria-selected", "false");
        $("#" + from2).removeClass("show active");

        // from 2
        $("." + to1).addClass("active");
        $("." + to1 + ".active").attr("aria-selected", "true");
        $("#" + to2).addClass("show active");
    }


    function getAndSetAddress(result) {

        var html = "";
        for (var i = 0; i < result.length; i++) {
            var select = "";
            if (result[i].IsDefault == 1) { select = "checked"; }
            html += `
    <div class="form-check">
      <input class="form-check-input" type="radio" name="useraddress[]" id="exampleRadios${i}" value="${result[i].AddressId}" ${select}>
      <label class="form-check-label" for="exampleRadios${i}">
          <div class="address-detailes">Address: <span>${result[i].AddressLine1} ${result[i].AddressLine2}, ${result[i].PostalCode} ${result[i].City}</span></div>
          <div class="address-phone">Phone number: <span>${result[i].Mobile}</span></div>
      </label>
    </div>
    `;
        }
        $("#detailes-address").html(html);

    }

    function getAndSetFavoriteSP(favlist) {
        html = "";
        for (var i = 0; i < favlist.length; i++) {
            var avtar = favlist[i].UserProfilePicture;
            if (avtar == null) {
                avtar = "avtar1.png";
            }
            html += `
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="favsp[]" id="favsp${i}" value="${favlist[i].TargetUserId}">
      <label class="form-check-label favspradio" for="favsp${i}">
          <div class="fav-sp">
              <div class="user-avtar">
                  <img src="static/images/avtar/${avtar}.png" alt="${avtar}">
              </div>
              <div class="user-name">
                  ${favlist[i].FullName}
              </div>
              <div class="user-select">
                  Select
              </div>
          </div>
      </label>
    </div>
    `;
        }
        $("#fav-sp-list").html(html);


    }

    function clearNewAddressForm() {
        // clear new address field
        $("#streetname").val("");
        $("#housenumber").val("");
        $("#phonenumber").val("");
    }

    function setDataOnDetailesForm(result, favlist) {
        getAndSetAddress(result);
        getAndSetFavoriteSP(favlist);
        clearNewAddressForm();
    }

    $('#servicerequest').modal({
        backdrop: 'static',
        keyboard: false
    });


});