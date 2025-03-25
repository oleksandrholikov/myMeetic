<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/normallise.css">
    <link rel="stylesheet" href="./LogIn.css">
    <title>LOG_IN</title>
</head>
<body>

    <section class="section-login">
        <h3>LOG IN</h3>
        <form action="" class="form-login" method="POST">
            <input type="text" class="input-login" placeholder="Email" name="email" >
            <input type="password" class="input-login" placeholder="Password" name="password" >
            <button type="submit" class="button button-logIn" id="button-log_in">LOG IN</button>
        </form>
        <a href="../../index.php">BACK</a>
    </section>
    <?php
    require('../../Controller/LogInController.php');
    $controller = new LogInController();
    $controller->logInUser();
    // echo $controller->getIdUser();

    ?>
</body>
</html>