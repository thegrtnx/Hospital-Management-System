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



  //signin
  $("#lsub").click(function () {
    var username = $("#luname").val();
    var password = $("#lpword").val();

    if (username == "" || username == null) {
      $(toastr.error("Kindly insert your email"));
    } else {
      if (password == "" || password == null) {
        $(toastr.error("Your password is empty"));
      } else {
        $.ajax({
          type: "post",
          url: "functions/init.php",
          data: { username: username, password: password },
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
  });



  //book appountment with doctor
  $("#bkdoc").click(function () {
    var aptdate = $("#aptdte").val();
    var bkmsg = $("#bkmsg").val();

    if (aptdate == "" || aptdate == null) {
      $(toastr.error("Please pick a date for your appointment"));
    } else {
      if (bkmsg == "" || bkmsg == null) {
        $(toastr.error("State the reason for booking an appointment"));
      } else {
        $.ajax({
          type: "post",
          url: "functions/init.php",
          data: { aptdate: aptdate, bkmsg: bkmsg },
            beforeSend: function() {
                    $(toastr.clear());
                    $("#bkdoc").html("Submitting... Please wait");
                 },
          success: function (data) {
            $(toastr.success(data));
          },
        });
      }
    }
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