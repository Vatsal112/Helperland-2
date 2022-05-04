$(document).ready(function() {

    // logic for export 
    $('#export').click(function() {
        let data = document.getElementById('table');
        var fp = XLSX.utils.table_to_book(data, { sheet: 'History' });
        XLSX.write(fp, {
            bookType: 'xlsx',
            type: 'base64'
        });
        XLSX.writeFile(fp, 'service-history.xlsx');
    });

    // Declare some global variable
    var today = new Date();
    var today_ = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
    var req = $("#req").val();
    var tommorrow = new Date();
    tommorrow.setDate(tommorrow.getDate() + 1);
    tommorrow = tommorrow.getFullYear() + "-" + ("0" + (tommorrow.getMonth() + 1)).slice(-2) + "-" + ("0" + tommorrow.getDate()).slice(-2);
    var currentpage = 1; // current page number
    var showrecords = $(".show-apge select").val(); // total records shown in select input
    var totalpage = 1;
    var records = [];
    var totalrecords = 0;
    var haspets;
    var payment = $("#select_payment").val();
    var rating = $("#select_rating").val();
    var postal = 'all';

    switch (req) {
        case "setting":
            break;
        default:
            getDefaultRecords();
            setTimeout(setDefault, 100);
    }

    // this pagination logic to increase or decrease a page number
    $(document).on("click", ".paginations div", function() {
        var actionclass = $(this).prop("class");
        switch (actionclass) {
            case "jump-left":
                currentpage = 1;
                break;
            case "next-left":
                if (currentpage > 1) {
                    currentpage--;
                }
                break;
            case "next-right":
                if (currentpage < totalpage) {
                    currentpage++;
                }
                break;
            case "jump-right":
                currentpage = totalpage;
                break;
        }
        updatePageNumber(currentpage);
        getAjaxDataByReq();
    });

    // is pet checked or not
    $(document).on("click", "#hasapets", function() {
        haspets = ($(this).is(":checked") == true) ? 1 : 0;
        currentpage = 1;
        //alert(haspets);
        updatePageNumber(currentpage);
        getAjaxDataByReq();
        getDefaultRecords();
        setTimeout(setDefault, 100);
    });

    // for avtar selection
    $(document).on("click", "#avatars img", function(e) {
        $("#avatars img").removeClass("selected");
        $(this).addClass("selected");
        var imgname = $(this).prop("alt");
        $(".account-header img").prop("src", "./static/images/avtar/" + imgname + ".png");
        $(".account-header img").prop("alt", imgname);
    });

    //update hidden mobile field value 
    $(document).on("keyup", "#phonenumber", function() {
        var mobile = $(this).val();
        $("#add-mobile").val(mobile);
    });

    // when somebody click on the row of upcoming table
    $(document).on("click", "#table_upcomingservice tr", function() {
        var index = $(this).prop("id").split("_")[1];
        var result = records[index];
        showUpcomingModal(result);
    });

    function showUpcomingModal(result) {
        var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
        console.log(date);
        if (checkTimeForCompleteBtn(date.startdate, date.endtime)) {
            $(".modal-button-complete").prop("id", "complete_request");
            $(".modal-button-complete").show();
        } else {
            $(".modal-button-complete").prop("id", "");
            $(".modal-button-complete").hide();
        }
        var extraid = result.ServiceExtraId;
        extraid = extraid == null ? 0 : extraid;
        const extra = ["Inside cabinet", "Inside fridge", "Inside Oven", "Laundry wash & dry", "Interior windows", ];
        var extrahtml = "";
        if (extraid != 0) {
            extraid.split("").forEach((id) => {
                extrahtml += extra[+id - 1] + ", ";
            });
        }
        $("#exampleModalServiceCancel .m-time").text(date.startdate + " " + date.starttime + "-" + date.endtime);
        $("#exampleModalServiceCancel .m-duration").text(result.ServiceHours);
        $("#exampleModalServiceCancel .m-id span").text(("000" + result.ServiceRequestId).slice(-4));
        $("#exampleModalServiceCancel .m-extras span").text(extrahtml);
        $("#exampleModalServiceCancel .m-currency").text(result.TotalCost + " €");
        $("#exampleModalServiceCancel .m-name span").text(result.FirstName + " " + result.LastName);
        $("#exampleModalServiceCancel .m-address span").text(result.AddressLine2 + " " + result.AddressLine1 + ", " + result.PostalCode + " " + result.City);
        $("#exampleModalServiceCancel .m-distance span").text("-");
        $("#exampleModalServiceCancel .m-comments").text(result.Comments);
        $("#exampleModalServiceCancel .m-pets").html((result.HasPets == 0) ? '<span class="fa fa-times-circle-o"></span> I dont`t have pets at home' : '<span class="fa fa-check" style="color:#0f7a2b"></span> I have pets at home');
        var src = "https://www.google.com/maps/embed/v1/place?q=" + result.PostalCode + " " + result.City + "&key=AIzaSyAag-Mf1I5xbhdVHiJmgvBsPfw7mCqwBKU";
        $("#exampleModalServiceCancel .modal-section-map iframe").prop("src", src);
        $("#exampleModalServiceCancel").modal("show");
    }

    // when somebody click on the row of new request table
    $(document).on("click", "#table-newrequest tr", function() {
        var index = $(this).prop("id").split("_")[1];
        var result = records[index];
        var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
        var extraid = result.ServiceExtraId;
        extraid = extraid == null ? 0 : extraid;
        const extra = ["Inside cabinet", "Inside fridge", "Inside Oven", "Laundry wash & dry", "Interior windows", ];
        var extrahtml = "";
        if (extraid != 0) {
            extraid.split("").forEach((id) => {
                extrahtml += extra[+id - 1] + ", ";
            });
        }
        $("#exampleModalServiceAccept .m-time").text(date.startdate + " " + date.starttime + "-" + date.endtime);
        $("#exampleModalServiceAccept .m-duration").text(result.ServiceHours);
        $("#exampleModalServiceAccept .m-id span").text(("000" + result.ServiceRequestId).slice(-4));
        $("#exampleModalServiceAccept .m-extras span").text(extrahtml);
        $("#exampleModalServiceAccept .m-currency").text(result.TotalCost + " €");
        $("#exampleModalServiceAccept .m-name span").text(result.FirstName + " " + result.LastName);
        $("#exampleModalServiceAccept .m-address span").text(result.AddressLine2 + " " + result.AddressLine1 + ", " + result.PostalCode + " " + result.City);
        $("#exampleModalServiceAccept .m-distance span").text("-");
        $("#exampleModalServiceAccept .m-comments").text(result.Comments);
        $("#exampleModalServiceAccept .m-pets").html((result.HasPets == 0) ? '<span class="fa fa-times-circle-o"></span> I dont`t have pets at home' : '<span class="fa fa-check" style="color:#0f7a2b"></span> I have pets at home');
        var src = "https://www.google.com/maps/embed/v1/place?q=" + result.PostalCode + " " + result.City + "&key=AIzaSyAag-Mf1I5xbhdVHiJmgvBsPfw7mCqwBKU";
        $("#exampleModalServiceAccept .modal-section-map iframe").prop("src", src);
        $("#exampleModalServiceAccept").modal("show");
    });

    $(document).on("change", "#select_postal", function() {
        postal = $(this).val();
        updatePageNumber(currentpage);
        getAjaxDataByReq();
        getDefaultRecords();
        setTimeout(setDefault, 100);
    });

    $(document).on("click", "#accept_request", function(e) {
        e.preventDefault();
        showLoader();
        var serviceid = +$(this).parent().parent().parent().find(".m-id span").text();
        var action = "http://localhost/HelperLand/?controller=SDashboard&function=AcceptServiceRequest";
        var spid = $("#spid").val();
        jQuery.ajax({
            type: "POST",
            url: action,
            datatype: "json",
            data: { serviceid: serviceid, spid: spid },
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                $(".modal").modal("hide");
                if (obj.errors.length == 0) {
                    $("#servicerequest .img-wrapper").css("background-color", "#67b644");
                    $("#servicerequest .img-wrapper img").prop("src", "static/images/correct-white-medium.png");
                    $("#servicerequest .success-msg").text("Service Accepted Successfully");
                    $("#servicerequest").modal("show");
                } else {
                    var errorlist = "";
                    for (const [key, val] of Object.entries(obj.errors)) {
                        errorlist += `<li>${val}</li>`;
                    }
                    $("#servicerequest .img-wrapper").css("background-color", "#f84545");
                    $("#servicerequest .img-wrapper img").prop("src", "static/images/wrong-white-medium.png");
                    $("#servicerequest .success-msg").html("<ul style='list-style: none;font-size: 17px;color: red;padding: 0px;'>" + errorlist + "</ul>");
                    $("#servicerequest").modal("show");
                }
                updatePageNumber(currentpage);
                getAjaxDataByReq();
                getDefaultRecords();
                setTimeout(setDefault, 100);
            },
            complete: function(data) {
                $.LoadingOverlay("hide");
            },
        });
    });

    // when user wants to cancel service request
    $(document).on("click", "#btn_service_cancel", function(e) {
        e.preventDefault();
        $(".error").remove();
        if ($("#cancel-comment").val().length > 0) {
            showLoader();
            var action = $("#form-service-cancel").prop("action");
            var spid = $("#spid").val();
            //alert(action);
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form-service-cancel").serialize() + "&spid=" + spid,
                success: function(data) {
                    var obj = JSON.parse(data);
                    console.log(obj.result);
                    console.log($("#form-service-cancel").serialize());
                    var serviceid = ("000" + $("#form-service-cancel input[type=hidden]").val()).slice(-4);
                    $(".modal").modal("hide");
                    if (obj.result == 1) {
                        $("#servicerequest .img-wrapper").css("background-color", "#67b644");
                        $("#servicerequest .img-wrapper img").prop("src", "static/images/correct-white-medium.png");
                        $("#servicerequest .success-msg").text("Service " + serviceid + " Cancelled Successfully!!");
                        $("#servicerequest").modal("show");
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#servicerequest .img-wrapper").css("background-color", "#f84545");
                        $("#servicerequest .img-wrapper img").prop("src", "static/images/wrong-white-medium.png");
                        $("#servicerequest .success-msg").html("<ul style='list-style: none;font-size: 17px;color: red;padding: 0px;'>" + errorlist + "</ul>");
                        $("#servicerequest").modal("show");
                    }
                    updatePageNumber(currentpage);
                    getAjaxDataByReq();
                    getDefaultRecords();
                    setTimeout(setDefault, 100);
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        } else {
            $("#cancel-comment").after(
                "<p class='error'>* Comment can't be empty!!!</p>"
            );
        }
    });


    $(document).on("click", "#cancel_request", function(e) {
        e.preventDefault();
        var serviceid = +$(this).parent().parent().parent().find(".m-id span").text();
        $("#ServiceCancel input[type=hidden]").val(serviceid);
        $("#ServiceCancel textarea").val();
        $(".modal").modal("hide");
        $("#ServiceCancel").modal("show");
    });

    $(document).on("click", "#complete_request", function(e) {
        e.preventDefault();
        showLoader();
        var serviceid = +$(this).parent().parent().parent().find(".m-id span").text();
        var action = "http://localhost/HelperLand/?controller=SDashboard&function=CompleteServiceRequest";
        var spid = $("#spid").val();
        jQuery.ajax({
            type: "POST",
            url: action,
            datatype: "json",
            data: { serviceid: serviceid, spid: spid },
            success: function(data) {
                //console.log(data);
                var obj = JSON.parse(data);
                $(".modal").modal("hide");
                if (obj.errors.length == 0) {
                    $("#servicerequest .img-wrapper").css("background-color", "#67b644");
                    $("#servicerequest .img-wrapper img").prop("src", "static/images/correct-white-medium.png");
                    $("#servicerequest .success-msg").html("<div>Service Completed Successfully</div><div>>>>Check Your History<<<</div>");
                    $("#servicerequest").modal("show");
                } else {
                    var errorlist = "";
                    for (const [key, val] of Object.entries(obj.errors)) {
                        errorlist += `<li>${val}</li>`;
                    }
                    $("#servicerequest .img-wrapper").css("background-color", "#f84545");
                    $("#servicerequest .img-wrapper img").prop("src", "static/images/wrong-white-medium.png");
                    $("#servicerequest .success-msg").html("<ul style='list-style: none;font-size: 17px;color: red;padding: 0px;'>" + errorlist + "</ul>");
                    $("#servicerequest").modal("show");
                }
                updatePageNumber(currentpage);
                getAjaxDataByReq();
            },
            complete: function(data) {
                $.LoadingOverlay("hide");
            },
        });
    });


    // save setting tab user detailes
    $(document).on("click", "#servicersave", function(e) {
        e.preventDefault();
        if ($(this).parent().find('.error').length == 0) {
            showLoader();
            var action = $(this).parent().prop("action");
            var avtar = $("#avatars img.selected").prop("alt");
            var data = $(this).parent().serialize() + "&profilepicture=" + avtar;
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: data,
                success: function(data) {
                    //console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        $("#firstname").val(obj.result.FirstName);
                        $(".header-image span").text(obj.result.FirstName);
                        $("#lastname").val(obj.result.LastName);
                        $("#phonenumber").val(obj.result.Mobile);
                        $("#email").val(obj.result.Email);
                        if (obj.result.DateOfBirth == null) {
                            var date = new Date("Y-m-d", obj.result.DateOfBirth);
                            $("#birthdate").val(date);
                        }
                        if (obj.addid != 0) {
                            $("#addid").val(obj.addid);
                        }
                        $("#form-usersave").prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert"><ul class="success">user saved Successfully!!</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#form-usersave").prepend(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="error">' +
                            errorlist +
                            '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        );
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#nav-tab").offset().top,
        }, 100);
    });

    // when someone want to get data according to payment status
    $(document).on("change", "#select_payment", function() {
        payment = $(this).val();
        updatePageNumber(currentpage);
        getAjaxDataByReq();
        getDefaultRecords();
        setTimeout(setDefault, 100);
    });

    // when someone want to get data according to rating
    $(document).on("change", "#select_rating", function() {
        rating = $(this).val();
        updatePageNumber(currentpage);
        getAjaxDataByReq();
        getDefaultRecords();
        setTimeout(setDefault, 100);
    });
    // update city select option according to postal code
    $(document).on("keyup", "#add-postal", function(e) {
        var postal = $(this).val();
        if (postal.length == 5) {
            $(".error").remove();
            showLoader();
            jQuery.ajax({
                type: "POST",
                url: "http://localhost/HelperLand/?controller=Users&function=getCityByPostal",
                datatype: "json",
                data: { postalcode: postal },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        var option = "<option value=" + obj.result.CityName.toLowerCase() + " selected>" + obj.result.CityName + "</option>";
                        $("#city").html(option);
                    } else {
                        $("#city").html("");
                        $("#add-postal").after(
                            "<span class='error'>*invalid postal code</span>"
                        );
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        } else {
            $("#city").html("");
            $.LoadingOverlay("hide");
        }
    });

    // blocked the customer
    $(document).on("click", ".button-block", function() {
        var id = $(this).parent().find(".userblock").text();
        var is = $(this).text();
        var spid = $("#spid").val();
        jQuery.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=SDashboard&function=UpdateBlockUser",
            datatype: "json",
            data: { b_id: id, b_is: is, spid: spid },
            success: function(result) {
                //console.log(result);
                getAjaxDataByReq();
            },
        });
    });

    // when user want to update password
    $(document).on("click", "#btn-updatepassword", function(e) {
        e.preventDefault();
        if ($(this).parent().parent().find('.error').length == 0) {
            var action = $(this).parent().parent().prop("action");
            showLoader();
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form-changepassword").serialize(),
                success: function(data) {
                    //console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        $("#form-changepassword").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"><ul class="success">Password Changed Successfully!!</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#form-changepassword").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                    $("#form-changepassword").trigger("reset");
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
    });

    // this is function to set default thinks or call by timeout vecause of late ajax responce
    function setDefault() {
        totalrecords = $(".show-apge .totalrecords").text();
        totalpage = Math.ceil(totalrecords / showrecords);
        totalpage = totalpage == 0 ? 1 : totalpage;
        getAjaxDataByReq();
    }

    // this is a function get total records from database
    function getDefaultRecords() {
        $.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=SDashboard&function=TotalRequest&parameter=" + req,
            datatype: "json",
            data: { haspets: haspets, payment: payment, rating: rating, postal: postal },
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                var totalrequest = obj.result.Total;
                $(".show-apge .totalrecords").text(totalrequest);
            },
        });
    }

    $(document).on("click", ".calendar .icon-left-right", function() {
        switch ($(this).prop("id")) {
            case "left-date":
                today.setMonth(today.getMonth() - 1);
                break;
            case "right-date":
                today.setMonth(today.getMonth() + 1);
                break;
        }
        today_ = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
        //alert(today_);
        getAjaxDataByReq();
    });

    $(document).on("click", ".calendar .event", function() {
        var index = $(this).prop("id").split("_")[1];
        var result = records[index];
        showUpcomingModal(result);
    });

    // this is a function to get service data according to currentpage, showrecords and apge request
    function getAjaxDataByReq() {
        showLoader();
        $.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=SDashboard&function=ServiceRequest&parameter=" + req,
            datatype: "json",
            data: { pagenumber: currentpage, limit: showrecords, haspets: haspets, payment: payment, rating: rating, date: today_, postal: postal },
            success: function(data) {
                console.log(data);
                //alert(data);
                obj = JSON.parse(data);
                $("table tbody").html("");
                if (obj.errors.length == 0) {
                    records = obj.result;
                    console.log(records);
                    switch (req) {
                        case "dashboard":
                            setDashboard(obj.result);
                            break;
                        case "newservice":
                            setNewRequest(obj.result);
                            break;
                        case "upcoming":
                            setUpcomingRequest(obj.result);
                            break;
                        case "history":
                            setHistory(obj.result);
                            break;
                        case "ratings":
                            setRatings(obj.result);
                        case "block":
                            setBlocks(obj.result);
                        case "schedule":
                            setSchedules(obj.calendar);
                            break;
                        case "setting":
                            break;
                        default:
                            setDashboard(obj.result);
                    }
                }
            },
            complete: function(data) {
                $.LoadingOverlay("hide");
            },
        });
    }

    // for updating page number
    function updatePageNumber(number) {
        if (totalpage < currentpage) {
            number = totalpage;
        }
        $(".paginations .current-page").text(number);
    }

    // thhi is a function to update pagination when somebody change show records dropdown
    $(document).on("change", ".show-apge select", function() {
        showrecords = $(this).val();
        totalpage = Math.ceil(totalrecords / showrecords);
        totalpage = totalpage == 0 ? 1 : totalpage;
        currentpage = 1;
        updatePageNumber(currentpage);
        getAjaxDataByReq();
    });

    $(document).on("click", ".btn-today", function() {
        today = new Date();
        today_ = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
        getAjaxDataByReq();
    });

    // compare time to set complete button
    function checkTimeForCompleteBtn(service_date, service_endtime) {
        var d = service_date.split("/");
        var day = d[0];
        var month = d[1];
        var year = d[2];
        var service_date = `${month}/${day}/${year}`;
        var d1 = new Date(service_date + " " + service_endtime); // format 03/10/2022 12:00
        var d2 = new Date(); // current date
        return (d2.getTime() > d1.getTime());
    }

    // get time and date in required format
    function getTimeAndDate(sdate, stime) {
        //alert(sdate, stime);
        var dateobj = new Date(sdate);
        var startdate = dateobj.toLocaleDateString("en-AU");
        var starttime =
            ("0" + dateobj.getHours()).slice(-2) +
            ":" +
            ("0" + dateobj.getMinutes()).slice(-2);
        var totalhour = stime;

        var endhour = dateobj.getHours() + Math.floor(totalhour);
        var endmin =
            (totalhour - Math.floor(totalhour)) * 60 + dateobj.getMinutes();
        if (endmin >= 60) {
            endhour = endhour + Math.floor(endmin / 60);
            endmin = (endmin / 60 - Math.floor(endmin / 60)) * 60;
        }
        var endtime = ("0" + endhour).slice(-2) + ":" + ("0" + endmin).slice(-2);
        return { startdate: startdate, starttime: starttime, endtime: endtime };
    }

    // this is logic to making star html for sp rating
    function getStarHTMLByRating(avgrating) {
        spstar = "";
        var i = 0;
        for (i = 0; i < Math.floor(avgrating); i++) {
            spstar += '<span class="fa fa-star"></span>';
        }
        if (Math.floor(avgrating) < avgrating) {
            i++;
            spstar += '<span class="fa fa-star-half-o"></span>';
        }
        if (i < 5) {
            for (var j = 0; j < 5 - i; j++) {
                spstar += '<span class="fa fa-star-o"></span>';
            }
        }
        return spstar;
    }

    // find status of rating
    function getRatingStatus(rating) {
        var rat = Math.floor(rating);
        var status = "";
        switch (rat) {
            case 5:
                status = "Excellent";
                break;
            case 4:
                status = "Very Good";
                break;
            case 3:
                status = "Good";
                break;
            case 2:
                status = "Poor";
                break;
            case 1:
                status = "Very Poor";
                break;
        }
        return status;
    }


    function setDashboard(results) {
        $(".request-count.blue").text(results.new);
        $(".request-count.green").text(results.upcoming);
        $(".request-count.red").text(results.paymentdue);
    }

    function setNewRequest(results) {
        var html = '';
        var i = 0;
        results.forEach((result) => {
            var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
            var assignto = (result.ServiceProviderId == null) ? "None" : "<kbd>You</kbd>";
            html += `
      <tr id='data_${i++}'>
        <td scope="row" style="line-height: 50px;">${("000" + result.ServiceRequestId).slice(-4)}</td>
        <td>
            <div class="td-date"><img src="static/images/icon-calculator.png" alt=""><b>${date.startdate}</b></div>
            <div class="td-time"><img src="static/images/icon-time.png" alt="">${date.starttime}-${date.endtime}</div>
        </td>
        <td>
            <div class="td-name" style='padding-left: 26px;'>${result.FirstName} ${result.LastName}</div>
            <div class="td-address"><img src="./static/images/icon-address.png" style='margin-bottom: 8px;'>${result.AddressLine1} ${result.AddressLine2}, ${result.PostalCode} ${result.City}</div>
        </td>
        <td>${result.TotalCost}€</td>
        <td>${assignto}</td>
        <td class="btn-accept"><button data-bs-toggle="modal" data-bs-target="#exampleModalServiceAccept" data-bs-dismiss="modal">Accept</button></td>
      </tr>
      `;
        });
        $("table tbody").html(html);
    }

    function setUpcomingRequest(results) {
        var html = '';
        var i = 0;
        results.forEach((result) => {
            var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
            html += `
      <tr id='data_${i++}'>
        <td scope="row" style="line-height: 50px;">${("000" + result.ServiceRequestId).slice(-4)}</td>
        <td>
            <div class="td-date"><img src="static/images/icon-calculator.png" alt=""><b>${date.startdate}</b></div>
            <div class="td-time"><img src="static/images/icon-time.png" alt="">${date.starttime}-${date.endtime}</div>
        </td>
        <td>
            <div class="td-name" style='padding-left: 26px;'>${result.FirstName} ${result.LastName}</div>
            <div class="td-address"><img src="./static/images/icon-address.png" style='margin-bottom: 8px;'>${result.AddressLine1} ${result.AddressLine2}, ${result.PostalCode} ${result.City}</div>
        </td>
        <td class="btn-cancel"><button data-bs-toggle="modal" data-bs-target="#exampleModalServiceCancel" data-bs-dismiss="modal">Cancel</button></td>
      </tr>
      `;
        });
        $("table tbody").html(html);
    }

    function setSchedules(results) {
        $(".dov-content").html(results);
    }

    function setHistory(results) {
        var html = '';
        var i = 0;
        results.forEach((result) => {
            var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);

            var status = "";
            if (result.Status == 3) { status = "cancelled" } else if (result.Status == 4) { status = "completed" } else if (result.Status == 5) { status = "refunded" }
            var bywhom = "";
            if (result.Status == 4 || (result.Status == 3 && result.RecordVersion == 1 && result.ModifiedBy == result.ServiceProviderId)) {
                bywhom = "You";
            } else {
                bywhom = ("000" + result.ModifiedBy).split(-4);
            }

            html += `
      <tr id='data_${i++}'>
        <td scope="row" style="line-height: 50px;">${("000" + result.ServiceRequestId).slice(-4)}</td>
        <td>
            <div class="td-date"><img src="static/images/icon-calculator.png" alt=""><b>${date.startdate}</b></div>
            <div class="td-time"><img src="static/images/icon-time.png" alt="">${date.starttime}-${date.endtime}</div>
        </td>
        <td>
            <div class="td-name" style='padding-left: 26px;'>${result.FirstName} ${result.LastName} (${("00"+result.UserId).split(-3)})</div>
            <div class="td-address"><img src="./static/images/icon-address.png" style='margin-bottom: 8px;'>${result.AddressLine1} ${result.AddressLine2}, ${result.PostalCode} ${result.City}</div>
        </td>
        <td><button class='${status}' title='${status} by ${bywhom}'>${status}</button></td>
      </tr>
      `;
        });
        $("table tbody").html(html);
    }

    function setRatings(results) {
        var html = '';
        var i = 0;
        results.forEach((result) => {
            var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
            var comment = (result.Comments == "") ? "No Comment" : result.Comments;
            var spstar = getStarHTMLByRating(+result.Ratings);
            var starstatus = getRatingStatus(+result.Ratings);
            html += `
      <div class="row" id='data_${i++}'>
            <div class="col-3 row-col">
                <div>${("000" + result.ServiceRequestId).slice(-4)}</div>
                <div class="td-name">${result.FirstName} ${result.LastName}</div>
            </div>
            <div class="col-3 row-col">
                <div class="td-date"><img src="./static/images/icon-calculator.png" alt=""><b>${date.startdate}</b></div>
                <div class="td-time"><img src="./static/images/icon-time.png" alt="">${date.starttime}-${date.endtime}</div>
            </div>
            <div class="col row-col">
                <div>Ratings</div>
                <div class="info-ratings">
                    ${spstar}
                    ${starstatus}
                </div>
            </div>
            <div class="row row-comment">
                <div>Customer Comment</div>
                <div class="rating-comment">${comment}</div>
            </div>
        </div>
      `;
        });
        $("#userrating").html(html);
    }

    function setBlocks(results) {
        var html = '';
        var i = 0;
        results.forEach((result) => {
            var block = result.IsBlocked == 0 ? "Block" : "UnBlock";
            html += `
      <div class="pro" id='data_${i++}'>
                <div class="pro-avtar">
                    <img src="./static/images/avtar/avtar1.png">
                </div>
                <div class="pro-name">${result.FullName}</div>
                <div class="pro-button">
                    <p class="userblock" style="display:none;">${result.Id}</p>
                    <button class="button-block">${block}</button>
                </div>
      </div>
      `;
        });
        $(".pros").html(html);
    }

});