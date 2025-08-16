<div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="notification_sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="notification_sidebarLabel">Notifications</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>



  <hr>
  <div class="offcanvas-body w-100">
    <?php
    $notifications = filterNotifcation();
    if (count($notifications) > 0) {

      foreach ($notifications as $notification) {
        if (!empty($notification)) {
          $nuser = getUser($notification['follower_id']);
        }
        if (!empty($notification) && $notification['action'] == 0) {

    ?>

          <div class="d-flex justify-content-between">

            <div class="d-flex pe-2">
              <div> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
              </div></a>
              <div>&nbsp;&nbsp;</div>
              <div class="d-flex  justify-content-center align-items-center">
                <div class="d-flex gap-2 align-items-center">
                  <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                  <p class="m-0">added a new post</p>
                </div>
              </div>
            </div>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex align-items-center ">
                <span class="rounded-circle bg-primary dot" style="height:10px; width:10px"> </span>
              </div>
            <?php } ?>
          </div>
             <div class="text-end text-muted" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
          <hr>



        <?php
        } elseif (!empty($notification) && $notification['action'] == 1) {

        ?>
          <div class="d-flex justify-content-between">

            <div class="d-flex pe-2">
              <div> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
              </div></a>
              <div>&nbsp;&nbsp;</div>
              <div class="d-flex  justify-content-center align-items-center">
                <div class="d-flex gap-2 align-items-center">
                  <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                  <p class="m-0">liked your post</p>
                </div>
              </div>
            </div>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex align-items-center ">
                <span class="rounded-circle bg-primary dot" style="height:10px; width:10px"> </span>
              </div>
            <?php } ?>
          </div>
          <div class="text-end text-muted" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
          <hr>

        <?php
        } elseif (!empty($notification) && $notification['action'] == 2) {

        ?>
          <div class="d-flex justify-content-between">

            <div class="d-flex pe-2">
              <div> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
              </div></a>
              <div>&nbsp;&nbsp;</div>
              <div class="d-flex  justify-content-center align-items-center">
                <div class="d-flex gap-2 align-items-center">
                  <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                  <p class="m-0">commented on your post</p>
                </div>
              </div>
            </div>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex align-items-center ">
                <span class="rounded-circle bg-primary dot" style="height:10px; width:10px"> </span>
              </div>
            <?php } ?>
          </div>
             <div class="text-end text-muted" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
          <hr>

        <?php
        } elseif (!empty($notification) && $notification['action'] == 3) {

        ?>
          <div class="d-flex justify-content-between">

            <div class="d-flex pe-2">
              <div> <a href="?u=<?= $nuser['username'] ?>"><img src="assets/images/profile/<?= $nuser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle border">
              </div></a>
              <div>&nbsp;&nbsp;</div>
              <div class="d-flex  justify-content-center align-items-center">
                <div class="d-flex gap-2 align-items-center">
                  <h6 class="m-0"><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> </h6>
                  <p class="m-0">started following you</p>
                </div>

              </div>
            </div>
            <?php if ($notification['read_status'] == 0) { ?>
              <div class="d-flex align-items-center ">
                <span class="rounded-circle bg-primary dot" style="height:10px; width:10px"> </span>
              </div>
            <?php } ?>
          </div>
          <div class="text-end text-muted" style="font-size: 15px;"><?= timeAgo($notification['created_at']) ?></div>
          <hr>

    <?php
        }
      }
    } else {
      echo ' <p class="text-muted text-italic">No notifications</p>';
    }

    ?>


  </div>
</div>