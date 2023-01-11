<?php
include("init.php");

if(!isset($_SESSION['login'])) {  

redirect("./login");

} else {

user_details();

if($t_users['genotype'] == '') {

    redirect("./profile");  

}

}               
?>