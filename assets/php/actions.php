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
        header('location:../../?home');
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
    sendCode($_SESSION['userdata']['email'], 'Verify youremail', $code);
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

?>