<?php
require_once 'autoloader.php';
$am=AccountManager::getInstance();
$am->redirectToIndexIfNotLoggedIn();
$page_title='Contacts list';
require_once "templates/header.php" ?>
<main class="container gray-bg">
    <div class="row py-2">
                <div class=" col-12 col-lg-3 border border-light border-1 p-0">
                    <div class="contacts-list panel no-padding">
                        <h2 class=" text-align-center w-100 panel--heading m-0">
                            <span class="ps-1">
                                Contacts
                            </span>
                        </h2>
                        <div class="no-contacts-msg fw-light">
                                No contacts.
                        </div>
                        <div class="contacts-table">
                            <tbody>

                            </tbody>
                        </div>
                    </div>
                </div>
                <div id="form-con" class="col-12 col-lg-9 ">
                    <div class="panel">
                        <div class=" col-12 d-flex justify-content-between w-100 panel--heading">
                            <h2 class="page-header text-align-center  ps-2 ps-lg-2">
                                Add a contact
                            </h2>
                            <button class="btn btn-primary add-contact-btn me-3">
                                Add contact
                            </button>

                        </div>
                        <form class="needs-validation container-fluid" id="contacts-form"
                        data-action="<?= Constants::ACTION_TYPE_ADD_CONTACT?>">
                            <input type="hidden" name="id">
                            <div class="row mt-2">
                                <div class="form-group col-6">
                                    <label for="<?=Constants::Contacts_Col_Name?>" class="form-label">Name</label>
                                    <input
                                            id="<?=Constants::Contacts_Col_Name?>"
                                            type="text"
                                            class="form-control"
                                            data-validate='1'
                                            data-validate-pattern="^(\w{3,} ?)+$"
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
                                            data-validate='1'
                                            data-validate-pattern="^\+{0,1}((212)|(0[6589]))\d{8}$"
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
                                            data-validate='1'
                                            data-validate-pattern="^[a-zA-Z\-\d]+@[a-zA-Z\-\d]+(\.[a-zA-Z\-\d]+)+$"
                                            data-validate-message="The email is invalid"
                                            placeholder="example@domain.com"
                                            name="<?=Constants::Contacts_Col_Email?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="<?=Constants::Contacts_Col_Address?>" class="form-label">Adress</label>
                                    <input
                                        id="<?=Constants::Contacts_Col_Address?>"
                                        type="text"
                                        class="form-control"
                                        data-validate='1'
                                        data-validate-pattern=".*"
                                        data-validate-message=""
                                        placeholder="Optional: your contact adress"
                                        name="<?=Constants::Contacts_Col_Address?>">
                                </div>
                            </div>
                            <div class="row my-2">
                                <button class="btn btn-primary btn-save w-100" type="submit"></button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
</main>
<?php require_once "templates/footer.php" ?>
