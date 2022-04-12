<?php
require_once 'autoloader.php';
AccountManager::getInstance()->redirectToContactsListIfLoggedIn();
$page_title="Contacts list";
require_once "templates/header.php"?>
<main class="p-5 mb-4 bg-light rounded-3">

        <h1>Hello</h1>
        <p>
            <a href="signup.php" class="link">Sign up</a>
            to start creating your contacts list.
        </p>
        <p>
            Already have an account? <a href="/login.php" class="link">Login here</a>.
        </p>
</main>
<?php require_once "templates/footer.php"?>