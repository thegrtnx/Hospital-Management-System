<?php
include("servl/init.php");

if(!isset($_SESSION['login'])) {  

redirect("./login");

}

user_details();
?>