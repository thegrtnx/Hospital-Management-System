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


//redirect to different roles on signup
function role_director($username, $role) {

                //redirect to user dashboard
                if($role == 'user' || $role == 'USER') {
                    
                    $_SESSION['login'] = $username;

                    //get ip addr
                    $ip = get_client_ip();

                    //check if user was a guest
                    $ssl = "SELECT * FROM guest WHERE `ip` = '$ip'";
                    $res = query($ssl);

                    if(row_count($res) == 1) {

                        $row = mysqli_fetch_array($res);
                        
                        $det = $row['det'];
                        
                        //if yes, redirect to the guest related page
                        echo '<script>window.location.href ="./bookdetails?book='.$det.'"</script>';
                        
                        //delete guest record from database
                        $dls = "DELETE FROM guest WHERE `ip` = '$ip'";
                        $des = query($dls);
                        
                    } else {


                    echo '<img style="width: 100px; height: 100px" src="assets/img/loading.gif">';    

                    echo '<script>window.location.href ="./"</script>'; 
                    
                    }

                
                } else {

                    //redirect to author dashbaord
                    if($role == 'author' || $role == 'AUTHOR') {

                        $_SESSION['login'] = $username;

                         //get ip addr
                        $ip = get_client_ip();

                        //check if user was a guest
                        $ssl = "SELECT * FROM guest WHERE `ip` = '$ip'";
                        $res = query($ssl);

                        if(row_count($res) == 1) {

                            $row = mysqli_fetch_array($res);
                            
                            $det = $row['det'];
                            
                            //if yes, redirect to the guest related page
                            echo '<script>window.location.href="author/./bookdetails?book='.$det.'"</script>';
                            
                            //delete guest record from database
                            $dls = "DELETE FROM guest WHERE `ip` = '$ip'";
                            $des = query($dls);
                            
                        } else {

                        echo '<img style="width: 100px; height: 100px" src="assets/img/loading.gif">';    

                        echo '<script>window.location.href ="author/./"</script>';  

                        }


                    } else {


                        //redirect to publisher dashboard
                        if($role == 'publisher' || $role == 'PUBLISHER') {

                        $_SESSION['login'] = $username;

                         //get ip addr
                         $ip = get_client_ip();

                         //check if user was a guest
                         $ssl = "SELECT * FROM guest WHERE `ip` = '$ip'";
                         $res = query($ssl);
 
                         if(row_count($res) == 1) {
 
                             $row = mysqli_fetch_array($res);
                             
                             $det = $row['det'];
                             
                             //if yes, redirect to the guest related page
                             echo '<script>window.location.href="publisher/./bookdetails?book='.$det.'"</script>';
                             
                             //delete guest record from database
                             $dls = "DELETE FROM guest WHERE `ip` = '$ip'";
                             $des = query($dls);
                             
                         } else {

                        echo '<img style="width: 100px; height: 100px" src="assets/img/loading.gif">';    

                        echo '<script>window.location.href ="publisher/./"</script>';  

                         } 


                        } else {

                            echo '<img style="width: 100px; height: 100px" src="assets/img/loading.gif">';    

                            echo '<script>window.location.href ="./signin"</script>';
                        }
                    }

                }


}



//get specific user details
function user_details() {

    if(!isset($_SESSION['login'])) {

        redirect("./logout");

    } else {

        $data = $_SESSION['login'];

        //users details
        $sql = "SELECT * FROM users WHERE `usname` = '$data' OR `email` = '$data'";
        $rsl = query($sql);

        //get admin details for authors
        $rem = "SELECT * FROM admin";
        $res = query($rem);

        $GLOBALS['t_admin'] = mysqli_fetch_array($res);

        //check if user details is valid
        if(row_count($rsl) == '') {

            redirect("./logout");
            
        } else {

        $GLOBALS['t_users'] = mysqli_fetch_array($rsl);

        //set passport for empty passport
        if($GLOBALS['t_users']['passport'] == null && $GLOBALS['t_users']['role'] == 'USER' || $GLOBALS['t_users']['role'] == 'user') {
            
            $GLOBALS['passport'] = 'assets/img/user.png';

        } else {

            if($GLOBALS['t_users']['passport'] == null && $GLOBALS['t_users']['role'] == 'author' || $GLOBALS['t_users']['role'] == 'AUTHOR' || $GLOBALS['t_users']['role'] == 'publisher' || $GLOBALS['t_users']['role'] == 'PUBLISHER') {
                
                $GLOBALS['passport'] = '../assets/img/user.png';
            } else {

                $GLOBALS['passport'] = '../assets/img/'.$GLOBALS['t_users']['passport'];
            }

        }
    }

    }
}



//function for sending global default emails
function mail_mailer($email, $activator, $subj, $msg) {

  
    $msg = <<<DELIMITER
     
    DELIMITER;
    

    require 'autoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    
    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //$mail->SMTPDebug  = SMTP::DEBUG_OFF;
    
    //Set the hostname of the mail server
    //$mail->Host = 'send.smtp.mailtrap.io';
    $mail->Host = 'mail.dotpedia.com.ng';
    
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
    $mail->Username = 'hi@dotpedia.com.ng';
    
    //Password to use for SMTP authentication
    $mail->Password = 'facdf2515000bccc8c5aab8ad41136c1';
    //$mail->Password = 'gzoqmvzofoeddple';

    // For most clients expecting the Priority header:
    // 1 = High, 2 = Medium, 3 = Low
    $mail->Priority = 1;
    // MS Outlook custom header
    // May set to "Urgent" or "Highest" rather than "High"
    $mail->AddCustomHeader("X-MSMail-Priority: High");
    // Not sure if Priority will also set the Importance header:
    $mail->AddCustomHeader("Importance: High");
    
    //Password to use for SMTP authentication
    //$mail->Password = 'pqoqdmrnufifmrbe';
    
    //Set who the message is to be sent from
    //Note that with gmail you can only use your account address (same as `Username`)
    //or predefined aliases that you have configured within your account.
    //Do not use user-submitted addresses in here
    $mail->setFrom('hi@dotpedia.com.ng', 'DotPedia');
    
    //Set an alternative reply-to address
    //This is a good place to put user-submitted addresses
    $mail->addReplyTo('hi@dotpedia.com.ng', 'DotPedia');
    
    //Set who the message is to be sent to
    $mail->addAddress($email);
    
    //Set the subject line
    $mail->Subject = 'Welcome to DotPedia';
    
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($msg);
    
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
   
    //send the message, check for errors
    if ($mail->send()) {

        return true;


    } else {

        echo 'Mailer Error: ' . $send->ErrorInfo;


        return false;
    }
}

       




