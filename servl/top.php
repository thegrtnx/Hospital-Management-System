<?php
include("functions/init.php");

if(!isset($_SESSION['login'])) {  

redirect("./login");

}

user_details();

if($t_users['genotype'] == '') {

    redirect("./profile");  

}
?>