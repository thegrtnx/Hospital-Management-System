$(document).ready(function () {

  //var pk = 'pk_live_7a2adba82cb1a1fc7bf752451c000e431d74bdc3';




  //signup
  $("#sub").click(function () {
    var fname = $("#fname").val();
    var email = $("#email").val();
    var catgy = $("#catgy").val();
    var pword = $("#pword").val();
    var cpword = $("#cpword").val();
    

    if (fname == "" || fname == null) {
      $(toastr.error("Please input your name"));
    } else {
        if (email == "" || email == null) {
          $(toastr.error("Your email address can't be empty"));
        } else {
          if (pword == "" || pword == null) {
            $(toastr.error("Please create a secured password"));
          } else {
            if (cpword == "" || cpword == null) {
              $(toastr.error("Confirm your password"));
            } else {
              if (pword != cpword) {
                $(toastr.error("Password does not match"));
              } else {
                $("#msg").html(
                  '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
                );

                $.ajax({
                  type: "post",
                  url: "functions/init.php",
                  data: {
                    fname: fname,
                    email: email,
                    pword: pword,
                    cpword: cpword,
                    catgy, catgy,
                  },
                  beforeSend: function() {
                    $(toastr.clear());
                    $("#sub").html("Submitting... Please wait");
                 },
                  success: function (data) {
                    $(toastr.success(data));
                  },
                });
              }
            }
          }
        }
      }
  });



  //resend otp
  $("#rotp").click(function () {
    $("#otptitle").html("We've sent you another OTP ✅");

    //I left this code so as to give a dummy text to the function validator
    var otpp = "dummy";

    $("#vmsg").html(
      '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
    );

    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: { otpp: otpp },
      success: function (data) {
        $("#vmsg").html(data);
      },
    });
  });


  //verify otp
  $("#vsub").click(function () {
    var digit1 = $("#digit-1").val();
    var digit2 = $("#digit-2").val();
    var digit3 = $("#digit-3").val();
    var digit4 = $("#digit-4").val();

    if (digit1 == "" || digit1 == null) {
      $("#vmsg").html("Invalid OTP!");
    } else {
      if (digit2 == "" || digit2 == null) {
        $("#vmsg").html("Invalid OTP!");
      } else {
        if (digit3 == "" || digit3 == null) {
          $("#vmsg").html("Invalid OTP!");
        } else {
          if (digit4 == "" || digit4 == null) {
            $("#vmsg").html("Invalid OTP!");
          } else {
            var votp = digit1 + digit2 + digit3 + digit4;

            $("#vmsg").html(
              '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
            );

            $.ajax({
              type: "post",
              url: "functions/init.php",
              data: { votp: votp },
              success: function (data) {
                $("#vmsg").html(data);
              },
            });
          }
        }
      }
    }

    alert(allotp);
    /* var votp   = $("#otpper").val();
   var votp   = $("#otpper").val();
   var votp   = $("#otpper").val();

  document.getElementById("rvmsg").style.display = 'none';
  document.getElementById("vmsg").style.display = 'block';

      if (votp == "" || votp == null) {
      $("#vmsg").html("Invalid OTP!");
    } else {
    $("#vmsg").html("Loading... Please Wait");
    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: {votp: votp},
      success: function (data) {
        $("#vmsg").html(data);
      },
    });
  }*/
  });



  //signin
  $("#lsub").click(function () {
    var username = $("#luname").val();
    var password = $("#lpword").val();

    if (username == "" || username == null) {
      $("#lumsg").html("Kindly insert your username");
    } else {
      if (password == "" || password == null) {
        $("#lupmsg").html("Invalid password inputted");
      } else {
        $("#lmsg").html(
          '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
        );
        $.ajax({
          type: "post",
          url: "functions/init.php",
          data: { username: username, password: password },
          success: function (data) {
            $("#lmsg").html(data);
          },
        });
      }
    }
  });



  //forgot
  $("#fsub").click(function () {
    var fgeml = $("#femail").val();

    if (fgeml == "" || fgeml == null) {
      $("#fmsg").html("Please insert your email");
    } else {
      $("#fmsg").html(
        '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
      );

      $.ajax({
        type: "post",
        url: "functions/init.php",
        data: { fgeml: fgeml },
        success: function (data) {
          $("#fmsg").html(data);
        },
      });
    }
  });



  //reset
  $("#updf").click(function () {
    var fgpword = $("#pword").val();
    var fgcpword = $("#cpword").val();

    if (fgpword == "" || fgpword == null) {
      $("#umsg").html("Please create a new password");
    } else {
      if (fgcpword == "" || fgcpword == null) {
        $("#umsg").html("Kindly confirm Your Password");
      } else {
        if (fgpword != fgcpword) {
          $("#umsg").html("Password does not match!");
        } else {
          $("#umsg").html(
            '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
          );

          $.ajax({
            type: "post",
            url: "functions/init.php",
            data: { fgpword: fgpword, fgcpword: fgcpword },
            success: function (data) {
              $("#umsg").html(data);
            },
          });
        }
      }
    }
  });



  /******** USER PROFILE SECTION */

  //getting books details
  $(".offcanvasr").click(function () {
    var dataid = $(this).attr("data-id");

    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: { dataid: dataid },
      success: function (data) {
        $(".canvastale").html(data);
      },
    });
  });



  //search for books
  $("#searcher").keyup(function () {
    var searchword = $("#searcher").val();

    //display content if words are empty
    $("#allbook").hide();

    if (searchword == null || searchword == "") {
      $("#allbook").show();
    } else {
      //$("#searchresult").show(1000);

      $.ajax({
        type: "post",
        url: "srchres.php",
        data: { searchword: searchword },
        success: function (data) {
          $("#searchresult").html(data).show(1000);
        },
      });
    }
  });



  //add to wishlist
  $("#btwsh").click(function () {
    var wishid = $("#srchid").val();

    $("#btwsh").on("shown.bs.popover", function () {
      setTimeout(function () {
        $(".popover").fadeOut("slow", function () {});
      }, 800);
    });

    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: { wishid: wishid },
      success: function (data) {
        //display content if words are empty
        $("#btwsh").hide();

        $("#addtwh").show();
      },
    });
  });



  //added to wishlist
  $("#lksd").click(function () {
    $("#lksd").on("shown.bs.popover", function () {
      setTimeout(function () {
        $(".popover").fadeOut("slow", function () {});
      }, 800);
    });
  });


  //cancel payment
  $("#cnc").click(function () {
    $("#clss").popover("hide");
  });



  //fund wallet
  $("#paybtn").click(function () {
    var amt = $("#amrp").val();

    if (amt == "" || amt == null) {
      $("#pymsg").html("Please input an amount");
    } else {
      if (amt < 100) {
        $("#pymsg").html("The minimum amount you can fund is ₦100");
      } else {
        $("#pymsg").html(
          '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
        );

        var ema = $("#email").text();

        let handler = PaystackPop.setup({
          key: pk, // Replace with your public key
          email: ema,
          amount: amt * 100,
          ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
          // label: "Optional string that replaces customer email"
          onClose: function() {
          
            $("#pybstdd").show();
            $("#pymsg").html('You cancelled your payment. <br/>Click on the "Fund Wallet" button to re-try funding your wallet');
           
          },
          callback: function(response){
           
            window.location = "./pay?reference=" + response.reference + "&stat=funding";
            
          }
        });
      
        handler.openIframe();
      }
    }
  });



  //insufficient fund to buy book, pay directly without funding
  $("#hey").click(function () {

    var amt = $("#amount").val();
    var bkid = $("#bookid").val();
    var emal = $("#email-address").val();

    $("#bkpymsg").html('<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait');
    

    let handler = PaystackPop.setup({
      key: pk, // Replace with your public key
      email: emal,
      amount: amt * 100,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      // label: "Optional string that replaces customer email"
      onClose: function() {
      
        $("#bkpymsg").html('You cancelled your payment');
       
      },
      callback: function(response){
       
        window.location = "./pay?reference=" + response.reference + "&stat=buying&bbid=" + bkid;
        
      }
    });
  
    handler.openIframe();
    //alert("hello");
  })



  //buy book
  $("#bkkpaybtn").click(function () {
    $("#bkpymsg").html(
      '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
    );

    var amt = $("#bkamt").text();
    var bkid = $("#bkid").text();
    var authoremail = $("#authoremail").text();
    var bkprice = $("#bkprice").text();
    var rylty = $("#rylty").text();

    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: { amt: amt, bkid: bkid, authoremail: authoremail, bkprice: bkprice, rylty: rylty },
      success: function (data) {
        $("#bkpymsg").html(data);
      },
    });
  });



  //upgrade account
  $("#upgrd").click(function () {
    $("#note").html(
      '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
    );

    var upgrade = 'author';

    $.ajax({
      type: "post",
      url: "functions/init.php",
      data: { upgrade: upgrade },
      success: function (data) {
        $("#note").html(data);
      },
    });
  });


  
  //save profile details changes
  $("#svchng").click(function () {

    var fname = $("#fname").val();
    var usname = $("#usname").val();
    var email = $("#email").val();
    var tel = $("#phoneNumber").val();
    var idl = $("#id").val();
    var ndl = "hello profile";

    if(fname == null || fname == '') {

      $("#msg").html('Please input your first name');

    } else {

    if(usname == null || usname == '') {

      $("#msg").html('Your username cannot be empty');

    } else {

    if(email == null || email == '') {

      $("#msg").html('Kindly input your email address');

    } else {

      $("#msg").html(
        '<img style="width: 100px; height: 100px" src="assets/img/loading.gif"> <br/> Loading... Please wait'
      );

      $.ajax({
        type: "post",
        url: "functions/init.php",
        data: {fname: fname, usname: usname, email: email, tel: tel, idl: idl, ndl: ndl},
        success: function (data) {
          $("#msg").html(data);
        },
      });
      
    }
    }
    }
  });

});