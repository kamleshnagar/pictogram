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
                <p class="text-muted fs-3">No Posts Found</p>
            </div>
        <?php
        } else {
        ?>
            <?php
            foreach ($posts as $post) {
                $likes = getLikes($post['id']);
            ?>
                <div class="card mt-4">
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
                    <h4 style="font-size: x-larger" class="p-2 border-bottom">
                        <i class="bi <?= checkLikeStatus($post['id']) ? 'bi-heart-fill text-danger unlike_btn' : 'bi-heart like_btn' ?>" data-post-id="<?= $post['id'] ?>"></i>

                        <i class="bi bi-chat-left"></i>
                    </h4>
                    <span class="text-muted px-2 " data-bs-toggle="modal" data-bs-target="#likes<?=$post['id']?>" >
                        <?= (count($likes) > 1) ? count($likes) . ' likes' : count($likes) . ' like' ?>
            </span>


                    <?php
                    if (!empty($post['post_text'])) {
                    ?>
                        <div class="card-body">
                            <?= $post['post_text'] ?>
                        </div>

                    <?php } ?>

                    <div class="input-group p-2 <?= !empty($posts['post_text']) ? 'border-top' : '' ?>">
                        <input type="text" class="form-control rounded-0 border-0" placeholder="say something.."
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary rounded-0 border-0" type="button"
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
                    <p style="margin:0px;" class="text-muted">@<?= $user['username'] ?></p>
                </a>
            </div>
        </div>
        <div>
            <h6 class="text-muted p-2">You Can Follow Them</h6>
            <div class="shadow bg-white p-3 rounded">
                <?php
                foreach ($follow_suggestions as $suser) {

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
                                    <p style="margin:0px;font-size:small" class="text-muted">@<?= $suser['username'] ?></p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ">
                            <button class="btn btn-sm btn-primary followbtn" data-user-id='<?= $suser['id'] ?>'>Follow</button>
                        </div>
                    </div>


                <?php
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

