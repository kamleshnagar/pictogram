<?php
if (isset($_SESSION['AUTH']) && $_SESSION['userdata']['ac_status'] == 1) {

?>

    <?php
    global $profile_post;
    ?>
    <?php

    require_once __DIR__ . "/../php/functions.php";
    $user = getUser($_SESSION['userdata']['id']);
    if (isset($_GET['u'])) {
        $posts = $profile_post + filterPost();
    } else {
        $posts = filterPost();
    }
    $follow_suggestions = filterFollowSuggestion();

    ?>

    <div id="footer_content">
        <?php
        foreach ($posts as $post) {
            $likes = getLikes($post['id']);
            $comments = getComments($post['id']);
        ?>

            <!---------------------------------------------- Modal for postview ---------------------------------------------->

            <div class="modal fade" id="postview<?= $post['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" height="50" width="50">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body d-flex p-0">

                            <div class="col-8">
                                <img src="assets/images/post/<?= $post['post_img'] ?>" class="w-100 rounded-start">
                            </div>



                            <div class="col-4 d-flex flex-column">
                                <div class="d-flex align-items-center p-2 border-bottom justify-content-between">
                                    <div class="d-flex align-items-center p-2 ">

                                        <div>
                                            <a href="?u=<?= $post['username'] ?>" class="text-decoration-none text-dark">
                                                <img src="assets/images/profile/<?= $post['profile_pic'] ?>" alt="" height="50" class="rounded-circle border">
                                            </a>
                                        </div>
                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                        <div class="d-flex flex-column justify-content-start align-items-center">
                                            <a href="?u=<?= $post['username'] ?>" class="text-decoration-none text-dark">

                                                <h6 style="margin: 0px;"><?= $post['first_name'] . ' ' . $post['last_name'] ?></h6>
                                                <p style="margin:0px;" class="text-muted fst-italic">@<?= $post['username'] ?></p>
                                            </a>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column text-end justify-content-center mt-3">
                                        <span

                                            class="text-muted px-2 like_count"
                                            id="modalLikeCount_<?= $post['id'] ?>"
                                            data-bs-toggle="modal"
                                            data-post-id="<?= $post['id'] ?>"
                                            data-bs-target="#likes<?= $post['id'] ?>">
                                            <?= (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like' ?>
                                        </span>
                                        <p class="text-muted time px-2 text-center fst-italic">Posted <?= timeAgo($post['created_at']) ?></p>
                                    </div>
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
                                            $cuser = getUser($comment['user_id']);;


                                        ?>

                                            <div class="d-flex align-items-center p-2 border-bottom" id="comment_<?= $comment['id'] ?>">
                                                <div><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark"><img src="assets/images/profile/<?= $cuser['profile_pic'] ?>" alt="" height="40" class="rounded-circle border"></a>

                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;</div>
                                                <div class="d-flex flex-column  align-items-start justify-content-center">
                                                    <div class="d-flex  align-items-center ">
                                                        <h6 style="margin: 0px;"><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark fst-italic ">@<?= $cuser['username'] ?></a></h6>
                                                        <p class="text-muted time m-0 px-2 text-end fst-italic">• <?= timeAgo($comment['created_at']) ?></p>
                                                    </div>
                                                    <p class="m-0  mx-1 text-muted text-dark"><?= $comment['comment'] ?></p>


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
                                    <h4 style="font-size: x-larger; height:100%;" class="d-flex justify-content-center align-items-center pt-2">
                                        <i class="bi   <?= checkLikeStatus($post['id']) ? 'bi-heart-fill text-danger unlike_btn' : 'bi-heart like_btn' ?>" data-post-id="<?= $post['id'] ?>"></i>
                                    </h4>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        <?php
        } ?>


    </div>





    <!-- modal for posts list -->
    <div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="post_img" style="display:none" class="w-100 rounded border">
                    <form method="POST" action="assets/php/actions.php?addpost" enctype="multipart/form-data">
                        <div class="my-3">
                            <input class="form-control" name="post_img" type="file" id="select_post_img">
                            <div id="post_img_error" class="text-danger mt-2 small"></div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
                            <textarea name="post_text" class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                        </div>
                    </form>
                </div>
                <button type="submit" class="btn btn-primary post-btn">Post</button>
            </div>

        </div>
    </div>


    <!-- // modal for conversation -->
    <div class="modal fade" id="chatbox" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title w-100 d-flex align-items-center">

                        <a id="linkusername" href="?u=" class="d-flex align-items-center text-decoration-none text-dark">
                            <img id="chatter_pic" src="" height="40" width="40" class="rounded-circle border">


                            <div class="ms-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 id="chatter_name" class="m-0"></h5>
                                    <p id="chatter_username" class="m-0 p-0 text-muted"></p>
                                </div>

                            </div>
                        </a>

                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column my-2" id="chat_box">

                    </div>
                    <hr class="m-0 p-0">
                    <div class="pb-2 px-2">
                        <?php

                        ?>
                        <form id=msginputform action="">
                            <div class="input-group mt-2">
                                <input type="text" class="form-control rounded-0 border-0" placeholder="Type a message" id="msginput" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary rounded-0 border-0" type="button" id="sendmsg" data-user-id="0">Send</button>
                            </div>
                        </form>
                        <?php

                        ?>
                        <div class="alert alert-warning mt-2 " id="blockederror" role="alert">
                            You are not allowed to send message to this user.
                        </div>
                        <?php

                        ?>
                    </div>
                </div>
            </div>
        </div>


    <?php
}
    ?>

    <script src="assets/js/jquery-3.7.1.min.js?v=<?= time() ?>"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/custom.js?v=<?= time() ?>"></script>
    </body>

    </html>