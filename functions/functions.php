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
        
    $activator = md5(otp());
    
    $sql = "INSERT INTO users(`fullname`, `email`, `password`, `role`, `date_reg`, `activator`)";
    $sql.= " VALUES('$fnam', '$emai', '$pwor', '$catgy', '$datereg', '$activator')";
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

    echo '<script>window.location.href ="./activate"</script>';

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