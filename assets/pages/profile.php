<?php
global $profile;
global $user;
global $profile_post;

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
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-x-circle-fill"></i> Block</a></li>
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

                        <a class="btn btn-sm btn-primary"><i class="bi bi-file-post-fill"></i> <?= count($profile_post) ?> Posts</a>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#follower_list"><i class="bi bi-people-fill"></i> <?= count($profile['followers']) ?> Followers</a>
                        <a class="btn btn-sm btn-primary"><i class="bi bi-person-fill"></i><?= count($profile['following']) ?> Following</a>

                    </div>

                    <?php
                    if ($profile['id'] !== $user['id']) {
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
                    <img src="assets/images/post/<?= $post['post_img'] ?>" width="300px" class="rounded" />

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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body d-flex p-0">
                <div class="col-8">
                    <img src="assets/images/post/post2.jpg" class="w-100 rounded-start">
                </div>



                <div class="col-4 d-flex flex-column">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <div><img src="assets/images/profile/<?= $profile['profile_pic'] ?>" alt="" height="50" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-start align-items-center">
                            <h6 style="margin: 0px;">Monu Giri</h6>
                            <p style="margin:0px;" class="text-muted"><?= $profile['username'] ?></p>
                        </div>
                    </div>
                    <div class="flex-fill align-self-stretch overflow-auto" style="height: 100px;">

                        <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/profile/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/profile/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/profile/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/profile/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                    </div>
                    <div class="input-group p-2 border-top">
                        <input type="text" class="form-control rounded-0 border-0" placeholder="say something.."
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary rounded-0 border-0" type="button"
                            id="button-addon2">Post</button>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>



<!-- this is the followerlist -->
 <div class="modal fade" id="follower_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?php include('followers_modal.php'); ?>
        </div>
    </div>
</div>