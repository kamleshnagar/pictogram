<?php

require_once 'functions.php';


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
        header('location:../../?home');

    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;

        header('location:../../?login');
    }
}



?>