//REGISTER USER
function register($fname, $email, $pword, $catgy) {

    $fnam = escape($fname);
    $emai = escape($email);
    $pwor = md5($pword);

    $datereg = date("Y-m-d h:i:s");

    $_SESSION['usermail'] = $emai;
        
    $activator = otp();
    
    $sql = "INSERT INTO users(`fullname`, `email`, `password`, `role`, `date_reg`, `status`, `active`, `lastseen`, `ref`, `wallet`)";
    $sql.= " VALUES('$fnam', '$emai', '$pwor', '$catgy', '$datereg', '$activator', '0', '$datereg', '$ref', '0')";
    $result = query($sql);

    //redirect to verify function
    $subj = "Activate Your Account";
    
    $msg = <<<DELIMITER

    <tr>
    <p style="color: black; font-weight: bold; margin-top: 24px !important;">👋 Welcome to Books In Vogue. </p>
    </tr>
    <tr>
    <p style="color: black; margin-top: 8px !important;">✨ You are one-click towards activating your account and becoming part of the Books In
    Vogue Tribe</p>
    </tr>
    <tr>
    <p style="color: black; margin-top: 8px !important;">⬇️ Kindly use the code below to activate your account for FREE!</p>
    </tr>
    <tr>
    <p style="color: black; margin-top: 8px !important;">🔒 Do not share this code outside Books In Vogue website or Mobile App</p>
    </tr>
    <tr>
    <div style="text-align: center !important; margin-top: 24px !important; margin-bottom: 8px !important; justify-content: center !important;">
    <button style="background-color: #696cff; color: #fff; font-size: x-large; border: none; padding: 0.4375rem 1.25rem; border-radius: 0.4rem;">$activator</button>
    </div>
    </tr>  
    <tr>
    <p style="color: black; margin-bottom: 32px !important;">💃 That's it! We can't wait to see you 🤭</p>
    </tr>
    
    DELIMITER;
    
    mail_mailer($email, $activator, $subj, $msg);

    //open otp page
    echo 'Loading... Please Wait!';
    echo'<script>otpVerify(); signupClose();</script>';
}  


                                                    /****** END OF GLOBAL Functions********/






                                                    /********  VALIDATORS ******************/


//VALIDATE USER REGISTRATION
if(isset($_POST['fname']) && isset($_POST['catgy']) && isset($_POST['email']) && isset($_POST['pword']) && isset($_POST['cpword'])) {

    $fname          = clean(escape($_POST['fname']));
    $caty           = clean(escape($_POST['catgy']));
    $email          = clean(escape($_POST['email']));
    $pword          = clean(escape($_POST['pword']));
    $cpword         = clean(escape($_POST['cpword']));
        
    if($caty == "I am a patient") {

        $catgy = 'Patient';

    } else {

    if($caty == "I am a Doctor") {

           $catgy = 'Doctor';
            
        } 
    }

        if(email_exist($email)) {

            echo '<script>window.location.href ="./signin"</script>';

        } else {

                register($fname, $email, $pword, $catgy);
                
            }

}  
  


//RESEND OTP
if(isset($_POST['otpp'])) {

    $otpp = clean(escape($_POST['otpp']));
    
    $email = $_SESSION['usermail'];
    
    $activator = otp(); 

    $sql = "UPDATE users SET `status` = '$activator', `verified` = 'No' WHERE `email` = '$email'";
    $res = query($sql);

    $subj = "NEW OTP REQUEST";
    
    $msg = <<<DELIMITER

                <tr>
                <p style="color: black; font-weight: bold; margin-top: 24px !important;">🔏 You requested for a new OTP Code </p>
                </tr>
                <tr>
                <p style="color: black; margin-top: 8px !important;">⬇️ Kindly use the code below to continue into your account</p>
                </tr>
                <tr>
                <p style="color: black; margin-top: 8px !important;">🔒  Do not share this code outside Books In Vogue website or Mobile App</p>
                </tr>
                

                    <tr>
                <div style="text-align: center !important; margin-top: 24px !important; margin-bottom: 8px !important; justify-content: center !important;">
                <button style="background-color: #696cff; color: #fff; font-size: x-large; border: none; padding: 0.4375rem 1.25rem; border-radius: 0.4rem;">$activator</button>
                </div>

                </tr>  

                <tr>
                <p style="color: black; margin-bottom: 32px !important;">⚡ If you didn't request for this mail, kindly ignore it.</p>
                </tr>

    DELIMITER;
    
    mail_mailer($email, $activator, $subj, $msg);
    echo "New OTP Code sent to your email";
}


//Activate OTP ACCOUNT
if(isset($_POST['votp'])) {

    $email = $_SESSION['usermail'];
    $veotp = clean(escape($_POST['votp']));


    //select the otp stored in the user database
    $ssl = "SELECT * from users WHERE `email` = '$email'";
    $res = query($ssl);

    if(row_count($res) == null) {
        
        echo "There was an error validating your OTP. <br/> Please try again later.";

    } else {

        $row = mysqli_fetch_array($res);

        $votp = $row['status'];

        if($veotp != $votp) {

            echo "Invalid OTP Code!";
            
        } else {

            //update database and auto-login
            $sql = "UPDATE users SET `status` = '2', `verified` = 'Yes' WHERE `email` = '$email'";
            $rsl = query($sql);

            $user = $row['usname'];

            //forgot password recovery page
            if(!isset($_SESSION['vnext'])) {

                $username = $user;
                
                $role = $row['role'];

                $subj = "You are Welcome";

                $msg = <<<DELIMITER

                            <tr>
                            <p style="color: black; font-weight: bold; margin-top: 24px !important;">🥳 Welcome to the Books In Vogue Tribe </p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">Hi there,</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">We are super excited to have you on Books In Vogue</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">Books In Vogue is a platform developed to help you read amazing books, upload your own book(s) or publish books for other authors.</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">We will continue to enhance the experience of our interfaces to ensure that you enjoy a seamless reading feel.</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">Got any issues, complaint or request? Kindly chat with us on our <a target="_blank" href="https://booksinvogue.com/contact">live chat support panel</a></p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">Do have a wonderful book experience</a></p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-bottom: 32px !important;">⚡ Best Regards</p>
                            </tr>

                DELIMITER;

                //notify user that passowrd has been changed
                notify_user($username, $email, $msg, $subj);

                //redirect to user dashboard according to user category
                role_director($username, $role);

                } else {
                    
                    $data = $_SESSION['vnext'];
                    echo '<script>'.$data.'</script>';
                }
        }
    }
}


