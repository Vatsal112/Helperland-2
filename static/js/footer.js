$(document).ready(function () {
  $(window).scroll(function () {
    if (this.scrollY > 450) {
      $(".scroll-icon").css("display", "flex");
      $(".message-icon").css("bottom", "190px");
    } else {
      $(".scroll-icon").css("display", "none");
      $(".message-icon").css("bottom", "70px");
    }
  });

  var check_session;
  function CheckForSession() {
    var str = "chksession=true";
    // jQuery.ajax({
    //   type: "POST",
    //   url: "/helperland/helperland/chk_session.php",
    //   data: str,
    //   cache: false,
    //   success: function (res) {
    //     //alert(res);
    //     if (res == "1") {
    //       alert("Your session has been expired!");
    //       location.reload();
    //     }
    //   },
    // });
  }
  check_session = setInterval(CheckForSession, 5000);
});
