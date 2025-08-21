<?php global $user; ?>
<?php $name = $user['first_name'] . ' ' . $user['last_name']; ?>
<?php $username = '@' . $user['username'];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white border">
    <div class="container col-9 d-flex justify-content-between">
        <div class="d-flex justify-content-between col-8">
            <a class="navbar-brand" href="?home">
                <img src="assets/images/pictogram.png" alt="" height="28">
            </a>
            <form class="d-flex flex-column">
                <input class="form-control me-2" id="searchBox" type="search" placeholder="looking for someone.."
                    aria-label="Search" autocomplete="off">
                <div id="searchResults" class="searchResults list-group" style="width:220px;"></div>
            </form>
        </div>
        <ul class="navbar-nav  mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link text-dark" href="?home"><i class="bi bi-house-door-fill"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#addpost" href="#"><i class="bi bi-plus-square-fill"></i></a>
            </li>
            <li class="nav-item">
                <div class="position-relative">
                    <a class="nav-link text-dark" id="notifications" data-user-id="<?= $user['id'] ?>" data-bs-toggle="offcanvas" href="#notification_sidebar" role="button" aria-controls="sidebar"><i class="bi bi-bell-fill"></i></a>
                    <?php
                    $notifications = filterNotifcation();
                    $unread = [];
                    if (!empty($notifications)) {
                        foreach ($notifications as $n) {
                            if ($n['read_status'] == 0) {
                                $unread[] = $n;
                            }
                        }
                    }

                    ?>
                    <div id="notifCount" class="rounded-circle bg-primary count_n text-center fw-bold <?= (!empty($unread)) ? '' : 'd-none' ?>">
                        <p id="notifNum"><?= (!empty($unread)) ? count($unread) : '' ?></p>
                    </div>

            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" id="messages" data-user-id="<?= $user['id'] ?>" data-bs-toggle="offcanvas" href="#messages_sidebar" role="button" aria-controls="sidebar"><i class="bi bi-chat-right-dots-fill"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/profile/<?= $user['profile_pic'] ?>" alt="" height="30" class="rounded-circle border">
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?u=<?= $user['username'] ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="?edit_profile">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="#">Account Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="assets/php/actions.php?logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<?php include('assets/pages/sidebar.php'); ?>