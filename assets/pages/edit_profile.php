<?php global $user;



?>


<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <form method="POST" action="assets/php/actions.php?updateprofile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">


            </div>
            <h1 class="h5 mb-3 fw-normal">Edit Profile</h1>
            <div class="form-floating mt-1 col-6">
                <img src="assets/images/profile/<?= $user['profile_pic'] ?>" class="img-thumbnail my-3" style="height:150px;" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" type="file" name="profile_pic" id="formFile">
                </div>
            </div>
            <?php
            if (isset($_GET['success'])) {
                ?>
                <div class="alert alert-success" role="alert">
                    <p>Profile updated.</p>
                    </div>
                <?php
                header('location:?edit_profile');
            }
            ?>
            <?= showError('profile_pic') ?>
            <div class="d-flex">
                <div class="form-floating mt-1 col-6 ">
                    <input type="text" name="first_name" value="<?= $user['first_name'] ?>" class="form-control rounded-0">
                    <label for="floatingInput">first name</label>
                </div>
                <div class="form-floating mt-1 col-6">
                    <input type="text" name="last_name" value="<?= $user['last_name'] ?>" class="form-control rounded-0">
                    <label for="floatingInput">last name</label>
                </div>
            </div>
            <?= showError('first_name') ?>
            <?= showError('last_name') ?>
            <div class="d-flex gap-3 my-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1"
                        value="0" <?= $user['gender'] == 0 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                        value="1" <?= $user['gender'] == 1 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios3">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                        value="2" <?= $user['gender'] == 2 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios2">
                        Other
                    </label>
                </div>
            </div>
            <div class="form-floating mt-1">
                <input value="<?= $user['email'] ?>" name="email" type="email" class="form-control rounded-0" placeholder="username/email">
                <label for="floatingInput">email</label>
            </div>
            <?= showError('email') ?>
            <div class="form-floating mt-1">
                <input value="<?= $user['username'] ?>" name="username" type="text" class="form-control rounded-0" placeholder="username/email">
                <label for="floatingInput">username</label>
            </div>
            <?= showError('username') ?>
            <div class="form-floating mt-1">
                <input type="password" name=password class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">New Password</label>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>



            </div>

        </form>
    </div>

</div>