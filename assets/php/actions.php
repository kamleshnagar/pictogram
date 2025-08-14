<?php

require_once 'functions.php';
require_once 'send_code.php';


// for managign signup

if (isset($_GET['signup'])) {
    $response = validateSignupForm($_POST);
    if ($response['status']) {
        if (createUser($_POST)) {

            header('location:../../?login&newuser');
            exit;
        } else {
?>
            <script>
                alert("Something is wrong can't create user")
            </script>

<?php

        }
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;

        header('location:../../?signup');
    }
}

//for managing login 
if (isset($_GET['login'])) {
    $response = validateLoginForm($_POST);
    if ($response['status']) {
        $_SESSION['AUTH'] = true;
        $_SESSION['userdata'] = $response['user'];

        if ($response['user']['ac_status'] == 0) {
            $code = rand(111111, 999999);
            $_SESSION['code'] = $code;
            sendCode($response['user']['email'], 'Verify youremail', $code);
        }
        header('location:../../');
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;

        header('location:../../?login');
    }
}

// resend code

if (isset($_GET['resend_code'])) {
    $code = rand(111111, 999999);
    $_SESSION['code'] = $code;
    sendCode($_SESSION['userdata']['email'], 'Verify your email', $code);
    header('location:../../?resended');
}


if (isset($_GET['verify_email'])) {
    $code = $_POST['code'];
    $user_code = $_SESSION['code'];
    if ($code == $user_code) {
        if (verifyEmail($_SESSION['userdata']['email'])) {
            header('location:../../');
        } else {
            echo 'something is wrong';
        }
    } else {
        $response['msg'] = 'Incorrect verification code!';
        if (!$_POST['CODE']) {
            $response['msg'] = 'Enter 6 digit verification code';
        }
        $response['field'] = 'verify_email';
        $_SESSION['error'] = $response;
        header('location:../../');
    }
}


if (isset($_GET['forgetpassword'])) {
    if (!$_POST['email']) {
        $response['msg'] = "Please enter a your email.";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgetpassword');
        exit;
    } elseif (!isUserRegistered('email', $_POST['email'])) {
        $response['msg'] = "Email is not registered. Enter a valid email.";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgetpassword');
        exit;
    } else {
        $_SESSION['forget_email'] = $_POST['email'];
        $code = rand(111111, 999999);
        $_SESSION['forget_code'] = $code;
        sendCode($_POST['email'], 'Forgot your password ', $code);
        header('location:../../?forgetpassword');
        exit;
    }
}


//function for verify code


if (isset($_GET['verifycode'])) {
    $code = $_POST['code'];
    $user_code = $_SESSION['forget_code'];
    if ($code == $user_code) {
        $_SESSION['temp_auth'] = true;
        header('location:../../?forgetpassword');
    } else {
        $response['msg'] = 'Incorrect verification code!';
        if (!$_POST['code']) {
            $response['msg'] = 'Enter 6 digit verification code';
        }
        $response['field'] = 'code';
        $_SESSION['error'] = $response;
        header('location:../../?forgetpassword');
    }
}



if (isset($_GET['changepassword'])) {
    if (isset($_POST['password']) && !empty($_POST['password'] && $_SESSION['temp_auth'])) {
        $password = $_POST['password'];
        $email = ($_SESSION['forget_email']);
        resetPassword($email, $password);
        header('location:../../?newfp');
    } else {
        $response['msg'] = 'Please Enter New Password';
        $response['msg'] = 'Please Enter New Password';
        $response['field'] = 'password';
        $_SESSION['error'] = $response;

        header('location:../../?forgetpassword');
    }
}





if (isset($_GET['logout'])) {
    session_destroy();
    header('location:../../');
}




//for update profile
if (isset($_GET['updateprofile'])) {

    $response = validateUpdateForm($_POST, $_FILES['profile_pic']);
    // d($_SESSION);

    if ($response['status']) {
        if (updateProfile($_POST, $_FILES['profile_pic'])) {
            echo 'profile updated';
            header('location:../../?edit_profile&success');
        } else {
            echo  'somethig is wrong';
        }
    } else {
        $_SESSION['error'] = $response;
        header('location:../../?edit_profile');
    }
}


// Post post_img  to data base 
// if (isset($_GET['addpost'])) {

//     $response = validatePostForm($_FILES['post_img']);
//     if ($response['status']) {
//         createPost($_POST, $_FILES['post_img']);
//         $response['msg'] = "Post has been uploaded successfully";
//         $_SESSION['success'] =  $response;
//         header('location:../../?new_post_added');
//     } else {
//         $_SESSION['error'] = $response;
//         header('location:../../?post_failed');
//     }
// }


//block user

if (isset($_GET['block'])) {

    $profile_username = $_GET['u'];
    $profile_id = $_GET['block'];
    $response = isBlock($profile_id);
    if (!isblock($profile_id)) {
        unfollowUser($profile_id);
        block($profile_id);
        header('location:../../index.php?u=' . $profile_username . '&blocked');
    } else {
        echo 'user blocked';
    }
}


//unblock user
if (isset($_GET['unblock'])) {

    $profile_id = $_GET['unblock'];
    $profile_username = $_GET['u'];


    $response = isBlock($profile_id);
    if ($response) {
        unblock($profile_id);
        header('location:../../index.php?u=' . $profile_username . '&unblocked');
    }
}
