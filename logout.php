<?php
require_once 'include/AccountManager.php';
$am=AccountManager::getInstance();
$am->logOut();
header('location:'.getUrlFor('index.php'));

