<?php
include("servl/init.php");

if(isset($_GET['ref'])) {


    $ref = clean(escape($_GET['ref']));

    user_details();
    patientbookingtype($ref);
    

    $type =  $booktype['category'];
    $email = $booktype['email'];
    $bkmsg = $booktype['msg'];
    $doctor = "Dr ".$t_users['fullname'];


    user_details_by_mail($email);
    $tel = $bk_users['tel'];
    $phone_number = '234' . substr_replace($tel, '', 0, 1);



    $activator = '';
    $subj = "Your Appointment Was Approved";

    if($type == 'Physical') {

        $sql = "UPDATE `book` SET `status` = 'Approved', `doctor_assigned` = '$doctor' WHERE `bkid` = '$ref'";
        $res = query($sql);


        //send email to notify the patient
        //mail_mailer($email, $activator, $subj, $msg);



        redirect("./appointment");

    } else {

        $sql = "UPDATE `book` SET `status` = 'Approved', `doctor_assigned` = '$doctor' WHERE `bkid` = '$ref'";
        $res = query($sql);


        //send email to notify the patient
        //mail_mailer($email, $activator, $subj, $msg);


        redirect("https://api.whatsapp.com/send?phone=$phone_number&text=$bkmsg");

    }

    


} else {

    redirect("./appointment");
}

?>