<?php
global $user;
?>

<div class="login">

        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form>
                <div class="d-flex justify-content-center">

                    <img class="mb-4" src="assets/images/pictogram.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Hello <b> <?=$user['first_name']?>  <?=$user['last_name']?></b>, Your Account (<?=$user['email']?>) is <span class="text-danger fw-bold">Blocked</span> by Admin</h1>




                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <a class="btn btn-danger" href="assets/php/actions.php?logout">Logout</a>



                </div>

            </form>
        </div>
    </div>

