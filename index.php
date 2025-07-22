<?php
require_once 'assets/php/functions.php';


if (isset($_GET['newfp'])) {
    unset($_SESSION['forget_email']);
    unset($_SESSION['forget_code']);
    unset($_SESSION['temp_auth']);
}
if (isset($_SESSION['AUTH'])) {

    $user = getUser($_SESSION['userdata']['id']);
}


if (isset($_SESSION['AUTH']) && $user['ac_status'] == 0) {
    showPage("header", ["page_title" => "Pictogram - Verify email"]);
    showPage("verify_email");
} elseif (isset($_SESSION['AUTH']) && $user['ac_status'] == 1) {
    showPage("header", ["page_title" => "Home"]);
    showPage("navbar");
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
} elseif (isset($_GET['forgetpassword'])) {
    showPage("header", ["page_title" => "Pictogram-Forgot Password"]);
    showPage("forgot_password");
} else {
    header('location:?login');
}


p($_SESSION);
p($_POST);
unset($_SESSION['error']);
unset($_SESSION['formdata']);

showPage("footer");