//SIGN IN USER
if(isset($_POST['username']) && isset($_POST['password'])) {

        $username        = clean(escape($_POST['username']));
        $password        = md5($_POST['password']);

        $sql = "SELECT * FROM `users` WHERE `usname` = '$username' OR `email` = '$username' AND `password` = '$password'";
        $result = query($sql);
        if(row_count($result) == 1) {

            $row        = mysqli_fetch_array($result);

            $user       = $row['usname'];
            $email      = $row['email'];
            $activate   = $row['verified'];
            $role       = $row['role'];
            

            if ($activate == 'No') {

                $activator = otp();

                $_SESSION['usermail'] = $email;

                //update activation link
                $ups = "UPDATE users SET `status` = '$activator', `verified` = 'No' WHERE `usname` = '$username'";
                $ues = query($ups);

                //redirect to verify function
                $subj = "Activate Your Account";
    
                $msg = <<<DELIMITER

                            <tr>
                            <p style="color: black; font-weight: bold; margin-top: 24px !important;">👋 Welcome to Books In Vogue. </p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">✨ You are one-click towards activating your account and becoming part of the Books In
                            Vogue Tribe</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">⬇️ Kindly use the code below to activate your account for FREE!</p>
                            </tr>
                            <tr>
                            <p style="color: black; margin-top: 8px !important;">🔒 Do not share this code outside Books In Vogue website or Mobile App</p>
                            </tr>
                            
                            <tr>
                            <div style="text-align: center !important; margin-top: 24px !important; margin-bottom: 8px !important; justify-content: center !important;">
                            <button style="background-color: #696cff; color: #fff; font-size: x-large; border: none; padding: 0.4375rem 1.25rem; border-radius: 0.4rem;">$activator</button>
                            </div>

                            </tr> 
                                
                            <tr>
                            <p style="color: black; margin-bottom: 32px !important;">💃 That's it! We can't wait to see you 🤭</p>
                            </tr>
                
                DELIMITER;

                mail_mailer($email, $activator, $subj, $msg);

                //open otp page
                echo 'Loading... Please Wait!';
                echo '<script>otpVerify(); signupClose();</script>';

                
            }  else {

                role_director($username, $role);
        } 

    }  else {
        
        echo 'Wrong username or password.';
    }
}


//FORGOT PASSWORD
if(isset($_POST['fgeml'])) {
    
    $email  = clean(escape($_POST['fgeml']));

    $_SESSION['usermail'] = $email;

    if(!email_exist($email)) {

        echo "Sorry! This email doesn't have an account";
        
    } else {

    $activator = otp();

    $ssl = "UPDATE users SET `status` = '$activator', `verified` = 'No' WHERE `email` = '$email'";
    $rsl = query($ssl);

    //redirect to verify function
    $subj = "RESET YOUR PASSWORD";
    $msg = <<<DELIMITER

            <tr>
            <p style="color: black; font-weight: bold; margin-top: 24px !important;">😎 Let's get you back into your account </p>
            </tr>
            <tr>
            <p style="color: black; margin-top: 8px !important;">⬇️ Kindly use the code below to continue into your account</p>
            </tr>
            <tr>
            <p style="color: black; margin-top: 8px !important;">🔒  Do not share this code outside Books In Vogue website or Mobile App</p>
            </tr>
           
            
            <tr>
            <div style="text-align: center !important; margin-top: 24px !important; margin-bottom: 8px !important; justify-content: center !important;">
            <button style="background-color: #696cff; color: #fff; font-size: x-large; border: none; padding: 0.4375rem 1.25rem; border-radius: 0.4rem;">$activator</button>
           </div>

            </tr> 

            <tr>
            <p style="color: black; margin-bottom: 32px !important;">⚡ If you didn't request for this mail, kindly ignore it.</p>
            </tr>

    DELIMITER;

    mail_mailer($email, $activator, $subj, $msg);

    //open otp page
    echo 'Loading... Please Wait!';
    $_SESSION['vnext'] = "updatePword();";
    echo '<script>otpVerify(); signupClose();</script>';

    }
}


//RESET PASSWORD
if(isset($_POST['fgpword']) && isset($_POST['fgcpword'])) {

    $fgpword = md5($_POST['fgpword']);
    $eml = $_SESSION['usermail'];

    $sql = "UPDATE users SET `password` = '$fgpword', `status` = '1', `verified` = 'Yes' WHERE `email` = '$eml'";
    $rsl = query($sql);
    
    //get username and redirect to dashboard
    $ssl = "SELECT * FROM users WHERE `email` =  '$eml'";
    $rsl = query($ssl);
    
    if(row_count($rsl) == '') {
        
        echo 'Loading... Please Wait';
        echo '<script>window.location.href ="./signin"</script>';
        
    } else {

        $row  = mysqli_fetch_array($rsl);
        $username = $row['usname']; 
        $role = $row['role'];
        $email = $eml;
        $subj = "Your password was changed";

        $msg = <<<DELIMITER

                    <tr>
                    <p style="color: black; font-weight: bold; margin-top: 24px !important;">🔏 Your password has been updated </p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Hi there,</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Your account password was just changed and has been updated.</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Ensure you use strong passwords and avoid sharing your details with any person, website or app aside Books In Vogue websites and mobile app</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">If you didn't perform this action, kindly reply to this mail so we can help get back your account.</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Got any issues, complaint or request? Kindly chat with us on our <a target="_blank" href="https://booksinvogue.com/contact">live chat support panel</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Do have a wonderful book experience</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-bottom: 32px !important;">⚡ Best Regards</p>
                    </tr>
    
        DELIMITER;
    
        //notify user that passowrd has been changed
        notify_user($username, $email, $msg, $subj);

        //redirect to user dashboard according to user category
        role_director($username, $role);
        
    }
}


