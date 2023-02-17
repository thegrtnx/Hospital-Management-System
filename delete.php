<?php
include("servl/init.php");

if(isset($_GET['ref'])) {


    $ref = clean(escape($_GET['ref']));

    patientbookingtype($ref);
    

    $email = $booktype['email'];

    $activator = '';
    $subj = "Your Appointment Was Deleted";


        $sql = "DELETE FROM `book`  WHERE `bkid` = '$ref'";
        $res = query($sql);


        $msg = <<< DELIMITER

                        <!DOCTYPE html><html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><style>
                        *{box-sizing:border-box}body{margin:0;padding:0}a[x-apple-data-detectors]{color:inherit!important;text-decoration:inherit!important}#MessageViewBody a{color:inherit;text-decoration:none}p{line-height:inherit}.desktop_hide,.desktop_hide table{mso-hide:all;display:none;max-height:0;overflow:hidden}@media (max-width:620px){.row-content{width:100%!important}.mobile_hide{display:none}.stack .column{width:100%;display:block}.mobile_hide{min-height:0;max-height:0;max-width:0;overflow:hidden;font-size:0}.desktop_hide,.desktop_hide table{display:table!important;max-height:none!important}}
                        </style></head><body style="background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none"><table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff"><tbody><tr><td><table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tbody><tr><td><table 
                        class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:600px" width="600"><tbody><tr><td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-left:20px;padding-right:20px;vertical-align:top;padding-top:5px;padding-bottom:30px;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block block-1" 
                        width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:14.399999999999999px;color:#333;line-height:1.2;font-family:Helvetica Neue,Helvetica,Arial,sans-serif"><p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px">
                        <span style="font-size:30px;">Your appointment was deleted!</span></p></div></div></td></tr></table><table class="text_block block-2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word"><tr><td class="pad"><div style="font-family:sans-serif"><div class style="font-size:12px;mso-line-height-alt:21.6px;color:#333;line-height:1.8;font-family:Helvetica Neue,Helvetica,Arial,sans-serif"><p 
                        style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">Hi there,&nbsp;</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">Trust this mail finds you well.</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;"><br>Kindly note that your appointment has been deleted ;</span></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px">
                        <span style="font-size:17px;"><strong></strong></span></p><p style="margin:0;text-align:left;mso-line-height-alt:21.6px">&nbsp;</p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><strong><span style="font-size:17px;"> </span></strong></p><p style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;">if you feel this was an error, kindly create a new appointment.</span></p><p style="margin:0;text-align:left;mso-line-height-alt:21.6px">&nbsp;</p><p 
                        style="margin:0;text-align:left;mso-line-height-alt:30.6px"><span style="font-size:17px;"></span></p></div></div></td></tr></table><table class="button_block block-3" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0"><tr><td class="pad"><div class="alignment" align="center">
                        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://futahms.com.ng/" style="height:74px;width:231px;v-text-anchor:middle;" arcsize="5%" stroke="false" fillcolor="#000000"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px"><![endif]-->
                        <a href="https://futahms.com.ng/" target="_blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#000000;border-radius:3px;width:auto;border-top:0px solid transparent;font-weight:undefined;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 32px;"><strong>Login to you dashboard</strong></span><span dir="ltr" style="word-break: break-word; line-height: 32px;">
                        <br><strong></strong></span></span></a><!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!-- End --><div style="background-color:transparent;">
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


        redirect("./appointment");



} else {

    redirect("./appointment");
}

?>