<?php

use Dom\Comment;

require_once 'config.php';
require_once 'functions.php';

global $user;
global $profile;
global $profile_post;
global $posts;
global $follow_suggestions;


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

if (isset($_GET['unfollow'])) {
    $user_id = $_POST['user_id'];

    if (unfollowUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}


// like post

if (isset($_GET['like'])) {
    $post_id = $_POST['post_id'];

    if (!checkLikeStatus($post_id)) {
        if (like($post_id)) {
            notify("like", $post_id);
            $response['status'] = true;
            $likes = getLikes($post_id);
            $response['like_count'] = (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like';
        } else {
            $response['status'] = false;
        }
    }
    echo json_encode($response);
}

// unlike post
if (isset($_GET['unlike'])) {
    $post_id = $_POST['post_id'];
    if (checkLikeStatus($post_id)) {

        if (unlike($post_id)) {

            $response['status'] = true;
            $likes = getLikes($post_id);
            $response['like_count'] = (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like';
        } else {
            $response['status'] = false;
        }
    }
    echo json_encode($response);
}


// Post post_img  to data base 
if (isset($_GET['addpost'])) {

    $response = validatePostForm($_FILES['post_img']);

    if ($response['status']) {
        if (createPost($_POST, $_FILES['post_img'])) {
            notify("post");
            $response['msg'] = "Post has been uploaded successfully";
            $response['status'] = true;
            $response['redirect'] = '?new_post_added';
            $response['field'] = 'post';
            $_SESSION['success'] =  $response;
        } else {
            $response['msg'] = "Create Post Failed";
            $response['status'] = false;
            $_SESSION['error'] = $response;
        }
    } else {
        $response['msg'] = "Failed";
        $response['status'] = false;
        $_SESSION['error'] = $response;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// for counting likes
if (isset($_GET['get_like_count'])) {
    $post_id = $_POST['post_id'];
    $likes = getLikes($post_id);
    $response['status'] = true;
    $response['like_count'] = (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like';
    echo json_encode($response);
}



// Comment on post
if (isset($_GET['addcomment'])) {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    if (addComment($post_id, $comment)) {
        $cuser = getUser($_SESSION['userdata']['id']);
        $response['status'] = true;
        $response['comment'] = '
                                    <div class="d-flex align-items-center p-2">
                                        <div>
                                            <a href="?u=' . $cuser['username'] . '" class="text-decoration-none text-dark">
                                                <img src="assets/images/profile/' . $cuser['profile_pic'] . '" alt="" height="40" class="rounded-circle border">
                                            </a>
                                        </div>
                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                        <div class="d-flex flex-column justify-content-start align-items-start">
                                            <h6 style="margin: 0px;">
                                                <a href="?u=' . $cuser['username'] . '" class="text-decoration-none text-dark ">@' . $cuser['username'] . '</a>
                                            </h6>
                                            <p class="m-0 mx-1 text-muted">' . $comment . '</p>
                                        </div>
                                    </div>';
    } else {
        $response['status'] = false;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}








// for getting like list
if (isset($_GET['get_like_list'])) {
    $post_id = $_POST['post_id'];
    $likes = getLikes($post_id);
    $user = getUser($_SESSION['userdata']['id']);

    //modal likes body
    if (isset($likes) && count($likes) > 0) {


        usort($likes, function ($a, $b) use ($user) {
            return ($a['user_id'] == $user['id']) ? -1 : (($b['user_id'] == $user['id']) ? 1 : 0);
        });

        foreach ($likes as $like) {
            $liker = getUser($like['user_id']);
            if ($liker) {
?>
                <div class="d-flex justify-content-between shadow-sm p-2 mb-2 border rounded">
                    <div class="d-flex align-items-center p-2">
                        <div>
                            <a href="?u=<?= $liker['username'] ?>">
                                <img src="assets/images/profile/<?= $liker['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                            </a>
                        </div>

                        <div class="d-flex flex-column justify-content-center ms-2">
                            <a href="?u=<?= $liker['username'] ?>" class="text-decoration-none text-dark">
                                <h6 class="m-0" style="font-size: small;"><?= $liker['first_name'] . ' ' . $liker['last_name'] ?></h6>
                            </a>
                            <a href="?u=<?= $liker['username'] ?>" class="text-decoration-none">
                                <p class="m-0 text-muted" style="font-size: small;">@<?= $liker['username'] ?></p>
                            </a>
                        </div>
                    </div>

                    <?php if ($liker['id'] !== $user['id']) : ?>
                        <div class='d-flex align-items-center'>
                            <?php if (isBlock($liker['id'])) : ?>
                                <button class="btn btn-sm btn-danger blocked" data-user-id="<?= $liker['id'] ?>" disabled>Blocked</button>
                            <?php elseif (isUserBlocked($liker['id'])) : ?>
                                <p class="text-muted" data-user-id="<?= $liker['id'] ?>"></p>

                            <?php elseif (checkFollowStatus($liker['id'])) : ?>
                                <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= $liker['id'] ?>">Unfollow</button>
                            <?php else : ?>
                                <button class="btn btn-sm btn-primary followbtn" data-user-id="<?= $liker['id'] ?>">Follow</button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
<?php
            }
        }
    } else {
        echo "<p class='text-muted'>No likes found</p>";
    }

    exit();
}
?>





<?php

// for getting user serach box 

if (isset($_POST['search'])) {
    global $db;
    $search = mysqli_real_escape_string($db, $_POST['search']);

    $sql = "SELECT *
            FROM users 
            WHERE username LIKE '%$search%' 
            OR CONCAT(first_name, ' ', last_name) LIKE '%$search%'
            LIMIT 5";

    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            if ($user['id'] == $_SESSION['userdata']['id']) {
                echo "<div class='list-group-item'>No results found</div>";
            } else {
                echo ' 
            <div class="border rounded">
                        <div class="d-flex align-items-center p-2">
                            <div> <a href="?u=' . $user['username'] . '"><img src="assets/images/profile/' . $user['profile_pic'] . '" alt="" height="40" width="40" class="rounded-circle border">
                            </div></a>
                            <div>&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="?u=' . $user['username'] . '" class="text-decoration-none text-dark">
                                    <h6 style="margin: 0px;font-size: small;">' . $user['first_name'] . ' ' . $user['last_name'] . '</h6>
                                </a>
                                <a href="?u=' . $user['username'] . '" class="text-decoration-none">
                                    <p style="margin:0px;font-size:small" class="text-muted fst-italic">@' . $user['username'] . '</p>
                                </a>
                            </div>
                        </div>
            </div>
                        ';
            }
        }
    } else {
        echo "<div class='list-group-item'>No results found</div>";
    }
}



// for read_status true notification
if (isset($_GET['notification'])) {
    $n_id = $_POST['n_id'];
    $n = getNotifiactionById($n_id);
    if (isset($n_id) && changeNotificationReadStatus($n_id)) {
        $response['status'] = true;
        $response['n_id'] = $n_id;
        if ($n['action'] == 3) {
            $user = getUser($n['follower_id']);
            $response['redirect'] = '?u=' . $user['username'];
        }
    } else {
        $response['msg'] = "something went wrong";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// for get notifications
if (isset($_GET['getNotifications'])) {
    $notifications = filterNotifcation();
    $user = getUser($_SESSION['userdata']['id']);
    $posts =  filterPost();
    $follow_suggestions = filterFollowSuggestion();
    $html = '';

    // action → message mapping
    $messages = [
        0 => 'Added a new post',
        1 => 'Liked your post',
        2 => 'Commented on your post',
        3 => 'Started following you'
    ];

    if ($notifications && count($notifications) > 0) {
        foreach ($notifications as $n) {
            if (empty($n)) continue;
            $n['post_img'] = getPostById($n['post_id'])['post_img'];
            $u = getUser($n['follower_id']);
          
            $readClass = ($n['read_status'] == 0 ? '' : 'bg-light');
            $dot = ($n['read_status'] == 0)
                ? '<div class="d-flex"><span class="bg-primary dot" style="height:100%;width:5px"></span></div>'
                : '';
            $msg = $messages[$n['action']] ?? 'Notification';

            // optional attributes
            $extra = '';
            if ($n['action'] == 2) { // comment
                $extra = ' href="#comment_' . $n['comment_id'] . '" data-c-id="' . $n['comment_id'] . '"';
            } elseif ($n['action'] == 3) { // follow
                $extra = ' data-user-id="' . $n['user_id'] . '"';
            }

            $target = in_array($n['action'], [0, 1, 2]) ? 'data-bs-toggle="modal" data-bs-target="#postview' . $n['post_id'] . '"' : '';

            $html .= '
            <div ' . $target . $extra . '
                style="min-height:70px;"
                id="n_id_' . $n['id'] . '"
                class="notification d-flex p-1 border-bottom ' . $readClass . '"
                ' . ($n['read_status'] == 0 ? 'data-n-id="' . $n['id'] . '"' : '') . '>
                ' . $dot . '
                    <div class="d-flex flex-column w-100 pe-3">
                         <div class="d-flex justify-content-between w-100 pe-3">
                            <div class="d-flex pe-2">
                                    <div class="d-flex align-items-center ms-2">
                                        <a href="?u=' . $u['username'] . '">
                                            <img src="assets/images/profile/' . $u['profile_pic'] . '" height="40" width="40" class="rounded-circle border">
                                        </a>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div>
                                            <h6 class="m-0">' . $u['first_name'] . ' ' . $u['last_name'] . '</h6>
                                            <p class="m-0"><span class="text-muted">' . $u['username'] . '</span> ' . $msg . '</p>
                                        </div>
                                        <img src="assets/images/post/'.$n['post_img'].'" height="40" width="40" class="rounded border position-relative  m-2" style="left:60px">
                                    </div>
                                     
                            </div>
                        </div>
                        <div class=" text-end text-muted my-1" style="font-size:15px;">' . timeAgo($n['created_at']) . '</div>
                    </div>

                <hr>
            </div>';
        }
    } else {
        $html = '<p class="text-muted text-italic">No notifications</p>';
    }

    echo json_encode(['notifications' => $html]);
    exit;
}



if (isset($_GET['getNotifCount'])) {
    $notifications = filterNotifcation();

    $unread = [];

    if (!empty($notifications)) {
        foreach ($notifications as $n) {
            if ($n['read_status'] == 0) {
                $unread[] = $n;
            }
        }
    }

    echo count($unread);
    exit;
}