//book details
if(isset($_POST['dataid'])) {

    $bookid = clean(escape($_POST['dataid']));
    

    //get book details
    $sql = "SELECT * FROM books WHERE `books_id` = '$bookid'";
    $res = query($sql);
    
    if(row_count($res) == 1) {

        $row = mysqli_fetch_array($res);

        $booktitle = $row['book_title'];
        $bookdescription = $row['sub_title'];
        $author = $row['author'];
        $language = $row['language'];
        $category = "- &nbsp;".$row['category_1']."<br/> - &nbsp;".$row['category_2'];
        $price = "₦".number_format($row['selling_price']);
        $sold = $row['sold'];

        $image = "../https://dashboard.booksinvogue.com/assets/bookscover/".$row['book_cover'];

        if(file_exists($image)){

            $imager = "https://dashboard.booksinvogue.com/assets/bookscover/".$row['book_cover'];
            
        } else {

            $imager = "https://dashboard.booksinvogue.com/assets/img/cover.jpg";
        }


        /*if($sold == null) {

            $sold = "0 copies sold";

        } else {

            if($sold == 1) {

                $sold = "1 copy sold";
            } else {

                $sold = number_format($row['sold'])." copies sold";

            }
        }*/


        $try = <<<DELIMITER

        <button type="button" class="mx-3 mt-1 btn-sm btn-outline-primary d-grid" data-bs-dismiss="offcanvas">
        X
        </button>
        
        <div class="offcanvas-header offcanvas-image justify-content-center align-items-center">
            <img style="width: 200px; height: 200px;" src="$imager" alt="$booktitle" class="img-fluid">
        </div>

        <div class="offcanvas-body my-auto mx-0 flex-grow-0">

            <div class="card">
                <div class="table-responsive text-wrap">
                    <table class="table">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Title</strong>
                                </td>
                                <td>$booktitle</td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>About</strong>
                                </td>
                                <td>$bookdescription</td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Author</strong>
                                </td>
                                <td>$author</td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Language</strong>
                                </td>
                                <td>$language</td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Category</strong>
                                </td>
                                <td>$category</td>
                            </tr>

                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Price</strong>
                                </td>
                                <td>$price</td>
                            </tr>

                            <!---<tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                    <strong>Sold</strong>
                                </td>
                                <td>$sold</td>
                            </tr>-->


                        </tbody>
                    </table>
                </div>
            </div>
            
                <div class="mt-3 col-lg-12 text-center justify-content-center align-item-center">

                        <div class="row text-center justify-content-center align-item-center">

                            <span class="mx-2 badge bg-label-primary col-2 p-1"><i class="bx bx-star"></i></a>
                            </span>

                            <button type="button" class="btn btn-primary col-6 d-grid">Buy this book</button>

                            <span class="mx-2 badge bg-label-primary col-2 p-1"><i class="bx bx-share-alt"></i></a>
                            </span>
                        
                        </div>
                </div>

        </div>
        
        DELIMITER;

        echo $try;

        } else {

        echo "This book is no longer available.";
        }
}



                                                /********END OF   VALIDATORS ******************/



                                                /****** FUNCTIONS AFTER VALDATIONS */
                                                                  


