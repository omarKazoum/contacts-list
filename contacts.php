<?php
$page_title='login';
require_once "templates/header.php" ?>
<main class="container-fluid">
    <div class="row">
        <div class="content col-12 col-md-6 offset-md-3">
            <h1 class="page-header text-align-center w-100">
                Authenticate
            </h1>
            <form class="">
                <div class="form-group">
                    <label for="<?=Constants::Users_Col_UserName?>" class="form-label">Username</label>
                    <input
                        id="<?=Constants::Users_Col_UserName?>"
                        type="text"
                        class="form-control"
                        data-validate-pattern="\w{3,}"
                        data-validate-message="Please fill in a valid user name"
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
                        data-validate-pattern=".{8,}"
                        data-validate-message="Passwords do not match"
                        data-validate="1"
                        name="<?=Constants::Users_Password?>">
                </div>
                <button class="btn btn-primary w-100 my-2" type="submit">
                    Login
                </button>
                <p class="m-1 text-below-form">
                    No account? <a href="signup.php" class="link">Sign up</a> here.
                </p>

            </form>

        </div>
    </div>
</main>
<?php require_once "templates/footer.php" ?>
