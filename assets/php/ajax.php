<?php
require_once 'config.php';
require_once 'functions.php';


if (isset($_GET['follow'])) {
    $user_id = $_POST['user_id'];

    if (checkFollowStatus($user_id)) {
        $response['status'] = false;
        echo json_encode($response);
        exit;
    }
    if (followUser($user_id)) {

        $response['status'] = true;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}

if (isset($_GET['unfollow']) || isset($_GET['u'])) {
    $user_id = $_POST['user_id'];

    if (unfollowUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}


// Post post_img  to data base 
if (isset($_GET['addpost'])) {

    $response = validatePostForm($_FILES['post_img']);

    if ($response['status']) {
        createPost($_POST, $_FILES['post_img']);
        $response['msg'] = "Post has been uploaded successfully";
        $response['status'] = true;
        $response['redirect'] = '?new_post_added';
        $response['field'] = 'post';
        $_SESSION['success'] =  $response;
    } else {
        $response['msg'] = "Failed";
        $response['status'] = false;
        $_SESSION['error'] = $response;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
