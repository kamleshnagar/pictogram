
<?php
require_once 'assets/php/functions.php';



if (isset($_GET['newfp'])) {
    unset($_SESSION['forget_email']);
    unset($_SESSION['forget_code']);
    unset($_SESSION['temp_auth']);
}
if (isset($_SESSION['AUTH'])) {

    $user = getUser($_SESSION['userdata']['id']);
    $posts =  filterPost();
    $follow_suggestions = filterFollowSuggestion();
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
} elseif (isset($_SESSION['AUTH']) && isset($_GET['u']) && $user['ac_status'] == 1) {
    $profile = getUserByUsername($_GET['u']);
    $profile_post = getPostByUserId($profile['id']);
    $profile['followers'] = getFollowers($profile['id']);
    $profile['following'] = getFollowing($profile['id']);



    if (!$profile) {

        showPage("header", ["page_title" => "User Not Found"]);
        showPage("navbar");
        showPage("usernotfound");
    } else {

        showPage("header", ["page_title" => $profile['first_name'] . ' ' . $profile['last_name']]);
        showPage("navbar");
        showPage("profile");
    }
} elseif (isset($_GET['signup']) && !isset($_SESSION['AUTH'])) {
    showPage("header", ["page_title" => "Pictogram-Signup"]);
    showPage("signup");
} elseif (isset($_GET['login']) && !isset($_SESSION['AUTH'])) {
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




if (isset($_SESSION['code'])) {
    pr($_SESSION['code']);
} elseif (isset($_SESSION['forget_code'])) {
    pr($_SESSION['forget_code']);
} else {
    pr('No code found');
}

unset($_SESSION['error']);
unset($_SESSION['success']);
unset($_SESSION['formdata']);
$n['post_id'] =47;
 $n['post_img'] = getPostById($n['post_id'])['post_img'];
 echo $n['post_img'];

showPage("footer");