//make payment for book
if(isset($_POST['amt']) && isset($_POST['bkid']) && isset($_POST['authoremail']) && isset($_POST['bkprice']) && isset($_POST['rylty'])) {

    $amter      = $_POST['amt'] - 0;
    $athmail    = trim($_POST['authoremail']);
    $bkprice    = trim($_POST['bkprice']);
    $rylty      = trim($_POST['rylty']);
    $bkid       = $_POST['bkid'] - 0;
    $roya       = "You just made a royalty earning of ₦".number_format($rylty);


    //check if user has eneough money in wallet
    user_details();


    if($t_users['wallet'] == '' || $t_users['wallet'] == null || $t_users['wallet'] == 0) {

        $t_users['wallet'] = 0;
    }


    if($t_users['wallet'] >= $amter) {

        $tref = "bivpay".rand(0, 999);
        $bbid = "bbid".rand(0, 999);
        $date = date("Y-m-d h:i:sa");
        $data = $_SESSION['login'];
        $note = "Your wallet was debited with ₦".number_format($amter);


        //get new user wallet balance
        $newbal = $t_users['wallet'] - $amter;
        
        //insert into transaction history
        $tsql="INSERT INTO t_his(`t_ref`, `amt`, `datepaid`, `username`, `sn`, `status`, `paynote`)";
        $tsql.="VALUES('$tref', '$amter', '$date', '$data', '1', 'debit', '$note')";
        $tes = query($tsql);


        //notify user of the payment made
        $msg = <<<DELIMITER

                    <tr>
                    <p style="color: black; font-weight: bold; margin-top: 24px !important;">Your Wallet was just debited! 💵 </p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Hi there,</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">$note</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Got any issues, complaint or request? Kindly chat with us on our <a target="_blank" href="https://booksinvogue.com/contact">live chat support panel</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Keep having a wonderful book experience</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-bottom: 32px !important;">⚡ Best Regards</p>
                    </tr>

        DELIMITER;



        //notify author of the payment made
        $aumsg = <<<DELIMITER

                    <tr>
                    <p style="color: black; font-weight: bold; margin-top: 24px !important;">You just sold a book! 😍🤩</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Hi there,</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">$roya</p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Royalty will be paid into your account within 24hours</p>
                    </tr>
                    <p style="color: black; margin-top: 8px !important;">Kindly login to your account to review your royalty and sale.</p>
                    </tr>
                    <p style="color: black; margin-top: 8px !important;">Got any issues, complaint or request? Kindly chat with us on our <a target="_blank" href="https://booksinvogue.com/contact">live chat support panel</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-top: 8px !important;">Keep having a wonderful book experience</a></p>
                    </tr>
                    <tr>
                    <p style="color: black; margin-bottom: 32px !important;">⚡ Best Regards</p>
                    </tr>

        DELIMITER;


        //update wallet balance
        $upsl   = "UPDATE users SET `wallet` = '$newbal' WHERE `usname` = '$data'";
        $uel    = query($upsl);


        $subj   = "Debit Alert";
        $ausubj = "Credit Alert";

        $email      = $t_users['email'];
        $auemail    = $athmail;

        $username = $data;

        
        notify_user($username, $email, $msg, $subj);



        //notify notify_author
        notify_author($auemail, $aumsg, $ausubj);



        //add to bookshelf
        $bskl="INSERT INTO boughtbook(`id`, `bbid`, `bookid`, `userid`, `tranid`, `reading`, `authormail`, `price`, `royalty`)";
        $bskl.="VALUES('1', '$bbid', '$bkid', '$data', '$tref', 'Yes', '$athmail', '$bkprice', '$rylty')";
        $rkl = query($bskl);


        //check if book is in wishlist and delete from wishlist
        $whsl = "SELECT * FROM boughtbook WHERE `userid` = '$data' AND `reading` = 'wishlist' AND `bookid` = '$bkid'";
        $whls = query($whsl);



        if(row_count($whls) == null || row_count($whls) == '') {

            //do nothing
    

        } else {


            //if a matching record is found, delete the matching record
            $wdl = "DELETE FROM boughtbook WHERE `userid` = '$data' AND `reading` = 'wishlist' AND `bookid` = '$bkid'";
            $wrl = query($wdl);


        }


        $profit = $bkprice - $rylty;


        if($bkprice == 0) {

            //do nothing

        } else {

        
            //credit author wallet
            creditauthor($auemail, $rylty, $profit);

        }

        


        //redirect to bookshelf
        $_SESSION['bookmsg'] = "Your Wallet has been funded successfully";

        
        echo 'Loading... Please Wait';
        //echo '<script>window.location.href ="./bookshelf"</script>';

    } else {

        $namers = $t_users['fullname'];
        $enamer = $t_users['email'];
        $erefff = md5(rand(0, 999));

        $_SESSION['bookboughtid'] = $_POST['bkid'];
        $_SESSION['authmail'] = trim($_POST['authoremail']);
        $_SESSION['rylt'] = trim($_POST['rylty']);

        if(($t_users['role'] == 'author') || ($t_users['role'] == 'AUTHOR')) {

            $abcds = <<<DELIMITER

            <form id="paymentForm">
                <div class="mb-3">
                  You do not have sufficient funds in your wallet.
                </div>
                <input type="email" id="email-address" value="$enamer" hidden/>
                <input type="tel" id="amount" value="$bkprice" hidden/>
                <input type="text" id="bookid" value="$bkid" hidden />
                <button type="button" id="hey" class="btn btn-primary">Click to pay for this book</button>
              </form>
              <script src="https://js.paystack.co/v1/inline.js"></script> 
              <script src="../author/ajax.js"></script>
    
            DELIMITER;
    
            echo $abcds;
            
        }elseif(($t_users['role'] == 'publisher') || ($t_users['role'] == 'PUBLISHER')) {

                $rurl = 'http://localhost/biv/dashboard/users/publisher/paybook';
                
            } else {

    
                $abcds = <<<DELIMITER

                <form id="paymentForm">
                    <div class="mb-3">
                      You do not have sufficient funds in your wallet.
                    </div>
                    <input type="email" id="email-address" value="$enamer" hidden/>
                    <input type="tel" id="amount" value="$bkprice" hidden/>
                    <input type="text" id="bookid" value="$bkid" hidden />
                    <button type="button" id="hey" class="btn btn-primary">Click to pay for this book</button>
                  </form>
                  <script src="https://js.paystack.co/v1/inline.js"></script> 
                  <script src="ajax.js"></script>
        
                  
        
                DELIMITER;
        
                echo $abcds;

            }
            

    }
    
}



