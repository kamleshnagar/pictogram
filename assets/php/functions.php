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
    if (isUserRegistered('email', $form_data['email'])) {
        $response['msg'] = "Email already registered. Try a new email.";
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (isUserRegistered('username', $form_data['username'])) {
        $response['msg'] = "Username already taken. Try another one.";
        $response['status'] = false;
        $response['field'] = 'username';
    }

    return $response;
}


// function for validate login
function validateLoginForm($form_data)
{
    $response['status'] = true;
    if (!$form_data['password']) {
        $response['msg'] = "password is not given";
        $response['status'] = false;
        $response['field'] = 'password';
    }
    if (!$form_data['username_email']) {
        $response['msg'] = "Username or Email is not given";
        $response['status'] = false;
        $response['field'] = 'username_email';
    }

    if (!checkUser($form_data)['status'] && !empty(!checkUser($form_data)['status'])) {
        $response['msg'] = "Soemthing is incorrect we cam't findy you";
        $response['status'] = false;
        $response['field'] = 'checkuser';
    }else{
        $response['user'] = checkUser($form_data);
    }





    return $response;
}

// for chacking the user

function checkUser($login_data)
{
    global $db;
    $username_email = $login_data['username_email'];
    $password = md5($login_data['password']);

    $query = "SELECT * FROM users WHERE (email = '$username_email' || username = '$username_email' && password = '$password' )";
    $run = mysqli_query($db, $query);
    $data['user'] =  mysqli_fetch_assoc($run) ?? array();

    if (count($data['user']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }

    return $data;
}



//function for show error 
function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];

        if ($field == $error['field']) {
?>
            <div class="alert alert-danger" role="alert">
                <?= $error['msg']; ?>
            </div>

<?php
        }
    }
}


function showFormData($field)
{
    if (isset($_SESSION['formdata'])) {
        $formdata = $_SESSION['formdata'];
        return $formdata[$field];
    }
}





// for checking duplicates

function isUserRegistered($field_name, $field_value)
{
    global $db;

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("SELECT COUNT(*) as row FROM users WHERE $field_name = ?");
    $stmt->bind_param("s", $field_value);
    $stmt->execute();
    $result = $stmt->get_result();
    $return_data = $result->fetch_assoc();

    return $return_data['row'] > 0;
}


// for creating new user 
function createUser($data)
{

    global $db;
    $first_name = mysqli_escape_string($db, $data['first_name']);
    $last_name = mysqli_escape_string($db, $data['last_name']);
    $gender = $data['gender'];
    $email = mysqli_escape_string($db, $data['email']);
    $username = mysqli_escape_string($db, $data['username']);
    $password = mysqli_escape_string($db, $data['password']);
    $password = md5($password);

    $sql = "INSERT INTO users (first_name, last_name, gender, email, username, password)
            VALUES('$first_name','$last_name',$gender,'$email','$username','$password')";
    return mysqli_query($db, $sql);
}


?>