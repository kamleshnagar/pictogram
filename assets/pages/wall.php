<?php
global $user;
global $profile;
global $profile_post;
global $posts;
global $follow_suggestions;
?>

<div class="container">
    <?= showError('post') ?>
</div>
<div class="container col-9 rounded-0 d-flex justify-content-between">

    <div class="col-8">
        <?php
        if (count($posts) < 1) {
        ?>
            <div class="d-flex align-items-center justify-content-center shadow-sm border  container h-100 bg-white p-3 rounded">
                <p class="text-muted fs-3 ">No Posts Found</p>
            </div>
        <?php
        } else {
        ?>
            <?php
            foreach ($posts as $post) {
                $likes = getLikes($post['id']);
                $comments = getComments($post['id']);

            ?>
                <div class="card mt-4 post-card">
                    <div class="card-title d-flex justify-content-between  align-items-center">

                        <div class="d-flex align-items-center p-2">
                            <a href="?u=<?= $post['username'] ?>" class="text-decoration-none text-dark"> <img src="assets/images/profile/<?= $post['profile_pic'] ?>" alt="" height="30" class="rounded-circle border "><span class="px-2"><?= $post['first_name'] . ' ' . $post['last_name'] ?>
                                </span>
                        </div></a>
                        <div class="p-2">
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
                    <img src="assets/images/post/<?= $post['post_img'] ?>" class="" alt="...">
                    <div class="d-flex mt-3 gap-1 p-2 border-bottom w-100 ">
                        <h4 style="font-size: x-larger">
                            <i class="bi  <?= checkLikeStatus($post['id']) ? 'bi-heart-fill text-danger unlike_btn' : 'bi-heart like_btn' ?>" data-post-id="<?= $post['id'] ?>"></i>

                            <i class="bi  bi-chat-left" data-bs-toggle="modal" data-bs-target="#postview<?= $post['id'] ?>"></i>
                        </h4>
                        <span
                            class="text-muted  fst-italic px-2 text-dark comment-label"
                            data-bs-toggle="modal"
                            data-post-id="<?= $post['id'] ?>"
                            data-bs-target="#postview<?= $post['id'] ?>">
                            <?= (count($comments) > 1) ? count($comments) . ' Comments' : count($comments) . ' Comment' ?>
                        </span>
                    </div>

                    <div class="d-flex">
                        <span

                            class="text-muted px-2 like_count"
                            id="likeCount_<?= $post['id'] ?>"
                            data-bs-toggle="modal"
                            data-post-id="<?= $post['id'] ?>"
                            data-bs-target="#likes<?= $post['id'] ?>">
                            <?= (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like' ?>
                        </span>
                        <p class="text-muted  text-center fst-italic"> <i class="bi bi-dot"></i>Posted <?= timeAgo($post['created_at']) ?></p>

                    </div>
                    <!-- Modal for like  -->
                    <div class="modal fade" id="likes<?= $post['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Likes</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <!-- 👇 AJAX will load content here -->
                                <div class="modal-body" id="likesModalBody<?= $post['id'] ?>">
                                    <div class="text-center py-2 text-muted">Loading likes...</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!---------------------------------------------- Modal for postview ---------------------------------------------->
                    <div class="modal fade" id="postview<?= $post['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                                    class="text-muted px-2 text-align-center like_count"
                                                    id="likeCount_<?= $post['id'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-post-id="<?= $post['id'] ?>"
                                                    data-bs-target="#likes<?= $post['id'] ?>">
                                                    <?= (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like' ?>
                                                </span>

                                                <p class="text-muted px-2 text-center fst-italic">Posted <?= timeAgo($post['created_at']) ?></p>
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

                                                    <div class="d-flex align-items-center p-2 border-bottom">
                                                        <div><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark"><img src="assets/images/profile/<?= $cuser['profile_pic'] ?>" alt="" height="40" class="rounded-circle border"></a>

                                                        </div>
                                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                                        <div class="d-flex flex-column  align-items-start justify-content-center">
                                                            <div class="d-flex  align-items-center ">
                                                                <h6 style="margin: 0px;"><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-dark fst-italic ">@<?= $cuser['username'] ?></a></h6>
                                                                <span class="text-muted m-0 px-2 text-end fst-italic">• <?= timeAgo($comment['created_at']) ?></span>
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
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    if (!empty($post['post_text'])) {
                    ?>
                        <div class="card-body">
                            <?= $post['post_text'] ?>
                        </div>

                    <?php } ?>

                    <div class="input-group p-2 <?= !empty($posts['post_text']) ? 'border-top' : '' ?>">
                        <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.."
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-page="wall" data-cs="comment-section<?= $post['id'] ?>" data-post-id="<?= $post['id'] ?>" type="button"
                            id="button-addon2">Post</button>
                    </div>

                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="col-4 px-3">
        <div class="d-flex align-items-center p-2 shodow bg-white  rounded border my-4 p-3">
            <div><a href="?u=<?= $user['username'] ?>"><img src="assets/images/profile/<?= $user['profile_pic'] ?>" alt="" height="60" class="rounded-circle border"></a>
            </div>
            <div>&nbsp;&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center">
                <a href="?u=<?= $user['username'] ?>" class="text-decoration-none text-dark">
                    <h6 style="margin: 0px;"><?= $user['first_name'] . ' ' . $user['last_name'] ?></h6>
                </a>
                <a href="?u=<?= $user['username'] ?>" class="text-decoration-none">
                    <p style="margin:0px;" class="text-muted fst-italic">@<?= $user['username'] ?></p>
                </a>
            </div>
        </div>
        <div>
            <h6 class="text-muted p-2">You Can Follow Them</h6>
            <div class="shadow bg-white p-3 rounded">
                <?php
                foreach ($follow_suggestions as $suser) {
                    if (!isBlock($suser['id'])) {
                ?>

                        <div class="d-flex justify-content-between shadow-sm p-2 mb-2 border rounded">
                            <div class="d-flex align-items-center p-2">
                                <div> <a href="?u=<?= $suser['username'] ?>"><img src="assets/images/profile/<?= $suser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                                </div></a>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="?u=<?= $suser['username'] ?>" class="text-decoration-none text-dark">
                                        <h6 style="margin: 0px;font-size: small;"><?= $suser['first_name'] . ' ' . $suser['last_name'] ?></h6>
                                    </a>
                                    <a href="?u=<?= $suser['username'] ?>" class="text-decoration-none">
                                        <p style="margin:0px;font-size:small" class="text-muted fst-italic">@<?= $suser['username'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ">
                                <button class="btn btn-sm btn-primary followbtn" data-user-id='<?= $suser['id'] ?>'>Follow</button>
                            </div>
                        </div>


                    <?php
                    }
                }

                if (count($follow_suggestions) < 1) {
                    ?>
                    <div class="text-center bg-white p-3 rounded">
                        <p class="text-muted">No Follow Suggestions</p>
                    </div>
                <?php
                }

                ?>
            </div>


        </div>
    </div>
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

