<?php
require_once 'include/Constants.php';
require_once 'include/AccountManager.php';
$am=AccountManager::getInstance()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/css/bootstrap.css" rel="stylesheet" >
    <link rel="stylesheet" href="/assets/css/main.css">
    <title> <?= $page_title?></title>
</head>
<body>
<header>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
        <a class="navbar-brand" href="/">
            Contacts list
        </a>
        <ul class="navbar-nav">
            <?php if(!$am->isLoggedIn()){?>
            ?>
               <li class="nav-item">
                   <a href="login.php" class="nav-link">Login</a>
               </li>
            <?php }else{?>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link"><?= $am->getLoggedInUser()->getUserName()?></a>
                </li>
                <li class="nav-item">
                    <a href="contacts.php" class="nav-link">Contacts</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Log out</a>
                </li>

            <?php }?>
        </ul>
        </div>
    </nav>
</header>
