<?php 
//authorisation-access control.
if(!isset($_SESSION['user'])){
    //user not logged in redirect to login page with message.
    $_SESSION['no-login-message']="<div class='error text-center'>Please login to access admin panel.</div>";
    header('location:'.SITEURL.'admin/login.php');
}

?>