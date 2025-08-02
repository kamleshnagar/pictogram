<?php
global $profile;
global $user;
global $profile_post;

//  pr($profile['following']);

?>
<div class="container col-9 rounded-0 d-flex flex-column justify-content-center align-items-center">
    <div class="col-12 rounded p-4 mt-4 d-flex gap-5">
        <div class="col-4 d-flex justify-content-end align-items-start"><img src="assets/images/profile/<?= $profile['profile_pic'] ?>"
                class="img-thumbnail rounded-circle my-3" style="height:170px;width:170px;" alt="...">
        </div>
        <div class="col-4 justify-content-center">
            <div class="d-flex flex-column justify-content-center align-items-start">
                <div class="w-100">
                    <div class="d-flex gap-5 align-items-center justofy-content-between">
                        <span style="font-size: xx-large;"><?= $profile['first_name'] . ' ' . $profile['last_name'] ?></span>
                        <?php
                        if ($profile['id'] !== $user['id']) {
                        ?>

                            <div class="dropdown">
                                <span class="" style="font-size:xx-large" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i> </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-chat-fill"></i> Message</a></li>
                                    <li><a class="dropdown-item" href="assets/php/actions.php?block=<?=$profile['id']?>"><i class="bi bi-x-circle-fill"></i> Block</a></li>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <span style="font-size: larger;" class="text-secondary">@<?= $profile['username'] ?></span>
                </div>
                <div class="d-flex flex-column  ">
                    <div class="d- flex gap-2 align-items-center justify-content-center my-3">

                        <a class="btn btn-sm btn-primary posts"><i class="bi bi-file-post-fill"></i> <?= count($profile_post) ?> Posts</a>
                        <a class="btn btn-sm btn-primary followers" data-bs-toggle="modal" data-bs-target="#follower_list"><i class="bi bi-people-fill"></i> <?= count($profile['followers']) ?> Followers</a>
                        <a class="btn btn-sm btn-primary following" data-bs-toggle="modal" data-bs-target="#following_list">
                            <i class="bi bi-person-fill"></i> <?= count($profile['following']) ?> Following
                        </a>

                    </div>

                    <?php
                    if ($profile['id'] !== $user['id']) {
                        if(!isblock($profile['id'])){
                        if (checkFollowStatus($profile['id'])) {
                    ?>
                            <div class="d-flex">
                                <button class="btn btn-sm btn-danger unfollowbtn w-100" data-user-id='<?= $profile['id'] ?>'>Unfollow</button>
                            </div>
                        <?php
                        } else {

                        ?>
                            <div class="d-flex">
                                <button class="btn btn-sm btn-primary followbtn w-100 " data-user-id='<?= $profile['id'] ?>'>Follow</button>
                            </div>
                    <?php
                        }}else{
                            ?>
                            <div>
                                <h4>User blocked</h4>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>


    </div>
    <h3 class="border-bottom text-start w-100  ms-5 px-4">Posts</h3>

    <div class="gallery d-flex justify-content-center w-100 gap-2 mb-4">
        <div class="gallery d-flex justify-content-start flex-wrap gap-2 ms-4 px-4">

            <?php
            if (count($profile_post) > 0) {
                foreach ($profile_post as $post) {
            ?>
                    <img src="assets/images/post/<?= $post['post_img'] ?>" data-bs-toggle="modal" data-bs-target="#postview<?= $post['id'] ?>" width="300px" class="rounded" />


                    <!---------------------------------------------- Modal ---------------------------------------------->
                    <div class="modal fade" id="postview<?= $post['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body d-flex p-0">

                                    <div class="col-8">
                                        <img src="assets/images/post/<?= $post['post_img'] ?>" class="w-100 rounded-start">
                                    </div>



                                    <div class="col-4 d-flex flex-column">
                                        <div class="d-flex align-items-center p-2 border-bottom">

                                            <div>
                                                <a href="?u=<?= $profile['username'] ?>" class="text-decoration-none text-dark">
                                                    <img src="assets/images/profile/<?= $profile['profile_pic'] ?>" alt="" height="50" class="rounded-circle border">
                                                </a>
                                            </div>
                                            <div>&nbsp;&nbsp;&nbsp;</div>
                                            <div class="d-flex flex-column justify-content-start align-items-center">
                                                <a href="?u=<?= $profile['username'] ?>" class="text-decoration-none text-dark">

                                                    <h6 style="margin: 0px;"><?= $profile['first_name'] . ' ' . $profile['last_name'] ?></h6>
                                                    <p style="margin:0px;" class="text-muted">@<?= $profile['username'] ?></p>
                                                </a>
                                            </div>
                                            </a>
                                        </div>
                                        <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?= $post['id'] ?>" style="height: 100px;">


                                            <?php
                                            $comments = getComments($post['id']);
                                            if (!isset($comments) || !count($comments) > 0) {
                                            ?>
                                                <p class="p-3 nce">No Comments Found</p>

                                                <?php
                                            } else {


                                                // Reorder comments: logged-in user on top
                                                usort($comments, function ($a, $b) use ($user) {
                                                    return ($a['user_id'] == $user['id']) ? -1 : (($b['user_id'] == $user['id']) ? 1 : 0);
                                                });
                                                foreach ($comments as $comment) {
                                                    $cuser = getUser($comment['user_id']);
                                                ?>

                                                    <div class="d-flex align-items-center p-2">
                                                        <div><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark"><img src="assets/images/profile/<?= $cuser['profile_pic'] ?>" alt="" height="40" class="rounded-circle border"></a>

                                                        </div>
                                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="d-flex flex-column justify-content-start align-items-start">

                                                            <h6 style="margin: 0px;"><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark ">@<?= $cuser['username'] ?></a></h6>
                                                            <p class="m-0  mx-1 text-muted"><?= $comment['comment'] ?></p>
                                                        </div>
                                                    </div>


                                            <?php
                                                }
                                            }
                                            ?>


                                        </div>
                                        <div class="input-group p-2 border-top">
                                            <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.."
                                                aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-cs="comment-section<?= $post['id'] ?>" data-post-id="<?= $post['id'] ?>" type="button"
                                                id="button-addon2">Post</button>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
            } else {
                ?>

                <p class="text-muted w-100 fs-3 my-5">No Posts Found</p>

            <?php
            }


            ?>
        </div>
    </div>



</div>







<!-- modal for followers list -->
<div class="modal fade" id="follower_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($profile['followers']) && count($profile['followers']) > 0) {

                        // Reorder folloowers: logged-in user on top
                        usort($profile['followers'], function ($a, $b) use ($user) {
                            return ($b['user_id'] == $user['id']) - ($a['user_id'] == $user['id']);
                        });

                        // fetching users who liked the post
                        foreach ($profile['followers'] as $f) {
                            $fuser = getUser($f['follower_id']);
                            if ($fuser) {
                    ?>
                                <div class="d-flex justify-content-between shadow-sm p-2 mb-2 border rounded">
                                    <div class="d-flex align-items-center p-2">
                                        <div> <a href="?u=<?= $fuser['username'] ?>"><img src="assets/images/profile/<?= $fuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                                        </div></a>

                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="?u=<?= $fuser['username'] ?>" class="text-decoration-none text-dark">
                                                <h6 style="margin: 0px;font-size: small;"><?= $fuser['first_name'] . ' ' . $fuser['last_name'] ?></h6>
                                            </a>
                                            <a href="?u=<?= $fuser['username'] ?>" class="text-decoration-none">
                                                <p style="margin:0px;font-size:small" class="text-muted">@<?= $fuser['username'] ?></p>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    if ($f['follower_id'] !== $user['id']) {
                                        if (checkFollowStatus($f['follower_id'])) {
                                    ?>
                                            <div class='d-flex align-items-center '>
                                                <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= $fuser['id'] ?>">Unfollow</button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class='d-flex align-items-center '>
                                                <button class="btn btn-sm btn-primary followbtn" data-user-id="<?= $fuser['id'] ?>">Follow</button>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>


                    <?php
                            }
                        }
                    } else {
                        echo "<p class='text-muted'>No followers found</p>";
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>


<!-- modal for following list -->
<div class="modal fade" id="following_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Followings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($profile['following']) && count($profile['following']) > 0) {

                        // Reorder following: logged-in user on top
                        usort($profile['following'], function ($a, $b) use ($user) {
                            return ($b['user_id'] == $user['id']) - ($a['user_id'] == $user['id']);
                        });
                        // fetching users who liked the post
                        foreach ($profile['following'] as $f) {
                            $fuser = getUser($f['user_id']);
                            if ($fuser) {
                    ?>
                                <div class="d-flex justify-content-between shadow-sm p-2 mb-2 border rounded">
                                    <div class="d-flex align-items-center p-2">
                                        <div> <a href="?u=<?= $fuser['username'] ?>"><img src="assets/images/profile/<?= $fuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                                        </div></a>

                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="?u=<?= $fuser['username'] ?>" class="text-decoration-none text-dark">
                                                <h6 style="margin: 0px;font-size: small;"><?= $fuser['first_name'] . ' ' . $fuser['last_name'] ?></h6>
                                            </a>
                                            <a href="?u=<?= $fuser['username'] ?>" class="text-decoration-none">
                                                <p style="margin:0px;font-size:small" class="text-muted">@<?= $fuser['username'] ?></p>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    if ($f['user_id'] !== $user['id']) {
                                        if (checkFollowStatus($f['user_id'])) {
                                    ?>
                                            <div class='d-flex align-items-center '>
                                                <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= $fuser['id'] ?>">Unfollow</button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class='d-flex align-items-center '>
                                                <button class="btn btn-sm btn-primary followbtn" data-user-id="<?= $fuser['id'] ?>">Follow</button>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo "<p class='text-muted'>No followings found</p>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>