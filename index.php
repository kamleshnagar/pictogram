<?php
require_once 'assets/php/functions.php';
if(isset($_SESSION['AUTH'])){
    
    $user = getUser($_SESSION['userdata']['id']);
    
}


if (isset($_SESSION['AUTH']) && $user['ac_status'] == 0) {
    showPage("header", ["page_title" => "Pictogram - Verify email"]);
    showPage("verify_email");
} elseif (isset($_SESSION['AUTH']) && $user['ac_status'] == 1) {
    showPage("header", ["page_title" => "Home"]);
    showPage("wall");
} elseif (isset($_SESSION['AUTH']) && $user['ac_status'] == 2) {
    showPage("header", ["page_title" => "Blocked"]);
    showPage("blocked");
} elseif (isset($_GET['signup'])) {
    showPage("header", ["page_title" => "Pictogram-Signup"]);
    showPage("signup");
} elseif (isset($_GET['login'])) {
    showPage("header", ["page_title" => "Pictogram-Login"]);
    showPage("login");
} else {
    header('location:?login');
}


echo "check------------------->";
echo p($_SESSION);

showPage("footer");
unset($_SESSION['error']);
unset($_SESSION['formdata']);
