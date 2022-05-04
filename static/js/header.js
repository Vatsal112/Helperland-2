function showLoader() {
    $.LoadingOverlay("show", {
        background: "rgba(0, 0, 0, 0.7)",
    });
}

$(document).ready(function() {
    $(".menu-bar").click(function() {
        $(".nav-list").toggleClass("active");
        $(".menu-bar i").toggleClass("active");
    });
    $(".sidebar-toggle").on("click", function() {
        $(".div-sidebar").toggleClass("toggle");
        $(".sidebar-toggle i").toggleClass("toggle");
    });
    if (window.scrollY > 30) {
        $(".navbar").addClass("sticky");
    } else {
        $(".navbar").removeClass("sticky");
    }
    $(window).scroll(function() {
        if (this.scrollY > 30) {
            $(".navbar").addClass("sticky");
            $(".div-sidebar").addClass("sticky");
        } else {
            $(".navbar").removeClass("sticky");
            $(".div-sidebar").removeClass("sticky");
        }
    });

    setTimeout(toCheckSession, 1000);

    function toCheckSession() {
        if ($("#isLogin").val() != 0) {
            jQuery.ajax({
                type: "POST",
                url: "http://localhost/HelperLand/?controller=Users&function=CheckSession",
                datatype: "json",
                data: $("#addform").serialize(),
                success: function(data) {
                    if (data == 1) {
                        window.location.href = "http://localhost/HelperLand/?controller=Default&function=homepage&parameter=sessionmodal";
                        // if (!$("#sessionexpired").hasClass("show")) {
                        //   $("#sessionexpired").modal("show");
                        // }
                    }
                },
                complete: function(data) {
                    setTimeout(toCheckSession, 1000);
                },
            });
        }
    }

    $("#sessionexpired .modal-footer button").on("click", function() {
        location.reload();
    });

    $("#sessionexpired").modal({
        backdrop: "static",
        keyboard: false,
    });

    // rating to service provider
    $("#stars li").on("mouseover", function() {
            var onStar = parseInt($(this).data("value"), 10);
            $(this).parent().children("li.star").each(function(e) {
                if (e < onStar) {
                    $(this).addClass("hover");
                } else {
                    $(this).removeClass("hover");
                }
            });
        })
        .on("mouseout", function() {
            $(this).parent().children("li.star").each(function(e) {
                $(this).removeClass("hover");
            });
        });
    $("#stars li").on("click", function() {
        var onStar = parseInt($(this).data("value"), 10);
        var stars = $(this).parent().children("li.star");
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass("selected");
        }
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass("selected");
        }
        var ratingValue = parseInt(
            $("#stars li.selected").last().data("value"), 10);
    });
});