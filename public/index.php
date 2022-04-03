<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>Contacts list</title>
</head>
<body>
<header>
    <h1 id="site-title">
        Contacts list
    </h1>
    <a href="Youcode/workshoops/Application de gestion des contacts/login.php" class="link">Login</a>
</header>
<main class="containner mx-1">
    <div class="jombotron">
        <h1>Hello</h1>
        <p>
            <a href="signup.php" class="link">Sign up</a>
            to start creating your contacts list.
        </p>
        <p>
            Already have an account? <a href="Youcode/workshoops/Application de gestion des contacts/login.php" class="link">Login here</a>.
        </p>
    </div>
</main>
<h1 class="bg-success">
<?php
//$name="id";
//$$name=13;
//echo $id;
//include "test.php";
print_r($_SERVER['REQUEST_URI']);

?>
</h1>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>