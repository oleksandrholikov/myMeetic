<?php
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/normallise.css">
    <link rel="stylesheet" href="./SetUp.css">
    <title>Log In</title>
</head>
<body>        
    <section class="setup" id="setUp">
            <h3>Create A New Account</h3>
            <form  method="POST" class="setUp-menu" action ="" id="formCreate">
                <input type="text" placeholder="First Name" name="firstname" id="firstname" value="">
                <input type="text" placeholder="Last Name" name="lastname" id="lastname" value="">
                <input type="date" placeholder="Birthdate" name="birthdate" id="birthdate" value="">
                <input type="text" placeholder="Address" name="address" id="address" value="">
                <input type="text" placeholder="Zipcode" name="zipcode" id="zipcode" value="">
                <input type="text" placeholder="City" name="city" id="city" value="">
                <input type="text" placeholder="Country" name="country" id="country" value="">
                <input type="email" placeholder="Email" name="email" id="email" value="">
                <input type="password" placeholder="Password" name="password" id="password" value="">
                <input type="password" placeholder="Confirm Password" id="CheckPassword" value="">
                <fieldset>
                    <legend>Gender</legend>
                    <div>
                        <input type="radio" id="gender_male" name="gender" value = "2" cheched>
                        <label for="gender_male"">Male</label>
                    </div>
                    <div>
                        <input type="radio" id="gender_female" name="gender" value = "1" >
                        <label for="gender_female">Female</label>
                    </div>
                </fieldset>
                <button type="submit" id="createUser">Create</button>
                <a href="../../index.php">BACK</a>
            </form>
    </section>       
<?php
    require('../../Controller/SetUpController.php');
    $controller = new SetUpControler();
    $controller->verefieUser();
?> 
<script src ="../../script/SetUp.js"></script>       
</body>
</html>
