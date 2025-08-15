
<div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="notification_sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="notification_sidebarLabel">Notifications</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>



  <hr>
  <div class="offcanvas-body">

    <?php
    $notifications = getNotifiaction();
    foreach($notifications as $notification)
      if($notification['user_id'] == $_SESSION['userdata']['id'] && $notification['follower_id'] != $_SESSION['userdata']['id']){
        pr($notification);
      }elseif(checkFollowStatus($notification['user_id']) && $notification['follower_id'] != $_SESSION['userdata']['id']){
        if($notification['action'] == 0 && $notification['user_id'] == $notification['follower_id'])
        pr($notification);
      }
    ?>

      <p class="text-muted text-italic">No notification</p>
    <?php
    
    ?>
  </div>
</div>