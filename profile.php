<?php
$page_title='Profile';
require_once "templates/header.php" ?>
<main class="container-fluid">
    <div class="row">
        <div class="content col-12 col-md-6 offset-md-3">
            <h1 class="page-header text-align-left w-100">
                Welcome,<?= /*$am->getLoggedInUser()->getUserName()*/"alex"?>!
            </h1>

            <table class="table">
                <tr>
                    <td colspan="2"><h2 class="page-header text-align-left w-100">
                            Your profile:
                        </h2>
                    </td>
                </tr>
                <tr>
                    <td ><span class="fw-bold">Username:</span></td>
                    <td ><?= /*$am->getLoggedInUser()->getUserName()*/"alex"?></td>
                </tr>
                <tr>
                    <td ><span class="fw-bold">Signup date:</span></td>
                    <td ><?=/* $am->getLoggedInUser()->getRegisterDate()*/"some other date"?></td>
                </tr>
                <tr>
                    <td ><span class="fw-bold">Last login:</span></td>
                    <td ><?= /*$am->getLastLogin()*/"some date"?></td>
                </tr>
            </table>

        </div>
    </div>
</main>
<?php require_once "templates/footer.php" ?>