//get account name
if(isset($_POST['bank']) && isset($_POST['acctn']) && isset($_POST['trd'])) {

    $bank  = clean(escape($_POST['bank']));
    $acctn = clean(escape($_POST['acctn']));


    //get bank code first
    $banks = array(
        array('id' => '1','name' => 'Access Bank','code'=>'044'),
        array('id' => '2','name' => 'Citibank','code'=>'023'),
        array('id' => '3','name' => 'Diamond Bank','code'=>'063'),
        array('id' => '4','name' => 'Dynamic Standard Bank','code'=>''),
        array('id' => '5','name' => 'Ecobank Nigeria','code'=>'050'),
        array('id' => '6','name' => 'Fidelity Bank Nigeria','code'=>'070'),
        array('id' => '7','name' => 'First Bank of Nigeria','code'=>'011'),
        array('id' => '8','name' => 'First City Monument Bank','code'=>'214'),
        array('id' => '9','name' => 'Guaranty Trust Bank','code'=>'058'),
        array('id' => '10','name' => 'Heritage Bank Plc','code'=>'030'),
        array('id' => '11','name' => 'Jaiz Bank','code'=>'301'),
        array('id' => '12','name' => 'Keystone Bank Limited','code'=>'082'),
        array('id' => '13','name' => 'Providus Bank Plc','code'=>'101'),
        array('id' => '14','name' => 'Polaris Bank','code'=>'076'),
        array('id' => '15','name' => 'Stanbic IBTC Bank Nigeria Limited','code'=>'221'),
        array('id' => '16','name' => 'Standard Chartered Bank','code'=>'068'),
        array('id' => '17','name' => 'Sterling Bank','code'=>'232'),
        array('id' => '18','name' => 'Suntrust Bank Nigeria Limited','code'=>'100'),
        array('id' => '19','name' => 'Union Bank of Nigeria','code'=>'032'),
        array('id' => '20','name' => 'United Bank for Africa','code'=>'033'),
        array('id' => '21','name' => 'Unity Bank Plc','code'=>'215'),
        array('id' => '22','name' => 'Wema Bank','code'=>'035'),
        array('id' => '23','name' => 'Zenith Bank','code'=>'057'),
        array('id' => '24','name' => 'HighStreet MFB bank','code'=>'090175'),
        array('id' => '25','name' => 'TCF MFB','code' => '90115'),
      array(
          'id' => 132,
          'code' => '560',
          'name' => 'Page MFBank'
      ),
      array(
          'id' => 133,
          'code' => '304',
          'name' => 'Stanbic Mobile Money'
      ),
      array(
          'id' => 134,
          'code' => '308',
          'name' => 'FortisMobile'
      ),
      array(
          'id' => 135,
          'code' => '328',
          'name' => 'TagPay'
      ),
      array(
          'id' => 136,
          'code' => '309',
          'name' => 'FBNMobile'
      ),
      array(
          'id' => 137,
          'code' => '011',
          'name' => 'First Bank of Nigeria'
      ),
      array(
          'id' => 138,
          'code' => '326',
          'name' => 'Sterling Mobile'
      ),
      array(
          'id' => 139,
          'code' => '990',
          'name' => 'Omoluabi Mortgage Bank'
      ),
      array(
          'id' => 140,
          'code' => '311',
          'name' => 'ReadyCash (Parkway)'
      ),
      array(
          'id' => 143,
          'code' => '306',
          'name' => 'eTranzact'
      ),
      array(
          'id' => 145,
          'code' => '023',
          'name' => 'CitiBank'
      ),
      array(
          'id' => 147,
          'code' => '323',
          'name' => 'Access Money'
      ),
      array(
          'id' => 148,
          'code' => '302',
          'name' => 'Eartholeum'
      ),
      array(
          'id' => 149,
          'code' => '324',
          'name' => 'Hedonmark'
      ),
      array(
          'id' => 150,
          'code' => '325',
          'name' => 'MoneyBox'
      ),
      array(
          'id' => 151,
          'code' => '301',
          'name' => 'JAIZ Bank'
      ),
        array(
          'id' => 153,
          'code' => '307',
          'name' => 'EcoMobile'
      ),
      array(
          'id' => 154,
          'code' => '318',
          'name' => 'Fidelity Mobile'
      ),
      array(
          'id' => 155,
          'code' => '319',
          'name' => 'TeasyMobile'
      ),
      array(
          'id' => 156,
          'code' => '999',
          'name' => 'NIP Virtual Bank'
      ),
      array(
          'id' => 157,
          'code' => '320',
          'name' => 'VTNetworks'
      ),
        array(
          'id' => 159,
          'code' => '501',
          'name' => 'Fortis Microfinance Bank'
      ),
      array(
          'id' => 160,
          'code' => '329',
          'name' => 'PayAttitude Online'
      ),
      array(
          'id' => 161,
          'code' => '322',
          'name' => 'ZenithMobile'
      ),
      array(
          'id' => 162,
          'code' => '303',
          'name' => 'ChamsMobile'
      ),
      array(
          'id' => 163,
          'code' => '403',
          'name' => 'SafeTrust Mortgage Bank'
      ),
      array(
          'id' => 164,
          'code' => '551',
          'name' => 'Covenant Microfinance Bank'
      ),
      array(
          'id' => 165,
          'code' => '415',
          'name' => 'Imperial Homes Mortgage Bank'
      ),
      array(
          'id' => 166,
          'code' => '552',
          'name' => 'NPF MicroFinance Bank'
      ),
      array(
          'id' => 167,
          'code' => '526',
          'name' => 'Parralex'
      ),
      array(
          'id' => 169,
          'code' => '084',
          'name' => 'Enterprise Bank'
      ),
        array(
          'id' => 187,
          'code' => '314',
          'name' => 'FET'
      ),
      array(
          'id' => 188,
          'code' => '523',
          'name' => 'Trustbond'
      ),
      array(
          'id' => 189,
          'code' => '315',
          'name' => 'GTMobile'
      ),
        array(
          'id' => 182,
          'code' => '327',
          'name' => 'Pagatech'
      ),
      array(
          'id' => 183,
          'code' => '559',
          'name' => 'Coronation Merchant Bank'
      ),
      array(
          'id' => 184,
          'code' => '601',
          'name' => 'FSDH'
      ),
      array(
          'id' => 185,
          'code' => '313',
          'name' => 'Mkudi'
      ),
       array(
          'id' => 171,
          'code' => '305',
          'name' => 'Paycom'
      ),
      array(
          'id' => 172,
          'code' => '100',
          'name' => 'SunTrust Bank'
      ),
      array(
          'id' => 173,
          'code' => '317',
          'name' => 'Cellulant'
      ),
      array(
          'id' => 174,
          'code' => '401',
          'name' => 'ASO Savings and & Loans'
      ),
      array(
          'id' => 176,
          'code' => '402',
          'name' => 'Jubilee Life Mortgage Bank'
      ),
    );

    $row = 0; 
    
    while($row < 68) {
        
        if($banks[$row]['name'] == $bank){
    
        $bankcode = $banks[$row]['code'];
        }
        
        $row++;
    }
    
    //echo $bank;

    $request = [

        'account_number' => $acctn,
        'account_bank' => $bankcode
    ];
    
    $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.flutterwave.com/v3/accounts/resolve',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($request),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer FLWSECK-df927bcfddfc9ac72297cee178a62415-X',
            'Content-Type: application/json'
        ),
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
        // there was an error contacting the rave API
        die('Error Retrieving Your Account Name');
        }
        
        curl_close($curl);

        
        $res = json_decode($response);

        if($res->status == "success") {
        echo $res->data->account_name;
        } else {

            echo "Error Retrieving Your Account Name";
        }
    
}


