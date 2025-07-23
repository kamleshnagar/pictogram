<?php
require_once 'assets/php/functions.php';


if (isset($_GET['newfp'])) {
    unset($_SESSION['forget_email']);
    unset($_SESSION['forget_code']);
    unset($_SESSION['temp_auth']);
}
if (isset($_SESSION['AUTH'])) {

    $user = getUser($_SESSION['userdata']['id']);
    $post = getPost();
}


$pagecount = count($_GET);




// manage pages
if (isset($_SESSION['AUTH']) && $user['ac_status'] == 0 && !$pagecount) {
    showPage("header", ["page_title" => "Pictogram - Verify email"]);
    showPage("verify_email");
} elseif (isset($_SESSION['AUTH']) && $user['ac_status'] == 1 && !$pagecount) {
    showPage("header", ["page_title" => "Home"]);
    showPage("navbar");
    showPage("wall");
} elseif (isset($_SESSION['AUTH']) && $user['ac_status'] == 2 && !$pagecount) {
    showPage("header", ["page_title" => "Blocked"]);
    showPage("blocked");
} elseif (isset($_SESSION['AUTH']) && isset($_GET['edit_profile']) && $user['ac_status'] == 1) {
    showPage("header", ["page_title" => "Edit Profile"]);
    showPage("navbar");
    showPage("edit_profile");
} elseif (isset($_GET['signup']) && !isset($_SESSION['AUTH'])) {
    showPage("header", ["page_title" => "Pictogram-Signup"]);
    showPage("signup");
} elseif (isset($_GET['login']) && isset($_SESSION['AUTH'])) {
    showPage("header", ["page_title" => "Pictogram-Login"]);
    showPage("login");
} elseif (isset($_GET['forgetpassword'])) {
    showPage("header", ["page_title" => "Pictogram-Forgot Password"]);
    showPage("forgot_password");
} else {
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
    } else {
        showPage("header", ["page_title" => "Pictogram-Login"]);
        showPage("login");
    }
}




unset($_SESSION['error']);
unset($_SESSION['formdata']);

showPage("footer");

// echo 'pagecount' . p($pagecount);
// p($user);
// // p($_POST);
// p($_SESSION);
