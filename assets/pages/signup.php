
<body>
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form method="post" action="assets/php/actions.php?signup">
                <div class="d-flex justify-content-center">

                    <img class="mb-4" src="assets/images/pictogram.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Create new account</h1> 
                <div class="d-flex">
                    <div class="form-floating mt-1 col-6 ">
                        <input type="text" name="first_name" class="form-control rounded-0" value="<?=showFormData('first_name')?>" placeholder="First Name">
                        <label for="floatingInput">first name</label>
                    </div>
                   
                    <div class="form-floating mt-1 col-6">
                        <input type="text" name="last_name" class="form-control rounded-0" value="<?=showFormData('last_name')?>" placeholder="Last Name">
                        <label for="floatingInput">last name</label>
                    </div>
                </div>
                <?=showError('first_name')?>
                <?=showError('last_name')?>
                <div class="d-flex gap-3 my-3">
                    <div class="form-check">
                        <input class="form-check-input"  type="radio" name="gender" id="exampleRadios1"
                            value="0" <?=isset($_SESSION['formdata'])==0?'':'checked'?> <?=showFormData('gender')==0? 'checked': ''?>>
                        <label class="form-check-label" for="exampleRadios1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                            value="1" <?=showFormData('gender')==1? 'checked': ''?>>
                        <label class="form-check-label" for="exampleRadios3">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                            value="2" <?=showFormData('gender')==2? 'checked': ''?>>
                        <label class="form-check-label" for="exampleRadios2">
                            Other
                        </label>
                    </div>
                </div>
                <div class="form-floating mt-1">
                    <input type="email" name="email" class="form-control rounded-0" value="<?=showFormData('email')?>" placeholder="Email">
                    <label for="floatingInput">Email</label>
                </div>
                 <?=showError('email')?>
                <div class="form-floating mt-1">
                    <input type="text" name="username" class="form-control rounded-0" value="<?=showFormData('username')?>" placeholder="username">
                    <label for="floatingInput">username</label>
                </div>
                 <?=showError('username')?>
                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">password</label>
                </div>
                 <?=showError('password')?>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Sign Up</button>
                    <a href="?login" class="text-decoration-none">Already have an account ?</a>


                </div>

            </form>
        </div>
    </div>


