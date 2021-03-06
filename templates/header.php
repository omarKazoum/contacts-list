<?php
require_once 'include/Constants.php';
require_once 'include/AccountManager.php';
$am=AccountManager::getInstance()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/main.css">
    <title> <?= $page_title?></title>
</head>
<body>
<header>
    <nav class="navbar navbar-dark navbar-expand-md bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                Contacts list
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <ul class="navbar-nav collapse navbar-collapse flex-md-row-reverse" id="navbarNavAltMarkup">
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
