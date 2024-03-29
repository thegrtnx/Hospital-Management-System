<?php

//phpmailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


                                        /*************helper functions***************/

function clean($string) {

    return htmlentities($string);
}

function redirect($location) {

    return header("Location: {$location}");
}

function set_message($message) {

    if(!empty($message)) {

        $_SESSION['message'] = $message;

        }else {

            $message = "";
        }
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function token_generator() {

    $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

    return $token; 
}

function otp() {

    $otp = $_SESSION['otp'] = mt_rand(0, 9999);

    return $otp; 
}

function validation_errors($error_message) {

    $error_message = <<<DELIMITER

    <div class="col-md-12 alert alert-danger alert-mg-b alert-success-style6 alert-st-bg3 alert-st-bg14">
        <button type="button" class="col-md-12 close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
        <p><strong>$error_message </strong></p>
    </div>

    DELIMITER;

    return $error_message;     

}


function validator($error_message) {

    $error_message = <<<DELIMITER
    <div style="background: #FFE9E6; color: #ff0000;" class="col-md-12 alert alert-danger alert-mg-b alert-success-style6 alert-st-bg3 alert-st-bg14">
        <button type="button" style="color: white;" class="col-md-12 close sucess-op" data-dismiss="modal" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                                        </button>
                    <p><strong>$error_message </strong></p>
                                </div>
    DELIMITER;

    return $error_message;     

}


                                                      /*************helper functions***************/

                                                     
                                                     
                                                      /****** GLOBAL Functions********/

//check if email exit
function email_exist($email) {

    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = query($sql);

    if(row_count($result) == 1) {

        return true;

    } else {

        return false;
    } 
}



//get specific user details
function user_details() {

    if(!isset($_SESSION['login'])) {

        redirect("./logout");

    } else {

        $data = $_SESSION['login'];

        //users details
        $sql = "SELECT * FROM users WHERE `email` = '$data'";
        $rsl = query($sql);

       
        //check if user details is valid
        if(row_count($rsl) == '') {

            redirect("./logout");
            
        } else {

        $GLOBALS['t_users'] = mysqli_fetch_array($rsl);
    }

    }
}


//get specific user details
function user_details_by_mail($email) {


        //users details
        $sql = "SELECT * FROM users WHERE `email` = '$email'";
        $rsl = query($sql);
    
        $GLOBALS['bk_users'] = mysqli_fetch_array($rsl);
    
}




//function for sending global default emails
function mail_mailer($email, $activator, $subj, $msg) {
  

    require 'autoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    
    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug  = SMTP::DEBUG_OFF;
    
    //Set the hostname of the mail server
    //$mail->Host = 'send.smtp.mailtrap.io';
    $mail->Host = 'mail.futahms.com.ng';
    
    //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
    //if your network does not support SMTP over IPv6,
    //though this may cause issues with TLS
    
    //Set the SMTP port number:
    // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
    // - 587 for SMTP+STARTTLS
    //$mail->Port = 465;
    
    $mail->Port = 465;
    
    //Set the encryption mechanism to use:
    // - SMTPS (implicit TLS on port 465) or
    // - STARTTLS (explicit TLS on port 587)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = 'ward@futahms.com.ng';
    
    //Password to use for SMTP authentication
    $mail->Password = 'pTa%!fFZ&T_k';
    //$mail->Password = 'gzoqmvzofoeddple';

    // For most clients expecting the Priority header:
    // 1 = High, 2 = Medium, 3 = Low
    $mail->Priority = 1;
    // MS Outlook custom header
    // May set to "Urgent" or "Highest" rather than "High"
    $mail->AddCustomHeader("X-MSMail-Priority: Urgent");
    // Not sure if Priority will also set the Importance header:
    $mail->AddCustomHeader("Importance: High");
    
    //Password to use for SMTP authentication
    //$mail->Password = 'pqoqdmrnufifmrbe';
    
    //Set who the message is to be sent from
    //Note that with gmail you can only use your account address (same as `Username`)
    //or predefined aliases that you have configured within your account.
    //Do not use user-submitted addresses in here
    $mail->setFrom('ward@futahms.com.ng', 'FUTA HMS');
    
    //Set an alternative reply-to address
    //This is a good place to put user-submitted addresses
    $mail->addReplyTo('ward@futahms.com.ng', 'FUTA HMS');
    
    //Set who the message is to be sent to
    $mail->addAddress($email);
    
    //Set the subject line
    $mail->Subject = $subj;
    
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($msg);
    
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
   
    //send the message, check for errors
    if ($mail->send()) {

        return true;


    } else {

        echo 'Mailer Error: ' . $mail->ErrorInfo;


        return false;
    }
}

       

//REGISTER USER
function register($fname, $email, $pword, $catgy, $tagid) {

    $fnam = escape($fname);
    $emai = escape($email);
    $tagd = escape($tagid);
    $pwor = md5($pword);

    $datereg = date("Y-m-d h:i:s");

    $_SESSION['usermail'] = $emai;
        
    $activator = md5(otp());
    
    $sql = "INSERT INTO users(`fullname`, `email`, `password`, `role`, `date_reg`, `activator`, `tagid`)";
    $sql.= " VALUES('$fnam', '$emai', '$pwor', '$catgy', '$datereg', '$activator', '$tagid')";
    $result = query($sql);

    //redirect to verify function
    $subj = "Activate Your Account";
    
    $msg = <<<DELIMITER

            <!DOCTYPE html><html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><style>
            *{box-sizing:border-box}body{margin:0;padding:0}a[x-apple-data-detectors]{color:inherit!important;text-decoration:inherit!important}#MessageViewBody a{color:inherit;text-decoration:none}p{line-height:inherit}.desktop_hide,.desktop_hide table{mso-hide:all;display:none;max-height:0;overflow:hidden}@media (max-width:620px){.social_block.desktop_hide .social-table{display:inline-block!important}.row-content{width:100%!important}.mobile_hide{display:none}.stack .column{width:100%;display:block}.mobile_hide{min-height:0;max-height:0;max-width:0;overflow:hidden;font-size:0}.desktop_hide,.desktop_hide table{display:table!important;max-height:none!important}}
            </style></head><body style="background-color:#f0efeb;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none"><table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
            style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff;color:#000;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" 
            style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-left:30px;padding-right:30px;vertical-align:top;padding-top:20px;padding-bottom:30px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" 
            style="padding-bottom:10px;padding-left:5px;padding-right:5px;padding-top:10px"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#4d4d4d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="font-size:28px;"><strong><span style="font-size:28px;">Activate your account</span></strong></span></p></div></div></td></tr>
            </table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-bottom:30px;padding-left:20px;padding-right:20px;padding-top:10px"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#4d4d4d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif"><p 
            style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:19.2px"><span style="font-size:16px;">Thank you for signing up on our platform.&nbsp;</span></p><p style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:14.399999999999999px">&nbsp;</p><p style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:19.2px"><span style="font-size:16px;">Kindly activate your account by clicking on the button below.</span></p></div></div></td></tr></table><table 
            class="button_block block-3" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad"><div class="alignment" align="center">
            <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://futahms.com.ng/activate?vff=$activator" style="height:38px;width:177px;v-text-anchor:middle;" arcsize="11%" stroke="false" fillcolor="#3AAEE0"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:14px"><![endif]-->
            <a href="https://futahms.com.ng/activate?vff=$activator" target="_blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#3AAEE0;border-radius:4px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:20px;padding-right:20px;font-size:14px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 28px;"><strong>Activate My Account</strong></span></span></a>
            <!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" 
            style="mso-table-lspace:0;mso-table-rspace:0;color:#333;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;padding-top:30px;padding-bottom:55px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="social_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td 
            class="pad"><div class="alignment" align="center"><table class="social-table" width="168px" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;display:inline-block"><tr><td style="padding:0 10px 0 0"><a href="https://www.facebook.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/facebook.png" width="32" height="32" alt="Facebook" title="Facebook" 
            style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="http://twitter.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/twitter.png" width="32" height="32" alt="Twitter" title="Twitter" style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="http://plus.google.com/" target="_blank"><img 
            src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/googleplus.png" width="32" height="32" alt="Google+" title="Google+" style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="https://instagram.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/instagram@2x.png" width="32" height="32" alt="Instagram" title="Instagram" 
            style="display:block;height:auto;border:0"></a></td></tr></table></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!-- End --><div style="background-color:transparent;">
                <div style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
                    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 500px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                        <!--[if (mso)|(IE)]><td align="center" width="500" style=" width:500px; padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                        <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                            <div style="background-color: transparent; width: 100% !important;">
                                <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                    <!--<![endif]-->
            
                                    <!--[if (!mso)&(!IE)]><!-->
                                </div><!--<![endif]-->
                            </div>
                        </div>
                        <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                    </div>
                </div>
            </div></body></html>
    
    DELIMITER;
    
    mail_mailer($email, $activator, $subj, $msg);

    echo 'Almost Complete...';
    echo '<script>window.location.href ="./activate?eml='.$email.'"</script>';

}  


//get booking details
function patientbookings() {

    $email = $_SESSION['login'];

    $sql = "SELECT * FROM book WHERE `email` = '$email'";
    $res = query($sql);
    
    if(row_count($res) >= 1) {

        return true;

    } else {

        return false;
    }
}



//get booking type
function patientbookingtype($ref) {

    $sql = "SELECT * FROM book WHERE `bkid` = '$ref'";
    $res = query($sql);
    
    if(row_count($res) == 1) {

        $GLOBALS['booktype'] = mysqli_fetch_array($res);

        return true;

    } else {

        return false;
    }
}





function rescheduler($ref, $doctor, $dctel, $aptdat) {
    
        user_details();
        patientbookingtype($ref);
        
    
        $type =  $GLOBALS['booktype']['category'];
        $email = $GLOBALS['booktype']['email'];
        $bkmsg = $GLOBALS['booktype']['msg'];
        $date  = date('l, F d, Y', strtotime($aptdat));
    
    
        user_details_by_mail($email);
        $tel = $GLOBALS['bk_users']['tel'];
        $phone_number = '234' . substr_replace($tel, '', 0, 1);
    
        $activator = '';
        $subj = "Your Appointment Was Rescheduled";
    

        $sql = "UPDATE `book` SET `status` = 'Rescheduled', `doctor_assigned` = '$doctor', `date` = '$date' WHERE `bkid` = '$ref'";
        $res = query($sql);


        $msg = <<< DELIMITER

                        <!DOCTYPE html><html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><style>
                        *{box-sizing:border-box}body{margin:0;padding:0}a[x-apple-data-detectors]{color:inherit!important;text-decoration:inherit!important}#MessageViewBody a{color:inherit;text-decoration:none}p{line-height:inherit}.desktop_hide,.desktop_hide table{mso-hide:all;display:none;max-height:0;overflow:hidden}@media (max-width:620px){.row-content{width:100%!important}.mobile_hide{display:none}.stack .column{width:100%;display:block}.mobile_hide{min-height:0;max-height:0;max-width:0;overflow:hidden;font-size:0}.desktop_hide,.desktop_hide table{display:table!important;max-height:none!important}}
                        </style></head><body style="background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none"><table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff"><tbody><tr><td><table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table 
                        class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-left:20px;padding-right:20px;vertical-align:top;padding-top:5px;padding-bottom:30px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" 
                        width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#333;line-height:1.2;font-family:Helvetica Neue,Helvetica,Arial,sans-serif"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">
                        <span style="font-size:30px;">Your appointment was rescheduled!</span></p></div></div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:21.6px;color:#333;line-height:1.8;font-family:Helvetica Neue,Helvetica,Arial,sans-serif"><p 
                        style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">Hi there,&nbsp;</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">Trust this mail finds you well.</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;"><br>Kindly note that your appointment has been rescheduled for;</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px">
                        <span style="font-size:17px;"><strong>$date</strong></span></p><p style="margin:0;text-align:left;mso-line-height-alt:21.6px">&nbsp;</p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><strong><span style="font-size:17px;">$doctor </span></strong></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">will attend to you.</span></p><p style="margin:0;text-align:left;mso-line-height-alt:21.6px">&nbsp;</p><p 
                        style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">Kindly log in to your verify the status of your appointment.</span></p></div></div></td></tr></table><table class="button_block block-3" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad"><div class="alignment" align="center">
                        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="tel:$dctel" style="height:74px;width:231px;v-text-anchor:middle;" arcsize="5%" stroke="false" fillcolor="#000000"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px"><![endif]-->
                        <a href="tel:$dctel" target="_blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#000000;border-radius:3px;width:auto;border-top:0px solid transparent;font-weight:undefined;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;"><strong>Have a call with</strong></span><span dir="ltr" style="word-break: break-word; line-height: 32px;">
                        <br><strong>$doctor</strong></span></span></a><!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!-- End --><div style="background-color:transparent;">
                            <div style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 500px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="500" style=" width:500px; padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                        
                        
                                        
                        
                        
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div><!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div></body></html>

        DELIMITER;


        //send email to notify the patient
        mail_mailer($email, $activator, $subj, $msg);


        echo '<script>window.location.href ="./appointment"</script>';
    
        
}


                                                    /****** END OF GLOBAL Functions********/






                                                    /********  VALIDATORS ******************/


//VALIDATE USER REGISTRATION
if(isset($_POST['fname']) && isset($_POST['catgy']) && isset($_POST['email']) && isset($_POST['pword']) && isset($_POST['cpword']) && isset($_POST['tagid'])) {

    $fname          = clean(escape($_POST['fname']));
    $catgy           = clean(escape($_POST['catgy']));
    $email          = clean(escape($_POST['email']));
    $pword          = clean(escape($_POST['pword']));
    $cpword         = clean(escape($_POST['cpword']));
    $tagid          = clean(escape($_POST['tagid']));
        
       
        if(email_exist($email)) {

            echo '<script>window.location.href ="./login"</script>';

        } else {

                register($fname, $email, $pword, $catgy, $tagid);
                
            }
    
}  


//SIGN IN USER
if(isset($_POST['username']) && isset($_POST['password'])) {

        $username        = clean(escape($_POST['username']));
        $password        = md5($_POST['password']);

        $sql = "SELECT * FROM `users` WHERE `email` = '$username' AND `password` = '$password'";
        $result = query($sql);
        if(row_count($result) == 1) {

            $row        = mysqli_fetch_array($result);


            $email      = $row['email'];
            $activate   = $row['activator'];
            $role       = $row['role'];
            

            if ($activate != 'activated') {

                $activator = md5(otp());

                //update activation link
                $ups = "UPDATE users SET `activator` = '$activator' WHERE `email` = '$email'";
                $ues = query($ups);

                //redirect to verify function
                $subj = "Activate Your Account";
    
                $msg = <<<DELIMITER

                            <!DOCTYPE html><html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><style>
                            *{box-sizing:border-box}body{margin:0;padding:0}a[x-apple-data-detectors]{color:inherit!important;text-decoration:inherit!important}#MessageViewBody a{color:inherit;text-decoration:none}p{line-height:inherit}.desktop_hide,.desktop_hide table{mso-hide:all;display:none;max-height:0;overflow:hidden}@media (max-width:620px){.social_block.desktop_hide .social-table{display:inline-block!important}.row-content{width:100%!important}.mobile_hide{display:none}.stack .column{width:100%;display:block}.mobile_hide{min-height:0;max-height:0;max-width:0;overflow:hidden;font-size:0}.desktop_hide,.desktop_hide table{display:table!important;max-height:none!important}}
                            </style></head><body style="background-color:#f0efeb;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none"><table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" 
                            style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff;color:#000;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" 
                            style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-left:30px;padding-right:30px;vertical-align:top;padding-top:20px;padding-bottom:30px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" 
                            style="padding-bottom:10px;padding-left:5px;padding-right:5px;padding-top:10px"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#4d4d4d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="font-size:28px;"><strong><span style="font-size:28px;">Activate your account</span></strong></span></p></div></div></td></tr>
                            </table><table class="text_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad" style="padding-bottom:30px;padding-left:20px;padding-right:20px;padding-top:10px"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#4d4d4d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif"><p 
                            style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:19.2px"><span style="font-size:16px;">Thank you for signing up on our platform.&nbsp;</span></p><p style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:14.399999999999999px">&nbsp;</p><p style="margin:0;font-size:16px;text-align:left;mso-line-height-alt:19.2px"><span style="font-size:16px;">Kindly activate your account by clicking on the button below.</span></p></div></div></td></tr></table><table 
                            class="button_block block-3" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad"><div class="alignment" align="center">
                            <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://futahms.com.ng/activate?vff=$activator" style="height:38px;width:177px;v-text-anchor:middle;" arcsize="11%" stroke="false" fillcolor="#3AAEE0"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:14px"><![endif]-->
                            <a href="https://futahms.com.ng/activate?vff=$activator" target="_blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#3AAEE0;border-radius:4px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:20px;padding-right:20px;font-size:14px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 28px;"><strong>Activate My Account</strong></span></span></a>
                            <!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0efeb"><tbody><tr><td><table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" 
                            style="mso-table-lspace:0;mso-table-rspace:0;color:#333;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;padding-top:30px;padding-bottom:55px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="social_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td 
                            class="pad"><div class="alignment" align="center"><table class="social-table" width="168px" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;display:inline-block"><tr><td style="padding:0 10px 0 0"><a href="https://www.facebook.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/facebook.png" width="32" height="32" alt="Facebook" title="Facebook" 
                            style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="http://twitter.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/twitter.png" width="32" height="32" alt="Twitter" title="Twitter" style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="http://plus.google.com/" target="_blank"><img 
                            src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/googleplus.png" width="32" height="32" alt="Google+" title="Google+" style="display:block;height:auto;border:0"></a></td><td style="padding:0 10px 0 0"><a href="https://instagram.com/" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/circle-gray/instagram@2x.png" width="32" height="32" alt="Instagram" title="Instagram" 
                            style="display:block;height:auto;border:0"></a></td></tr></table></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!-- End --><div style="background-color:transparent;">
                                <div style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
                                    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 500px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                        <!--[if (mso)|(IE)]><td align="center" width="500" style=" width:500px; padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                        <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                                            <div style="background-color: transparent; width: 100% !important;">
                                                <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                                    <!--<![endif]-->
                            
                                                    <!--[if (!mso)&(!IE)]><!-->
                                                </div><!--<![endif]-->
                                            </div>
                                        </div>
                                        <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                    </div>
                                </div>
                            </div></body></html>
        
                DELIMITER;

                mail_mailer($email, $activator, $subj, $msg);

                //open otp page
                echo 'Almost Complete...';
                echo '<script>window.location.href ="./activate?eml='.$email.'"</script>';

                
            }  else {

                $_SESSION['login'] = $email;

                echo 'Almost Complete...';
                echo '<script>window.location.href ="./"</script>';
                
        } 

    }  else {
        
        echo 'Wrong username or password.';
    }
}


//book an appointment with doctor
if(isset($_POST['aptdate']) && isset($_POST['bkmsg']) && isset($_POST['cay'])) {

    echo "haaa";

    $aptdte = clean(escape($_POST['aptdate']));
    $bkmsg   = clean(escape($_POST['bkmsg']));
    $cay   = clean(escape($_POST['cay']));

    if($aptdte == 0) {

        $aptdate = date("Y-m-d");

    } else {

        $aptdate = $aptdte;      

    }


    $bkid    = "hmsbook/".otp();
    $email   = $_SESSION['login'];

    //insert into database
    $ssl ="INSERT INTO book(`bkid`, `email`, `date`, `msg`, `status`, `category`, `doctor_assigned`)";
    $ssl.="VALUES('$bkid', '$email', '$aptdate', '$bkmsg', 'Pending Approval', '$cay', 'Pending')";
    $sel = query($ssl);

    //redirect
    echo "Almost complete... Please wait";
    echo '<script>window.location.href ="./appointment"</script>';

}




//update profile
if(isset($_POST['tel']) && isset($_POST['add']) && isset($_POST['state']) && isset($_POST['genotype']) && isset($_POST['blood']) && isset($_POST['gender']) && isset($_POST['lang']) && isset($_POST['tagid'])){

   $tel        = clean(escape($_POST['tel']));
   $add        = clean(escape($_POST['add']));
   $state      = clean(escape($_POST['state']));
   $geno       = clean(escape($_POST['genotype']));
   $blood      = clean(escape($_POST['blood']));
   $genders    = clean(escape($_POST['gender']));
   $lang       = clean(escape($_POST['lang']));
   $tagid      = clean(escape($_POST['tagid']));

    $email = $_SESSION['login'];


    $sql ="UPDATE users SET `tel` = '$tel', `address` = '$add', `state` = '$state', `genotype` = '$geno', `bloodgroup` = '$blood', `gender` = '$genders', `language` = '$lang', `tagid` = '$tagid' WHERE `email` = '$email'";
    $res = query($sql);

    echo "Almost complete...";
    echo '<script>window.location.href ="./profile"</script>';


}



if(isset($_POST['aptdat']) && isset($_POST['reff']) && isset($_POST['docname']) && isset($_POST['dctel'])) {

    $aptdat = clean(escape($_POST['aptdat']));
    $ref = clean(escape($_POST['reff']));
    $doctor = clean(escape($_POST['docname']));
    $dctel = clean(escape($_POST['dctel']));

    rescheduler($ref, $doctor, $dctel, $aptdat);

}



                                                /********END OF   VALIDATORS ******************/