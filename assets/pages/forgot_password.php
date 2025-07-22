<div class="login">
    <div class="col-4 bg-white border rounded p-4 shadow-sm">

        <?php
        if (isset($_SESSION['forget_code']) && !isset($_SESSION['temp_auth'])) {
            $action = 'verifycode';
        } elseif (isset($_SESSION['temp_auth']) && isset($_SESSION['temp_auth'])) {
            $action = 'changepassword';
        } else {
            $action = 'forgetpassword';
        }

        ?>
        <form method="post" action="assets/php/actions.php?<?= $action ?>">
            <div class="d-flex justify-content-center">


            </div>
            <h1 class="h5 mb-3 fw-normal">Forgot Your Password ?</h1>

            <?php
            if ($action == 'forgetpassword') {
            ?>
                <div class="form-floating">
                    <input type="email" class="form-control rounded-0" placeholder="Enter your email" name="email">
                    <label for="floatingInput">Email</label>
                </div>
                <?= showError('email'); ?>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Send Verification Code</button>
                    <a href="?login" class="text-decoration-none"><i class="bi bi-arrow-left-circle-fill"></i> Go Back To Login</a>
                </div>

            <?php
            }
            ?>
            <?php
            if ($action == 'verifycode') {
            ?>

                <p>Enter 6 Digit Code Sended to You - (<?= $_SESSION['forget_email'] ?>)</p>
                <div class="form-floating mt-1">
                    <input type="password" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">######</label>
                </div>
                <?= showError('code'); ?>
                <button class="btn btn-primary my-3" type="submit">Verify Code</button>
            <?php
            }
            ?>

            <?php
            if ($action == 'changepassword') {
            ?>
                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">new password</label>
                </div>
                 <?= showError('password'); ?>
                <button class="btn btn-primary my-3" type="submit">Change Password</button>
            <?php
            }
            ?>


            <!--  -->

            <!--  -->
            <!-- 
                    
                -->

            <!-- 
                 -->



            <!-- -->



        </form>
    </div>
</div>