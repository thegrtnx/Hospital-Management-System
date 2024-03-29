$(document).ready(function () {

  //var pk = 'pk_live_7a2adba82cb1a1fc7bf752451c000e431d74bdc3';




  //signup
  $("#sub").click(function () {
    var fname = $("#fname").val();
    var email = $("#email").val();
    var catgy = $("#catgy").val();
    var pword = $("#pword").val();
    var cpword = $("#cpword").val();
    var tagid  = $("#tagid").val();
    

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
                  url: "servl/init.php",
                  data: {
                    fname: fname,
                    email: email,
                    pword: pword,
                    cpword: cpword,
                    catgy: catgy,
                    tagid: tagid,
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
          url: "servl/init.php",
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


    //book appountment with doctor catgory
    $("#bkdoccategory").change(function () {

      var categ = $("#bkdoccategory").val();
  
      if (categ == "Physical") {

        $("#bckdtt").show();

      } else {

        $("#bckdtt").hide();
        
      }
    });


  //book appountment with doctor
  $("#bkdoc").click(function () {

    var aptdat = $("#aptdte").val();
    var bkmsg = $("#bkmsg").val();
    var cay = $("#bkdoccategory").val();

    if (aptdat == "" || aptdat == null) {

      var aptdate = 0;
      
    } else {

      var aptdate =  aptdat;
    }

      if (bkmsg == "" || bkmsg == null) {
        $(toastr.error("State the reason for booking an appointment"));
      } else {
        $(toastr.info("Submitting... Please wait"));
        $.ajax({
          type: "post",
          url: "servl/init.php",
          data: { aptdate: aptdate, bkmsg: bkmsg, cay: cay},
            beforeSend: function() {
                    $(toastr.clear());
                    $("#bkdoc").html("Submitting... Please wait");
                 },
          success: function (data) {
            $(toastr.success(data));
          },
        });

    }
  });


  
  //rescudule appountment with doctor
  $("#newbck").click(function () {

    var aptdat = $("#aptdte").val();
    var reff = $("#reff").val();
    var docname = $("#docname").val();
    var dctel = $("#dctel").val();
    
  

      if (aptdat == "" || aptdat == null) {
        $(toastr.error("Kindly select a new date"));
      } else {
        $(toastr.info("Submitting... Please wait"));
        $.ajax({
          type: "post",
          url: "servl/init.php",
          data: { aptdat: aptdat, reff: reff, docname: docname, dctel: dctel},
            beforeSend: function() {
                    $(toastr.clear());
                    $("#newbck").html("Submitting... Please wait");
                 },
          success: function (data) {
            $(toastr.success(data));
          },
        });

    }
  });


  
  //save profile details changes
  $("#updtpro").click(function () {

    var tel = $("#phoneNumber").val();
    var add = $("#address").val();
    var state = $("#state").val();
    var genotype = $("#genotype").val();
    var blood = $("#blood").val();
    var gender = $("#gender").val();
    var lang = $("#lang").val();
    var tagid = $('#tagid').val();

    if(tel == null || tel == '') {

      $(toastr.error("Please input a phone number"));

    } else {

    if(add == null || add == '') {

      $(toastr.error("Please provide your address"));

    } else {

    if(state == null || state == '') {

      $(toastr.error("Please provide your state"));

    } else {

      if(genotype == null || genotype == '') {

        $(toastr.error("We need your genotype"));
  
      } else {


        if(blood == null || blood == '') {

          $(toastr.error("We need your blood group"));
    
        } else {

          if(gender == null || gender == '') {

            $(toastr.error("We need your gender"));
      
          } else {


            if(lang == null || lang == '') {

              $(toastr.error("What your language"));
        
            } else {

            $.ajax({
              type: "post",
              url: "servl/init.php",
              data: {tel: tel, add: add, state: state, genotype: genotype, blood: blood, gender: gender, lang: lang, tagid: tagid},
              beforeSend: function() {
                $(toastr.clear());
                $("#updtpro").html("Submitting... Please wait");
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
    }
    }
  });

});