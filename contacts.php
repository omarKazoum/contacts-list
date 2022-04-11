<?php
$page_title='login';
require_once "templates/header.php" ?>
<main class="container-fluid">
    <div class="row">
        <div class="content col-12 col-md-6 offset-md-3">
            <h1 class="page-header text-align-center w-100">
                Contacts
            </h1>
            <div class="contacts-list row">
                <h2 class="page-header text-align-center w-100 border-bottom border-1">
                    Contacts list
                </h2>
                <div class="no-contacts-msg fw-light">
                    No contacts.
                </div>
                <table class="table">
                    <tr>
                        <td class="fw-bold contact-name">contact name</td>
                        <td class="contact-email">contact@mail.com</td>
                        <td class="contact-phone">+212727783888</td>
                        <td class="contact-adress">some demo adress</td>
                        <td class="contact-actions d-flex flex-column">
                            <a href="#form-con" class="link edit-btn">Edit</a>
                            <a href="" class="link delete-btn">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold contact-name">contact name</td>
                        <td class="contact-email">contact@mail.com</td>
                        <td class="contact-phone">+212727783888</td>
                        <td class="contact-adress">some demo adress</td>
                        <td class="contact-actions d-flex flex-column">
                            <a href="#form-con" class="link edit-btn">Edit</a>
                            <a href="" class="link delete-btn">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold contact-name">contact name</td>
                        <td class="contact-email">contact@mail.com</td>
                        <td class="contact-phone">+212727783888</td>
                        <td class="contact-adress">some demo adress</td>
                        <td class="contact-actions d-flex flex-column">
                            <a href="#form-con" class="link edit-btn">Edit</a>
                            <a href="" class="link delete-btn">Delete</a>
                        </td>
                    </tr>

                </table>
            </div>
            <div id="form-con">
                <form class="needs-validation container-fluid">
                    <div class="row mt-2">
                        <div class="form-group col-6">
                            <label for="<?=Constants::Contacts_Col_Name?>" class="form-label">Name</label>
                            <input
                                    id="<?=Constants::Contacts_Col_Name?>"
                                    type="text"
                                    class="form-control"
                                    data-validate-pattern="^\w{3,}$"
                                    data-validate-message="Invalid he name is mandatory"
                                    placeholder="contact Name"
                                    name="<?=Constants::Contacts_Col_Name?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="<?=Constants::Contacts_Col_Phone?>" class="form-label">Phone</label>
                            <input
                                    id="<?=Constants::Contacts_Col_Phone?>"
                                    type="text"
                                    class="form-control"
                                    data-validate-pattern="^\+?(212)|[6589]\d{8}$"
                                    data-validate-message="The phone number"
                                    placeholder="contact phone number"
                                    name="<?=Constants::Contacts_Col_Phone?>">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-6">
                            <label for="<?=Constants::Contacts_Col_Email?>" class="form-label">Email</label>
                            <input
                                    id="<?=Constants::Contacts_Col_Email?>"
                                    type="text"
                                    class="form-control"
                                    data-validate-pattern="^[a-zA-Z\-]+@[a-zA-Z\-]+(\.[a-zA-Z\-]+)+$"
                                    data-validate-message="The email is invalid"
                                    placeholder="example@domain.com"
                                    name="<?=Constants::Contacts_Col_Email?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="<?=Constants::Contacts_Col_Adress?>" class="form-label">Adress</label>
                            <input
                                    id="<?=Constants::Contacts_Col_Adress?>"
                                    type="text"
                                    class="form-control"
                                    data-validate-pattern=".*"
                                    data-validate-message=""
                                    placeholder="Optional: your contact adress"
                                    name="<?=Constants::Contacts_Col_Adress?>">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>
<?php require_once "templates/footer.php" ?>
