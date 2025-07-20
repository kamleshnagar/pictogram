<?php


require_once 'config.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Can't Connect to Data Base!");

function p($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre><br>';
}

// function to show pages

function showPage($page, $data = "")
{
    include("assets/pages/" . $page . ".php");
}

// function to validate signup Form

function validateSignupForm($form_data)
{
      $response['status'] = true;
    if (!$form_data['password']) {
        $response['msg'] = "password is not given";
        $response['status'] = false;
        $response['field'] = 'password';
    }
    if (!$form_data['username']) {
        $response['msg'] = "Username is not given";
        $response['status'] = false;
        $response['field'] = 'username';
    }
    if (!$form_data['email']) {
        $response['msg'] = "Email is not given";
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (!$form_data['last_name']) {
        $response['msg'] = "Last name is not given";
        $response['status'] = false;
        $response['field'] = 'last_name';
    }
    if (!$form_data['first_name']) {
        $response['msg'] = "Fist name is not given";
        $response['status'] = false;
        $response['field'] = 'first_name';
    }

    return $response;
}


//  function for show error 

function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];

        if ($field == $error['field']) {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?=$error['msg'];?>
                </div>
             
            <?php
        }
    }
}


function showFormData ($field){
    if (isset($_SESSION['formdata'])) {
        $formdata = $_SESSION['formdata'];
        return $formdata[$field];
    }

}


// for checking duplicates

function isEmailRegistered($email){
    global $db;

    $sql = "SELECT count(*) as row FROM users WHERE email = '$email'";
    $run = mysqli_query($db,$sql);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];

}

?>