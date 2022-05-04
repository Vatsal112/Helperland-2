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
    var req = $("#req").val();
    today.setDate(today.getDate() + 1);
    var tommorrow = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
    var currentpage = 1; // current page number
    var showrecords = $(".show-apge select").val(); // total records shown in select input
    var totalpage = 1;
    var records = [];
    var totalrecords = 0;

    switch (req) {
        case "setting":
            break;
        default:
            getDefaultRecords();
            setTimeout(setDefault, 100);
    }

    // this is function to set default thinks or call by timeout vecause of late ajax responce
    function setDefault() {
        totalrecords = $(".show-apge .totalrecords").text();
        totalpage = Math.ceil(totalrecords / showrecords);
        totalpage = totalpage == 0 ? 1 : totalpage;
        getAjaxDataByReq();
    }

    //
    $(document).on("click", "#ratesp", function(e) {
        e.preventDefault();
        var sprat = $(this).parent().parent().find(".td-rating").html();
        $("#Ratesp").find(".td-rating").html(sprat);
        var serviceid = +$(this).parent().parent().find(".serviceid").text();
        var index = $(this).parent().parent().prop("id").split("_")[1];
        var result = records[index];
        $("#serviceid").val(serviceid);
        $(".rating-index").text(index);
        UpdateRatingForm(result);
        if (result.RatingId == undefined) {
            $("#btn_ratesp").text("Submit");
        } else {
            $("#btn_ratesp").text("Update");
        }
    });

    function UpdateRatingForm(result) {
        $("#Ratesp .rate .star").removeClass("selected");
        $("#rate_feedback").val("");
        $("#ratingid").val("");
        if (result.RatingId != undefined) {
            var ontimearrival = result.OnTimeArrival;
            var friendly = result.Friendly;
            var quality = result.QualityOfService;
            selectTheStar(".ontimearrival", ontimearrival);
            selectTheStar(".friendly", friendly);
            selectTheStar(".quality", quality);
            $("#rate_feedback").val((result.Comments == null) ? "" : result.Comments);
            $("#ratingid").val(result.RatingId);
        }
    }

    function selectTheStar(cls, val) {
        var clslist = document.querySelectorAll(cls + " .star");
        //alert(clslist.length);
        for (var i = 0; i < val; i++) {
            clslist[i].classList.add("selected");
        }
    }

    $(document).on("click", "#btn_ratesp", function(e) {
        e.preventDefault();
        $(".alert").remove();
        $(".error").remove();
        var ontimearrival = $(".ontimearrival li.selected").last().data("value");
        var friendly = $(".friendly li.selected").last().data("value");
        var quality = $(".quality li.selected").last().data("value");
        ontimearrival = (ontimearrival == undefined) ? 0 : ontimearrival;
        friendly = (friendly == undefined) ? 0 : friendly;
        quality = (quality == undefined) ? 0 : quality;
        var func = ($(this).text().toLowerCase() == "submit") ? "InsertRating" : "UpdateRating";
        var data = $("#form_ratesp").serializeArray();
        data.push({ name: "ontimearrival", value: ontimearrival });
        data.push({ name: "friendly", value: friendly });
        data.push({ name: "quality", value: quality });
        jQuery.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=Users&function=" + func,
            datatype: "json",
            data: data,
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.errors.length == 0) {
                    getAjaxDataByReq();
                    $("#btn_ratesp").text("Update");
                    $("#Ratesp").modal("hide");
                    $(".shistory-title").after('<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">Your rating saved successfully!!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                } else {
                    var errorlist = "";
                    for (const [key, val] of Object.entries(obj.errors)) {
                        errorlist += `<li>${val}</li>`;
                    }
                    $(".shistory-title").after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
            }
        });
    });

    // when user want to edit address 
    $(document).on("click", ".edit-address", function(e) {
        e.preventDefault();
        $('.error').remove();
        $(".alert").remove();
        var id = $(this).parent().prop("id").split("_")[1];
        $("#addid").val(id);
        jQuery.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=Users&function=getUserAddress",
            datatype: "json",
            data: { addid: id },
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.errors.length == 0) {
                    let a = obj.result;
                    $(".add-title").text("Edit");
                    $("#add-street").val(a.AddressLine2);
                    $("#add-house").val(a.AddressLine1);
                    $("#add-postal").val(a.PostalCode);
                    var option = "<option value=" + a.City.toLowerCase() + " selected>" + a.City + "</option>";
                    $("#add-city").html(option);
                    $("#add-mobile").val(a.Mobile);
                    $("#form_address button[type=submit]").prop("id", "btn_editaddress");
                    $("#btn_editaddress").text("Edit Address");
                    $("#exampleModalAddress").modal("show");
                } else {
                    alert("Somthing went wrong");
                }
            }
        });
    });

    // when user want to add address
    $(document).on("click", ".btn-newaddress", function() {
        $('.error').remove();
        $(".alert").remove();
        $("#form_address").trigger("reset");
        $("#add-city").html("");
        $(".add-title").text("Add");
        $("#addid").val("");
        $("#form_address button[type=submit]").prop("id", "btn_addaddress");
        $("#btn_addaddress").text("Add Address");
        $("#exampleModalAddress").modal("show");
        // alert();
    });

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
                        $("#add-city").html(option);
                        //alert(obj.result.CityName);
                    } else {
                        $("#add-city").html("");
                        $("#add-postal").after("<span class='error'>*invalid postal code</span>");
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        } else {
            $("#add-city").html("");
        }
    });

    // when user want to delete address 
    $(document).on("click", ".delete-address", function(e) {
        e.preventDefault();
        $(".alert").remove();
        if (confirm("Are you sure??")) {
            var id = $(this).parent().prop("id").split("_")[1];
            showLoader();
            jQuery.ajax({
                type: "POST",
                url: "http://localhost/HelperLand/?controller=Users&function=DeleteUserAddress",
                datatype: "json",
                data: { addid: id },
                success: function(data) {
                    var obj = JSON.parse(data);
                    console.log(obj);
                    if (obj.errors.length == 0) {
                        var html = setUserAddress(obj.result);
                        $(".my-addresses table tbody").html(html);
                        $(".my-addresses").prepend('<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">Address Deleted successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $(".my-addresses").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
    });

    //
    $(document).on('click', '#btn_addaddress', function(e) {
        e.preventDefault();
        $(".alert").remove();
        if ($(this).parent().find('.error').length == 0) {
            var action = $("#form_address").prop("action");
            action += 'InsertUserAddress';
            showLoader();
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form_address").serialize(),
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        var html = setUserAddress(obj.result);
                        $(".my-addresses table tbody").html(html);
                        $("#form_address").trigger("reset");
                        $("#add-city").html("");
                        $("#form_address").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">Address Add Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#form_address").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
    });

    $(document).on('click', '#btn_editaddress', function(e) {
        e.preventDefault();
        $(".alert").remove();
        if ($(this).parent().find('.error').length == 0) {
            var action = $("#form_address").prop("action");
            action += 'UpdateUserAddress';
            showLoader();
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form_address").serialize(),
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        var html = setUserAddress(obj.result);
                        $(".my-addresses table tbody").html(html);
                        $("#form_address").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">Address Update Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#form_address").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
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
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        $("#form-changepassword").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"><ul class="success">Password Changed Successfully!!</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        $("#form-changepassword").trigger("reset");
                    } else {
                        var errorlist = "";
                        for (const [key, val] of Object.entries(obj.errors)) {
                            errorlist += `<li>${val}</li>`;
                        }
                        $("#form-changepassword").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' + errorlist + '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
    });

    // when user update the detailes from setting
    $(document).on("click", "#btn-saveuser", function(e) {
        e.preventDefault();
        if ($(this).parent().find('.error').length == 0) {
            showLoader();
            var action = $(this).parent().prop("action");
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $(this).parent().serialize(),
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.errors.length == 0) {
                        $('#firstname').val(obj.result.FirstName);
                        $(".header-image span").text(obj.result.FirstName);
                        $('#lastname').val(obj.result.LastName);
                        $('#phonenumber').val(obj.result.Mobile);
                        $('#email').val(obj.result.Email);
                        if (obj.result.DateOfBirth == null) {
                            var date = new Date('Y-m-d', obj.result.DateOfBirth);
                            $('#birthdate').val(date);
                        }
                        $("#form-usersave").prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"><ul class="success">user saved Successfully!!</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else {
                        $("#form-usersave").prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="error">Somthing went wrong!!</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                },
            });
        }
    });

    // when click on the favourite and button
    $(document).on("click", ".favourite_btn", function() {
        var id = $(this).parent().find(".favourite").text();
        var is = $(this).text();
        jQuery.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=CDashboard&function=UpdateFavouriteUser",
            datatype: "json",
            data: { f_id: id, f_is: is },
            success: function(data) {
                getAjaxDataByReq();
            },
        });
    });

    $(document).on("click", ".block_btn", function() {
        var id = $(this).parent().find(".favourite").text();
        var is = $(this).text();
        jQuery.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=CDashboard&function=UpdateBlockUser",
            datatype: "json",
            data: { b_id: id, b_is: is },
            success: function(data) {
                getAjaxDataByReq();
            },
        });
    });

    // thhi is a function to update pagination when somebody change show records dropdown
    $(document).on("change", ".show-apge select", function() {
        showrecords = $(this).val();
        totalpage = Math.ceil(totalrecords / showrecords);
        totalpage = totalpage == 0 ? 1 : totalpage;
        currentpage = 1;
        updatePageNumber(currentpage);
        getAjaxDataByReq();
    });

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

    // when user wants to reschedule servicie
    $(document).on("click", "#reschedule_update", function(e) {
        showLoader();
        e.preventDefault();
        $(".alert").remove();
        var action = $(this).parent().prop("action");
        jQuery.ajax({
            type: "POST",
            url: action,
            datatype: "json",
            data: $("#form-reschedule").serialize(),
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.errors.length == 0) {
                    $("#form-reschedule").prepend(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert"><ul class="success">Service rescheduled Successfully!!</ul></div>'
                    );
                    getAjaxDataByReq();
                } else {
                    var errorlist = "";
                    for (const [key, val] of Object.entries(obj.errors)) {
                        errorlist += `<li>${val}</li>`;
                    }
                    $("#form-reschedule").prepend(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="errorlist">' +
                        errorlist +
                        "</ul></div>"
                    );
                }
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
            jQuery.ajax({
                type: "POST",
                url: action,
                datatype: "json",
                data: $("#form-service-cancel").serialize(),
                success: function(data) {
                    var obj = JSON.parse(data);
                    console.log(obj.result);
                    var serviceid = ("000" + $("#form-service-cancel input[type=hidden]").val()).slice(-4);
                    if (obj.result == 1) {
                        $("#exampleModalServiceCancel").modal("hide");
                        getAjaxDataByReq();
                        $("#servicerequest .success-msg").html(
                            "<h4>Your service request canceled successfully</h4><br> cancelled Request Id " +
                            serviceid
                        );
                        $("#servicerequest").modal("show");
                    } else {
                        alert("Somthing went wrong with service request " + serviceid);
                    }
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

    // when direct click from
    $(document).on("click", ".btn-cancel", function() {
        var serviceid = +$(this).parent().parent().find(".serviceid").text();
        $("#exampleModalServiceCancel .modal-body input[type=hidden]").val(
            serviceid
        );
    });

    $(document).on("click", ".btn-reschedule", function() {
        $(".alert").remove();
        var index = $(this).parent().parent().prop("id").split("_")[1];
        var result = records[index];
        $("#exampleModalServiceReschedule .modal-body .reschedule_sid").val(result.ServiceRequestId);
        $("#exampleModalServiceReschedule .modal-body input[type=date]").val(tommorrow);
        $("#exampleModalServiceReschedule .modal-body input[type=date]").prop("min", tommorrow);
    });

    // when click from detailes modal
    $(document).on("click", ".scancel", function(e) {
        e.preventDefault();
        var serviceid = +$(this).parent().parent().parent().find(".sid").text();
        $("#exampleModalServiceCancel .modal-body input[type=hidden]").val(
            serviceid
        );
    });

    $(document).on("click", ".sreschedule", function(e) {
        $(".alert").remove();
        e.preventDefault();
        var serviceid = +$(this).parent().parent().parent().find(".sid").text();
        $("#exampleModalServiceReschedule .modal-body input[type=hidden]").val(serviceid);
        $("#exampleModalServiceReschedule .modal-body input[type=date]").val(tommorrow);
        $("#exampleModalServiceReschedule .modal-body input[type=date]").prop("min", tommorrow);
    });

    // this is update detailes modal content according to clicked row
    $(document).on("click", ".show_detailes", function() {
        var index = $(this).parent().prop("id").split("_")[1];
        var result = records[index];
        var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);

        var status = result.Status;
        var buttons = $(".modal-button").html();
        if (["3", "4"].includes(status)) {
            $(".modal-button").html("");
        } else {
            $(".modal-button").html(buttons);
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
        var totalbill = result.TotalCost;
        var serviceaddress = result.AddressLine1 + " " + result.AddressLine2 + ", " + result.City + ", " + result.PostalCode;
        var haspets = result.HasPets;

        $(".m-time").text(
            date.startdate + " " + date.starttime + "-" + date.endtime
        );
        $(".total-duration").text(result.ServiceHours);
        $(".sid").text(("000" + result.ServiceRequestId).slice(-4));
        $(".extraslist").text(extrahtml);
        $(".m-currency").text(totalbill + "€");
        $(".saddress").text(serviceaddress);
        $(".smobile").text(result.Mobile);
        $(".semail").text(result.Email);
        $(".haspets").html(
            haspets == 0 ?
            '<span class="fa fa-times-circle-o"></span> I dont`t have pets at home' :
            '<span class="fa fa-check" style="color:#0f7a2b"></span> I have pets at home'
        );
    });

    //
    function setUserAddress(results) {
        var html = '';
        var i = 1;
        results.forEach((result) => {
            var add = result;
            var addressline = add.AddressLine1 + " " + add.AddressLine2 + ", " + add.PostalCode + " " + add.City;
            var mobile = add.Mobile;
            var addid = add.AddressId;
            html += `
        <tr>
          <td class='add_index'>${i++}</td>
          <td>
              <div>Address: <span>${addressline}</span></div>
              <div>Phone number: <span>${mobile}</span></div>
          </td>
          <td id=add_${addid} >
              <a href="#" class="edit-address"><img src="./static/images/edit-icon.png" alt=""></a>
              <a href="#" class="delete-address"><img src="./static/images/delete-icon.png" alt=""></a>
          </td>
        </tr>
      `;
        });
        return html;
    }

    // this is a function get total records from database
    function getDefaultRecords() {
        $.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=CDashboard&function=TotalRequest&parameter=" +
                req,
            datatype: "json",
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                var totalrequest = obj.result.Total;
                $(".show-apge .totalrecords").text(totalrequest);
            },
        });
    }

    // this is a function to get service data according to currentpage, showrecords and apge request
    function getAjaxDataByReq() {
        showLoader();
        $.ajax({
            type: "POST",
            url: "http://localhost/HelperLand/?controller=CDashboard&function=ServiceRequest&parameter=" +
                req,
            datatype: "json",
            data: { pagenumber: currentpage, limit: showrecords },
            success: function(data) {
                console.log(data);
                //alert(data);
                obj = JSON.parse(data);
                $("table tbody").html("");
                if (obj.errors.length == 0) {
                    records = obj.result;
                    switch (req) {
                        case "service-history":
                            setDashboardTabRows(obj.result);
                            break;
                        case "favorite-pros":
                            setFavoriteProsTabs(obj.result);
                            break;
                        case "setting":
                            break;
                        case "dashboard":
                            setDashboardTabRows(obj.result);
                            break;
                        default:
                            setDashboardTabRows(obj.result);
                    }
                }
            },
            complete: function(data) {
                $.LoadingOverlay("hide");
            },
        });
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

    // this is function for updating content of favorite pros table
    function setFavoriteProsTabs(results) {
        $("#pros").html("");
        var html = "";
        results.forEach((result) => {
            console.log(result);
            var avatar = result.UserProfilePicture == null ? "avatar-hat.png" : result.UserProfilePicture + ".png";
            var avgrating = result.AverageRating == null ? 0 : (+result.AverageRating).toFixed(2);
            var spstar = getStarHTMLByRating(avgrating);
            var favourite = result.IsFavorite == 0 ? "Favourite" : "UnFavourite";
            var block = result.IsBlocked == 0 ? "Block" : "UnBlock";
            html += `
      <div class="pro">
                <div class="pro-avtar">
                  <img src="./static/images/avtar/${avatar}">
                </div>
                <div class="pro-name">${result.Fullname}</div>
                <div class="info-ratings">
                                ${spstar}
                                (${avgrating})
                </div>
                <div class="pro-cleanings">${result.TotalRating} Cleanings</div>
                <div class="pro-button">
                    <p class="favourite" style="display:none;">${result.Id}</p>
                    <button class="button-remove favourite_btn">${favourite}</button>
                    <button class="button-block block_btn">${block}</button>
                </div>
      </div>
      `;
        });
        $("#pros").html(html);
    }

    // this is function for updating content of table body by getting rows from ajax as services
    function setDashboardTabRows(results) {
        var html = "";
        var i = 0;
        results.forEach((result) => {
            //console.log(result);
            var sphtml = "";
            var status = result.Status;
            var stshtml = "";
            var accepthtml = "";
            var record_veresion = result.RecordVersion;
            if (["3", "4", "5"].includes(status)) {
                if (status == 3) {
                    stshtml +=
                        '<td class="btn-status cancelled"><button>Cancelled</button></td><td class="btn-ratesp"><button class="disabled" disabled>RateSP</button></td>';
                } else if (status == 4) {
                    stshtml +=
                        '<td class="btn-status completed"><button>Completed</button></td><td class="btn-ratesp"><button data-bs-toggle="modal" data-bs-target="#Ratesp" data-bs-dismiss="modal" id="ratesp">RateSP</button></td>';
                } else if (status == 5) {
                    stshtml +=
                        '<td class="btn-status refunded"><button>refunded</button></td><td class="btn-ratesp"><button class="disabled" disabled>RateSP</button></td>'
                }
            }
            if (["0", "1", "2"].includes(status)) {
                if (status == 0 || status == 1) {
                    accepthtml +=
                        '<td class="btn-status">NO</td>';
                } else if (status == 2) {
                    accepthtml +=
                        '<td class="btn-status">YES</td>'
                }
            }
            if (result.ServiceProviderId != null) {
                var avatar =
                    result.UserProfilePicture == null ?
                    "avatar-hat.png" :
                    result.UserProfilePicture + ".png";
                var avgrating = result.AverageRating;
                var spstar = getStarHTMLByRating(avgrating);
                var avgrating = (+result.AverageRating).toFixed(2);
                sphtml = `
            <div class="rating-user"><img src="./static/images/avtar/${avatar}" alt="">
                            </div>
                            <div class="rating-info">
                                <div class="info-name">${result.Fullname}</div>
                                <div class="info-ratings">${spstar}
                                    (${avgrating})
                                </div>
                            </div>
            `;
            }
            var date = getTimeAndDate(result.ServiceStartDate, result.ServiceHours);
            html += `
        <tr id='data_${i}'>
                    <td scope="row"  style="line-height: 50px;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalServiceDetailes" data-bs-dismiss="modal" class='serviceid show_detailes'>${(
                      "000" + result.ServiceRequestId
                    ).slice(-4)}</td>
                    <td style='cursor:pointer;' data-bs-toggle="modal" data-bs-target="#exampleModalServiceDetailes" data-bs-dismiss="modal" class='show_detailes'>
                        <div class="td-date"><img src="./static/images/icon-calculator.png" alt=""><b>${date.startdate}</b></div>
                        <div class="td-time"><img src="./static/images/icon-time.png" alt="">${date.starttime}-${date.endtime}</div>
                    </td>
                    <td>
                        <div class="td-rating rating_${i}">
                            ${sphtml}
                        </div>
                    </td>
                    <td style="line-height: 50px;">
                        <div class="td-currn">€<span>${
                          result.TotalCost
                        }</span></div>
                    </td>
                    `;
            if (stshtml == "") {
                html += accepthtml;
                if (record_veresion != 1) {
                    html += `<td class="btn-dashboard">
              <button class="btn-reschedule" data-bs-toggle="modal" data-bs-target="#exampleModalServiceReschedule" data-bs-dismiss="modal">Reschedule</button>
              <button class="btn-cancel" data-bs-toggle="modal" data-bs-target="#exampleModalServiceCancel" data-bs-dismiss="modal">Cancel</button>
            </td>
          </tr>`;
                } else {
                    html += `<td class="btn-dashboard"><p class='rescheduled-msg'>You have rescheduled service request. Your SP will accept it soon</p>
          </tr>`;
                }
            } else {
                html += stshtml + "</tr>";
            }

            i++;
        });
        $("table tbody").html(html);
    }

    // for updating page number
    function updatePageNumber(number) {
        if (totalpage < currentpage) {
            number = totalpage;
        }
        $(".paginations .current-page").text(number);
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

});

function sortTable(n) {
    var table;
    table = document.getElementById('table');
    var rows, i, x, y, count = 0;
    var switching = true;
    var direction = "asc";

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            var Switch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (direction == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    Switch = true;
                    break;
                }
            } else if (direction == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    Switch = true;
                    break;
                }
            }
        }
        if (Switch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            count++;
        } else {
            if (count == 0 && direction == "asc") {
                direction = "desc";
                switching = true;
            }
        }
    }
}