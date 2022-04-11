<?php
$page_title='Sign up';
require_once "templates/header.php" ?>
<main class="container-fluid">
    <div class="row">
        <div class="content col-12 col-md-6 offset-md-3">
            <h1 class="page-header text-align-center w-100">
                Authenticate
            </h1>
            <form class="needs-validation" id="signupForm"
                  data-validate-callback="">
                <div class="form-group">
                    <label for="<?=Constants::Users_Col_UserName?>" class="form-label">Username</label>
                    <input
                        id="<?=Constants::Users_Col_UserName?>"
                        type="text"
                        class="form-control"
                        data-validate-pattern="^([a-zA-Z0-9]{3,}\s?)+$"
                        data-validate-message="the username should contain only numbers and letters."
                        data-validate="1"
                        placeholder="Username"
                        name="<?=Constants::Users_Col_UserName?>">
                </div>
                <div class="form-group">
                    <label for="<?=Constants::Users_Password?>" class="form-label">Password</label>
                    <input
                        placeholder="Password"
                        id="<?=Constants::Users_Password?>"
                        type="password"
                        class="form-control"
                        data-validate-pattern="^.{6,}$"
                        data-validate-message="Password must be at least 6 characters long"
                        data-validate="1"
                        name="<?=Constants::Users_Password?>">
                </div>
                <div class="form-group">
                    <label for="<?=Constants::Users_Password2?>" class="form-label">Password verify</label>
                    <input
                        placeholder="Password verify"
                        id="<?=Constants::Users_Password2?>"
                        type="password"
                        class="form-control"
                        data-validate-match="<?=Constants::Users_Password?>"
                        data-validate-message="Passwords do not match"
                        data-validate="1"
                        name="<?=Constants::Users_Password2?>">
                </div>
                <button class="btn btn-primary w-100 my-2" type="submit">
                    Sign up
                </button>
                <p class="m-1 text-below-form">
                    Already have an account? <a href="login.php" class="link">Login</a> here.
                </p>
            </form>
        </div>
    </div>
</main>
<?php require_once "templates/footer.php" ?>