//save acct details
if(isset($_POST['bank']) && isset($_POST['acctn']) && isset($_POST['actnm']) && isset($_POST['bio']) && isset($_POST['fb']) && isset($_POST['twt']) && isset($_POST['ig']) && isset($_POST['tel']) && isset($_POST['wapn']) || isset($_POST['publsh'])){

    $bank  = clean(escape($_POST['bank']));
    $acctn = clean(escape($_POST['acctn']));
    $actnm = clean(escape($_POST['actnm']));
    $bio   = clean(escape($_POST['bio']));
    $fb    = clean(escape($_POST['fb']));
    $ig    = clean(escape($_POST['ig']));
    $twt   = clean(escape($_POST['twt']));
    $wapn  = clean(escape($_POST['wapn']));
    $tlne  = clean(escape($_POST['tel']));
    $user  = $_SESSION['login'];

    if(isset($_POST['publsh'])) {

        $publsh = clean(escape($_POST['publsh']));

    } else {

        $publsh = '';
    }

    //update user acount
    $sql = "UPDATE users SET `act name` = '$actnm', `act no` = '$acctn', `bnk nme` = '$bank', `bio` = '$bio', `facebook` = '$fb', `twitter` = '$twt', `instagram` = '$ig', `whatsapp` = '$wapn', `agncy` = '$publsh', `telephone` = '$tlne' WHERE `usname` = '$user' OR `email` = '$user'";
    $res = query($sql);
    
    //refresh index page
    echo 'Loading... Please Wait';
    echo '<script>window.location.href ="./"</script>';
}


//uplaod book and softcopies
if(isset($_POST['booktitle']) && isset($_POST['bookdescp']) && isset($_POST['series']) && isset($_POST['author']) && isset($_POST['otherauthor']) && isset($_POST['copyright']) && isset($_POST['category']) && isset($_POST['isbn']) && isset($_POST['price']) && isset($_POST['authprofit']) && isset($_POST['bivprofit']) && isset($_POST['lang']) || isset($_POST['dft']) || isset($_POST['bookdtta']) || isset($_POST['imgnxtxt'])) {

    $booktitle = clean(escape($_POST['booktitle']));
    $bookdescp = clean(escape($_POST['bookdescp']));
    $series = clean(escape($_POST['series']));
    $author = clean(escape($_POST['author']));
    $otherauthor = clean(escape($_POST['otherauthor']));
    $copyright = clean(escape($_POST['copyright']));
    $category = clean(escape($_POST['category']));
    $isbn = clean(escape($_POST['isbn']));
    $bivprofit = clean(escape($_POST['bivprofit']));
    $lang = clean(escape($_POST['lang']));
    $date = date("F d, Y");

    $ppr = clean(escape($_POST['price']));


    //free books script
    if($ppr == 'null' || $ppr == '' || $ppr == 0) {
        
        $Date = date('F d, Y');

        $duration = date('F d, Y', strtotime($Date. ' + 5 days'));

        $price = 0;
        $authprofit = 0;

    } else {

        $duration = 0;

        $price = clean(escape($_POST['price']));
        $authprofit = clean(escape($_POST['authprofit']));
    }    


    user_details();

    $email = $t_users['email'];


        //save edited book to draft
        if(isset($_POST['dft']) && isset($_POST['dft']) != null && isset($_POST['dft']) != '' && isset($_POST['dft']) == 'editdraft' && isset($_POST['bookdtta']) && isset($_POST['bookdtta']) != null && isset($_POST['bookdtta']) != '') {

            $bookdtta = clean(escape($_POST['bookdtta']));

            //check if book has been free in this year book
            if(freebook_check($booktitle) && $price = 0) {

                echo "This book has been uploaded as a free book earlier this year. Kindly wait till next year, to re-upload this book as a free book";

            } else {
    
            //update the uploaded book in the db
            $sql = "UPDATE books SET `language` = '$lang', `book_title` = '$booktitle', `series_volume` = '$series', `author` = '$author', `other_author` = '$otherauthor', `copyright` = '$copyright', `category_1` = '$category', `isbn` = '$isbn', `selling_price` = '$price', `royalty_price` = '$authprofit', `description` = '$bookdescp', `book_status` = 'draft', `duration` = '$duration' WHERE `books_id` = '$bookdtta'";
            $res = query($sql);

            echo 'Loading... Please Wait';
            echo '<script>window.location.href ="./drafts"</script>';

            }

        } else {

                
            //save the edited book and move to file upload if neccessary
            if(isset($_POST['bookdtta']) && isset($_POST['bookdtta']) != null && isset($_POST['bookdtta']) != '' && isset($_POST['imgnxtxt']) && isset($_POST['imgnxtxt']) == 'image are choosy') {

                $bookdtta = clean(escape($_POST['bookdtta']));

                //check if book has been free in this year book
                if(freebook_check($booktitle) && $price == '0') {

                    echo "This book has been uploaded as a free book earlier this year. Kindly wait till next year, to re-upload this book as a free book";

                } else {
                
                //update the uploaded book in the db
                $sql = "UPDATE books SET `language` = '$lang', `book_title` = '$booktitle', `book_status` = 'Show', `series_volume` = '$series', `author` = '$author', `other_author` = '$otherauthor', `copyright` = '$copyright', `category_1` = '$category', `isbn` = '$isbn', `selling_price` = '$price', `royalty_price` = '$authprofit', `description` = '$bookdescp', `duration` = '$duration' WHERE `books_id` = '$bookdtta'";
                $res = query($sql);

                echo 'Loading... Please Wait';

                //create session to store current book details
                $_SESSION['eddbookupl'] = str_replace(' ', '-', $booktitle);

                $_SESSION['eddbooknew'] = str_replace(' ', '-', $booktitle);

                $_SESSION['edbkuplsuccess'] = str_replace(' ', '-', $booktitle);

                echo '<script>book();</script>';

                $post_url   = str_replace(' ', '-', $booktitle);

                }
                
            } else {

            if(book_exist($booktitle)) {

                echo "This book has been published previously.";
                
            } else {
            
                
        //insert into book db
        $sql = "INSERT INTO books(`email_address`, `language`, `book_title`, `series_volume`, `author`, `other_author`, `copyright`, `category_1`, `isbn`, `selling_price`, `royalty_price`, `description`, `book_status`, `date_posted`, `duration`)";
        $sql.="VALUES('$email', '$lang', '$booktitle', '$series', '$author', '$otherauthor', '$copyright', '$category', '$isbn', '$price', '$authprofit', '$bookdescp', 'draft', '$date', '$duration')";
        $res = query($sql);


        //if save to draft button is used, redirect to draft page
        if(isset($_POST['dft']) && isset($_POST['dft']) == 'draft' && isset($_POST['dft']) != null && isset($_POST['dft']) != '') {

            echo 'Loading... Please Wait';
            echo '<script>window.location.href ="./drafts"</script>';
            
        } else {

        //create session to store current book details
        $_SESSION['bookupl'] = str_replace(' ', '-', $booktitle);

        $_SESSION['booknew'] = str_replace(' ', '-', $booktitle);

        echo '<script>book();</script>';

        echo $post_url   = str_replace(' ', '-', $booktitle);
        }
    }
    }
    }
}


