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
                    if (isset($profile['following']) && count($profile['following']) > 0) {
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