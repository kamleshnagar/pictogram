<?php
require_once 'config.php';
require_once 'functions.php';


if (isset($_GET['follow'])) {
    $user_id = $_POST['user_id'];
    if(checkFollowStatus($user_id)) {
        $response['status'] = false;
        echo json_encode($response);
        exit;
    }
    if (followUser($user_id)) {

        $response['status'] = true;
    } else {
        $response['status'] =false;
    }
    echo json_encode($response);
}

if (isset($_GET['unfollow'])) {
    $user_id = $_POST['user_id'];
  
    if (unfollowUser($user_id)) {

        $response['status'] = true;
    } else {
        $response['status'] =false;
    }
    echo json_encode($response);
}
