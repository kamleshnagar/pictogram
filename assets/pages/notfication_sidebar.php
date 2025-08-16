<div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="notification_sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="notification_sidebarLabel">Notifications</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>



  <hr>
  <div class="offcanvas-body">
    <?php
    $notifications = filterNotifcation();
    if (count($notifications) > 0) {

      foreach ($notifications as $notification) {
        if (!empty($notification)) {
          $nuser = getUser($notification['follower_id']);
       }
        if (!empty($notification) && $notification['action'] == 0) {

    ?>
          <div>
            <p><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> added a new post <?=$notification['post_id']?></p>
          </div>
        <?php
        } elseif (!empty($notification) && $notification['action'] == 1) {

        ?>
          <div>
            <p><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> like your post</p>
          </div>
        <?php
        } elseif (!empty($notification) && $notification['action'] == 2) {

        ?>
          <div>
            <p><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> commented on your post</p>
          </div>
        <?php
        } elseif (!empty($notification) && $notification['action'] == 3) {

        ?>
          <div>
            <p><?= $nuser['first_name'] . ' ' . $nuser['last_name'] ?> started Following you</p>
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