//publush book with book image and book cover
if (!empty($_FILES["covfile"]["name"])) {
    
    $target_dir2 = "../assets/bookscover/";

    $target_file2 =  basename($_FILES["covfile"]["name"]);
  

    $targetFilePath2 = $target_dir2 . $target_file2;

    $uploadOk = 1;

    $imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);

    
    // Allow certain file formats
    if($imageFileType2 != 'jpg' && $imageFileType2 != 'jpeg' && $imageFileType2 != 'png') {
        echo "Sorry, only .pdf, .jpg, .jpeg, .png files are allowed.";
        $uploadOk = 0;
    } else {
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
       echo "Sorry, your book was not uploaded.";
    // if everything is ok, try to upload file
    } else {
       
       move_uploaded_file($_FILES["covfile"]["tmp_name"], $targetFilePath2);
       book_img($target_file2);
    }           
    } 
} 



//delete a book
if(isset($_POST['bkid']) && isset($_POST['authoremail']) && isset($_POST['bkdel'])) {

    $bkid = trim($_POST['bkid']);
    $authoremail = trim($_POST['authoremail']);

    if($_POST['bkdel'] == 'delete') {

    $sql = "UPDATE books SET `book_status` = 'deleted' WHERE `books_id` = '$bkid' AND `email_address` = '$authoremail'";
    $res = query($sql);

    $_SESSION['bkupdel'] = "Deleted";

    //refresh index page
    echo 'Loading... Please Wait';
    echo '<script>
    window.location.href = "./mybooks"
    </script>';

    } else {

    //delete draft permanetely
    if($_POST['bkdel'] == 'draft') {

    $sql = "DELETE FROM `books` WHERE `books_id` = '$bkid' AND `email_address` = '$authoremail'";
    $res = query($sql);

    $_SESSION['bkupdel'] = "Deleted";

    //refresh index page
    echo 'Loading... Please Wait';
    echo '<script>
    window.location.href = "./drafts"
    </script>';
    }
    }



}


//upgrading accounts
if(isset($_POST['upgrade'])) {

    $data = $_SESSION['login'];

    if(isset($_POST['upgrade']) == 'author') {

    $sql = "UPDATE users SET `role` = 'AUTHOR' WHERE `usname` = '$data' OR `email` = '$data'";
    $res = query($sql);

    echo $data;

    //redirect to author page
    echo '<script>
    window.location.href = "author/./"
    </script>';

    } else {


    if(isset($_POST['upgrade']) == 'publisher') {

    $sql = "UPDATE users SET `role` = 'PUBLISHER' WHERE `usname` = '$data' OR `email` = '$data'";
    $res = query($sql);

    //redirect to author page
    echo '<script>
    window.location.href = "publisher/./"
    </script>';

    }
    }
}


//author profile edit
if(isset($_POST['fname']) && isset($_POST['usname']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['bnk']) && isset($_POST['acctn']) && isset($_POST['actn']) && isset($_POST['inst']) && isset($_POST['whp']) && isset($_POST['twt']) && isset($_POST['fb']) && isset($_POST['bio']) && isset($_POST['idl'])) {

        $fname    = clean(escape($_POST['fname']));
        $usname   = clean(escape($_POST['usname']));
        $email    = clean(escape($_POST['email']));
        $tel      = clean(escape($_POST['tel']));
        $bnk      = clean(escape($_POST['bnk']));
        $acctn    = clean(escape($_POST['acctn']));
        $actn     = clean(escape($_POST['actn']));
        $inst     = clean(escape($_POST['inst']));
        $whp      = clean(escape($_POST['whp']));
        $twt      = clean(escape($_POST['twt']));
        $fb       = clean(escape($_POST['fb']));
        $bio      = clean(escape($_POST['bio']));  
        $id       = clean(escape($_POST['idl']));

        $sql = "UPDATE `users` SET `fullname` = '$fname', `usname` = '$usname', `email` = '$email', `telephone` = '$tel', `bnk nme` = '$bnk', `act name` = '$actn', `act no` = '$acctn', `instagram` = '$inst', `whatsapp` = '$whp', `twitter` = '$twt', `facebook` = '$fb', `bio` = '$bio'  WHERE `sn` = '$id'";
        $res = query($sql);

        echo "Loading... Please wait";

        $_SESSION['profileupldd'] = "Your profile has been updated successfully";

        //refresh profile page
        echo '<script>location.reload();</script>';

}


//user profile edit
if(isset($_POST['fname']) && isset($_POST['usname']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['idl']) && isset($_POST['ndl'])) {

        $fname    = clean(escape($_POST['fname']));
        $usname   = clean(escape($_POST['usname']));
        $email    = clean(escape($_POST['email']));
        $tel      = clean(escape($_POST['tel'])); 
        $id       = clean(escape($_POST['idl']));
    
        $sql = "UPDATE `users` SET `fullname` = '$fname', `usname` = '$usname', `email` = '$email', `telephone` = '$tel'  WHERE `sn` = '$id'";
        $res = query($sql);
    
        echo "Loading... Please wait";
    
        $_SESSION['profileupldd'] = "Your profile has been updated successfully";
        
        //refresh profile page
        echo '<script>location.reload();</script>';
    
}


         

                                            
                                                /****** END OF FUNCTIONS AFTER VALDATIONS */