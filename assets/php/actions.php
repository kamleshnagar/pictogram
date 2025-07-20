<?php

require_once 'functions.php';



if(isset($_GET['signup'])){
    $response = validateSignupForm($_POST);
   if($response['status']){
    echo isEmailRegistered('kamleshnagar0095@gmail.com');

   }else{
    $_SESSION['error'] = $response;
    $_SESSION['formdata'] = $_POST;
    
    header('location:../../?signup');
   }
    
}


?>