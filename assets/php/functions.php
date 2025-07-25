<?php


require_once 'config.php';



function deb($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre><br>';
    exit;
}
function pr(...$dataList)
{
    foreach ($dataList as $data) {
        echo '<pre>';
        print_r($data);
        echo '</pre><br>';
    }
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
    } else {
        $response['user'] = checkUser($form_data)['user'];
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

// for getting userdata by id 

function getUser($user_id)
{
    global $db;

    $query = "SELECT * FROM users WHERE id= $user_id; ";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}

//getting user data by username
function getUserByUsername($username)
{
    global $db;

    $query = "SELECT * FROM users WHERE username= '$username'; ";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}
// Getting feed post
function getPost()
{
    global $db;

    $query = "SELECT posts.id,posts.post_img,posts.post_text,posts.created_at,users.first_name,users.last_name,users.username,users.profile_pic FROM posts JOIN users ON users.id=posts.user_id ORDER BY id DESC;";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// getting Posts by user_id
function getPostByUserId($id)
{
    global $db;

    $query = "SELECT * FROM posts WHERE user_id = $id ORDER BY id DESC;";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

//function for verify Email
function verifyEmail($email)
{
    global $db;
    $query = "UPDATE `users` SET `ac_status` = 1 WHERE `email` = '$email'";
    return mysqli_query($db, $query);
}



//function for show error 
function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];

        if ($field == $error['field']) {
?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> <?= $error['msg']; ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
        }
    } else if (isset($_SESSION['error']) && $_GET['post_failed']) {
        $error = $_SESSION['error'];

        if ($field == $error['field']) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?= $error['msg']; ?>
            </div>

        <?php
        }
    } else if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];

        // if ($field == $success['field']) {
        ?>
        <div class="alert alert-success" role="alert">
            <?= $success['msg']; ?>
        </div>

<?php
        // }
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
    $query = "SELECT COUNT(*) as `row` FROM users WHERE $field_name = '$field_value' ;";
    $result = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($result);

    return $return_data['row'];
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
    $result = mysqli_query($db, $sql);

    return $result;
}


// function for update new password

function resetPassword($email, $password)
{
    global $db;
    $password = md5($password);
    $query = "UPDATE users SET password = '$password' WHERE email = '$email'";
    return mysqli_query($db, $query);
}


//for validating signup form


function validateUpdateForm($form_data, $image_data)

{

    $response['status'] = true;
    if (!$form_data['password']) {
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

    if (isUserRegisteredbyOther($form_data['username'])) {
        $response['msg'] = $form_data['username'] . " already taken. Try another one.";
        $response['status'] = false;
        $response['field'] = 'username';
    }
    if (($image_data['name'])) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
            $response['msg'] = "Only .jpg, .jpeg and .png files are allowed.";
            $response['status'] = false;
            $response['field'] = 'profile_pic';
        }
        if ($size > 1024) {
            $response['msg'] = "Upload image less then 1 mb.";
            $response['status'] = false;
            $response['field'] = 'profile_pic';
        }
    }

    return $response;
}


function isUserRegisteredbyOther($username)
{

    global $db;
    $user_id = $_SESSION['userdata']['id'];

    $query = "SELECT COUNT(*) as `row` FROM `users` WHERE username = '$username' && id!='$user_id';";
    $result = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($result);


    return $return_data['row'];
}



// for update profile 
function updateProfile($data, $image_data)
{
    global $db;


    $first_name = mysqli_escape_string($db, $data['first_name']);
    $last_name = mysqli_escape_string($db, $data['last_name']);
    $username = mysqli_escape_string($db, $data['username']);
    $password = mysqli_escape_string($db, $data['password']);


    if (!$data['password']) {
        $password = $_SESSION['userdata']['password'];
    } else {
        $password = md5($password);
        $_SESSION['userdata']['password'] = $password;
    }
    $profile_pic = "";
    if ($image_data['name']) {
        $image_name = time() . '-' . basename($image_data['name']);
        $image_dir = realpath(__DIR__ . "/../images/profile/") . "/" . $image_name;
        move_uploaded_file($image_data['tmp_name'], $image_dir);
        $profile_pic = ", profile_pic='$image_name'";
    }





    $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', username='$username',  password='$password' $profile_pic WHERE id=" . $_SESSION['userdata']['id'] . ";";
    return mysqli_query($db, $query);
}


//for validtating add post form 

function validatePostForm($media_data)

{

    $response['status'] = true;

    if (!$media_data['name']) {
        $response['msg'] = "Please select a video or image to upload. <small class='text-primary'>(file size should be less then 10mb)</small>";
        $response['status'] = false;
        $response['field'] = 'post_img';
    }
    if ($media_data['name']) {
        $media = basename($media_data['name']);
        $type = strtolower(pathinfo($media, PATHINFO_EXTENSION));
        $size = $media_data['size'] / 1000;

        if (!in_array($type, ['jpg', 'jpeg', 'png', 'mp4', 'mov', 'avi', 'wmv', 'mkv', 'webm', 'flv', 'mp4'])) {
            $response['msg'] = "Only image and video files are allowed.";
            $response['status'] = false;
            $response['field'] = 'post_img';
        }
        if ($size > 10240) {
            $response['msg'] = "Upload media file less then 10 mb.";
            $response['status'] = false;
            $response['field'] = 'post_img';
        }
    }

    return $response;
}


//for creating new post
function createPost($text, $image)
{
    global $db;

    $user_id = $_SESSION['userdata']['id'];
    $post_text = mysqli_escape_string($db, $text['post_text']);
    $image_name = time() . '-' . basename($image['name']);
    //uploading file to server


    $image_dir = realpath(__DIR__ . "/../images/post/") . "/" . $image_name;

    move_uploaded_file($image['tmp_name'], $image_dir);

    // sending post data to database
    $sql = "INSERT INTO posts (user_id, post_text, post_img)
            VALUES('$user_id','$post_text','$image_name')";
    return mysqli_query($db, $sql);
}


//for getting user for follow suggestions
function getFollowSuggestions()
{
    global $db;
    $current_user =  $_SESSION['userdata']['id'];
    $query = "SELECT * FROM users WHERE id!= $current_user  LIMIT 7;";
    $run =  mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

//for filtering th follow suggestion
function filterFollowSuggestion()
{
    $list = getFollowSuggestions();
    $filter_list = array();
    foreach ($list as $user) {
        if (!checkFollowStatus($user['id'])) {
            $filter_list[] = $user;
        }
    }
    return $filter_list;
}
//for filtering Wall Post follow suggestion
function filterPost()
{
    $list = getFollowSuggestions();
    $filter_list = array();
    foreach ($list as $user) {
        if (!checkFollowStatus($user['id'])) {
            $filter_list[] = $user;
        }
    }
    return $filter_list;
}
// for checking the user is followed by current user or not 
function checkFollowStatus($user_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "SELECT count(*) as `row` FROM follow_list WHERE follower_id = $current_user && user_id=$user_id ;";
    $run =  mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];;
}



function followUser($user_id)
{
    global $db;
    $current_user =  $_SESSION['userdata']['id'];
    $query = "INSERT INTO follow_list (follower_id, user_id) VALUES ('$current_user', '$user_id');";
    return mysqli_query($db, $query);
}
function unfollowUser($user_id)
{
    global $db;
    $user_id = 6;
    $current_user =  $_SESSION['userdata']['id'];
    $query = "DELETE FROM follow_list WHERE follower_id = '$current_user' AND user_id= '$user_id';";

    $result = mysqli_query($db, $query);

    return $result;
}
