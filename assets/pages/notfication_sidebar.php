<div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="notification_sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="notification_sidebarLabel">Notifications</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>



  <hr class="m-0 p-0">
  <div class="offcanvas-body p-0 ">
    <?php
    $notifications = filterNotifcation();
    if (count($notifications) > 0) {

      foreach ($notifications as $notification) {
        if (!empty($notification)) {
          $nuser = getUser($notification['follower_id']);
        }
        if (!empty($notification) && $notification['action'] == 0) {

    ?>
          <div data-bs-toggle="modal" data-bs-target="#postview<?= $notification['post_id'] ?>" style="min-height:70px;" id="n_id_<?= $notification['id'] ?>" class="notification d-flex p-1 border-bottom <?= ($notification['read_status'] == 0 ? '' : 'bg-light') ?>" <?= ($notification['read_status'] == 0) ? 'data-n-id=' . $notification['id'] : '' ?>>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex">
                <span class=" bg-primary  dot " style="height:100%; width:5px"> </span>
              </div>
            <?php } ?>
            <div class="d-flex justify-content-between w-100 pe-3">
              <div class="d-flex pe-2">
                <div class="d-flex align-items-center ms-2"> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                </div></a>
                <div>&nbsp;&nbsp;</div>
                <div class="d-flex  justify-content-center align-items-center">
                  <div class="align-items-center">
                    <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                    <p class="m-0">(<?= $notification['id'] ?>) added a new post</p>
                  </div>

                </div>
              </div>
              <div class="d-flex gap-2 justify-content-end align-items-center ">
                <div class="text-end text-muted my-1" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
              </div>
            </div>
            <hr>
          </div>



        <?php
        } elseif (!empty($notification) && $notification['action'] == 1) {

        ?>
          <div data-bs-toggle="modal" data-bs-target="#postview<?= $notification['post_id'] ?>" style="min-height:70px;" id="n_id_<?= $notification['id'] ?>" class="notification d-flex p-1 border-bottom <?= ($notification['read_status'] == 0 ? '' : 'bg-light') ?>" <?= ($notification['read_status'] == 0) ? 'data-n-id=' . $notification['id'] : '' ?>>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex">
                <span class=" bg-primary  dot " style="height:100%; width:5px"> </span>
              </div>
            <?php } ?>
            <div class="d-flex justify-content-between w-100 pe-3">
              <div class="d-flex pe-2">
                <div class="d-flex align-items-center ms-2"> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                </div></a>
                <div>&nbsp;&nbsp;</div>
                <div class="d-flex  justify-content-center align-items-center">
                  <div class="align-items-center">
                    <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                    <p class="m-0">(<?= $notification['id'] ?>) liked your post</p>
                  </div>

                </div>
              </div>
              <div class="d-flex gap-2 justify-content-end align-items-center ">
                <div class="text-end text-muted my-1" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
              </div>
            </div>
            <hr>
          </div>
        <?php
        } elseif (!empty($notification) && $notification['action'] == 2) {

        ?>
          <div href="#comment_<?= $notification['comment_id'] ?>" data-c-id="<?= $notification['comment_id'] ?>" data-bs-toggle="modal" data-bs-target="#postview<?= $notification['post_id'] ?>" style="min-height:70px;" id="n_id_<?= $notification['id'] ?>" class="notification d-flex p-1 border-bottom <?= ($notification['read_status'] == 0 ? '' : 'bg-light') ?>" <?= ($notification['read_status'] == 0) ? 'data-n-id=' . $notification['id'] : '' ?>>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex">
                <span class=" bg-primary  dot " style="height:100%; width:5px"> </span>
              </div>
            <?php } ?>
            <div class="d-flex justify-content-between w-100 pe-3">
              <div class="d-flex pe-2">
                <div class="d-flex align-items-center ms-2"> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                </div></a>
                <div>&nbsp;&nbsp;</div>
                <div class="d-flex  justify-content-center align-items-center">
                  <div class="align-items-center">
                    <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                    <p class="m-0">(<?= $notification['id'] ?>) commented on your post</p>
                  </div>

                </div>
              </div>
              <div class="d-flex gap-2 justify-content-end align-items-center ">
                <div class="text-end text-muted my-1" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
              </div>
            </div>
            <hr>
          </div>
        <?php
        } elseif (!empty($notification) && $notification['action'] == 3) {

        ?>
          <div>

            <div style="min-height:70px;" id="n_id_<?= $notification['id'] ?>" class="notification d-flex p-1 border-bottom <?= ($notification['read_status'] == 0 ? '' : 'bg-light') ?>" data-user-id="<?=$notification['user_id']?>" data-n-id=" <?= $notification['id']?>">

              <?php if ($notification['read_status'] == 0) { ?>
                <div class="d-flex">
                  <span class=" bg-primary  dot " style="height:100%; width:5px"> </span>
                </div>
              <?php } ?>
              <div class="d-flex justify-content-between w-100 pe-3">
                <div class="d-flex pe-2">
                  <div class="d-flex align-items-center ms-2">
                    <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                    </a>
                  </div>
                  <div>&nbsp;&nbsp;</div>
                  <div class="d-flex  justify-content-center align-items-center">
                    <div class="align-items-center">
                      <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                      <p class="m-0">(<?= $notification['id'] ?>) started following you</p>
                    </div>

                  </div>
                </div>
                <div class="d-flex gap-2 justify-content-end align-items-center ">
                  <div class="text-end text-muted my-1" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
                </div>
              </div>
              <hr>
            </div>

          </div>
    <?php
        }
      }
    } else {
      echo ' <p class="text-muted text-italic">No notifications</p>';
    }

    ?>


  </div>
</div>