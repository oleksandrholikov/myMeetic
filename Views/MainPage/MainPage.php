<?php
    require_once('../../Controller/MainPageController.php');
    // $user = new MainPageController();
    // echo $user->getId();
    session_start();
    $id =$_SESSION["id"];
    $user = new MainPageController($id);
    $user->getInfo();
    $user->getHobbies();
    $info=$user->getUser();
    $hobbies=$user->getUserHobbies();
    $userList;
    // print_r($hobbies);  
      
    if(isset($_POST['logOut'])){
        $user->logOut();
        // echo"logOut";
    }
    if(isset($_POST['newEmail'])){
        $user->changEmail($_POST['newEmail']);
    }
    if(isset($_POST['oldPassword']) && isset($_POST['newPassword'])){
        $user->changPassWord($_POST['oldPassword'], $_POST['newPassword']);
    }
    if(isset($_POST['hobby'])){
        $user->addNewHobby($_POST['hobby']);                       
    }
    // print_r($_GET);
    if(isset($_POST['search'])){
        $filter = [
            'male' => isset($_POST['male'])? $_POST['male']:'',
            'female' => isset($_POST['female']) ? $_POST['female']:'',
            'minAge' => isset($_POST['minAge']) ? $_POST['minAge']: '',
            'maxAge' => isset($_POST['maxAge']) ? $_POST['maxAge']: '',
            'city' => strlen($_POST['city'][0])!==0 ? explode(",", $_POST['city']) : "",
            'hobby' => strlen($_POST['searchHobby'][0])!==0 ? explode(",", $_POST['searchHobby']) : ""
        ];
        $user->searchUserController($filter);
        $userList=$user->getUserList();
    }
    // print_r($userList);
    // print_r($info);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/normallise.css">
    <link rel="stylesheet" href="./MainPage.css">
    <title>MAIN_PAGE</title>
</head>
<body>
    <header>
    </header>
    <main>
    <section class="main-information section">
        <div class='information-photo' id="information-photo" data-gender="<?php echo $info['gender'];?>">            
        </div>
        <div class="information-body">
            <ul class="user-info">
                <li class="user-info-item"><span class="user-info-title">First Name: </span><span class="user-info-text"><?php echo $info['firstname'];?></span></li>
                <li class="user-info-item"><span class="user-info-title">Last Name: </span><span class="user-info-text"><?php echo $info['lastname'];?></span></li>
                <li class="user-info-item"><span class="user-info-title">BirthDate: </span><span class="user-info-text"><?php echo $info['birthdate'];?></span></li>
                <li class="user-info-item"><span class="user-info-title">Gender: </span><span class="user-info-text"><?php echo $info['gender'];?></span></li>
                <li class="user-info-item"><span class="user-info-title">City: </span><span class="user-info-text"><?php echo $info['city'];?></span></li>                
            </ul>
        </div>
        <div class="information-hobby">
            <h3>My Hobbies</h3>
            <ul class="hobby-list" id="hobby-list">
                <?php foreach($hobbies as $v):?>
                    <li class="hobby-item"><?php echo $v; ?></li>
                <?php endforeach;?>                
            </ul>
            <div class="hobbu--menu-conrtol">
                <form action="" method="POST" class="hobbu-menu-conrtol">
                    <button type="submit" class="button add-hobby-button" id="add-hobby-button" name="add-hobby">Add</button>
                </form>
            </div>
        </div>
        <div class="buttons--control">
            <form method="post" class="buttons-control">
                <button class="button" id="buttonLogOut" name="logOut">LogOut</button>
                <button class="button" id="buttonSetting" name="setting">Setting</button>
                <button class="button" id="buttonChats" name="chats">Chats</button>
                <button class="button" id="buttonLikes" name="likes">Likes</button>
            </form>
        </div>
    </section>
    <section class = "search-filter section">
        <h2>FILTERS FOR SEARCHING</h2>
        <form action="" method="POST" class="search-menu">
                    <input type="text" class="display-hidden" name='search' value="1">
               <fieldset class="search-item search-gender">
                    <legend>Gender</legend>
                    <input type="checkbox" name="male" id="male" class="searchGender gender-male display-hidden" value="2">
                    <label for="male">Male</label>
                    <input type="checkbox" name="female" id="female" class="searchGender gender-female  display-hidden" value="1">
                    <label for="female">Female</label>
               </fieldset>
                <fieldset class="search-item search-age">
                    <legend>Age</legend>
                    <input type="number" name="minAge" placeholder="min" id="minAge" min="18" max="99" >
                    <span>-</span>
                    <input type="number" name="maxAge" placeholder="max" id="maxAge" min="18" max="99">
                </fieldset>
                <fieldset class="search-item search-city tooltip">
                <legend>City</legend>
                    <input type="text" name="city" id="searchCity" placeholder="City" >
                </fieldset>
                <fieldset class="search-item tooltip">
                <legend>Hobby</legend>
                <input type="text" name="searchHobby" id="seaechHobby" placeholder="Hobby">
                </fieldset>
                <button type="submit" id="filter-usres">Filter</button>    
            </form>
    </section>
    <section class = "search-resalt section display-hidden" data-userList="<?= htmlspecialchars(json_encode($userList)) ?>" id="search-resalt">
        <h2>New People</h2>
        <div class="resalt-body">
            <div class="previos-person change-person " id="previos-person"></div>
            <div class="resalt-item backgroundImage" id="resalt-item"></div>
            <div class="next-person change-person " id="next-person"></div>
        </div>
    </section>
    </main>
    <div class="background-menu" id="backgroundMenu"></div>
    <div class="setting-menu display-hidden hidden-menu" id="settimgMenu">
        <h3>Setting</h3>
        <button type="button" class="closs-menu" id="clossSettingMenu"></button>
        <h4>Change Email</h4>
        <form action="" method="post" class="changeMail">
            <input type="email" name="newEmail" placeholder="NewEmail">
            <button type="submit" id="changeEmail">Change Email</button>
        </form>
        <h4>Change Password</h4>
        <form action="" method="post" class="changePassword">
            <input type="password" name="oldPassword" id="oldPassword" placeholder="Old Password">
            <input type="password" name="newPassword" id="newPasword" placeholder = "New Password">
            <input type="password" id="ConfirmPasword" placeholder = "CONFIRM New Password">
            <button type="submit" id="changePassword" class="changePasswoed">Change PassWord</button>
        </form>
    </div>
    <div class="add-hobby display-hidden hidden-menu" id="addHobby">
        <h3>Add HOBBIES</h3>
        <button type="button" class="closs-menu" id="clossHobbyMenu"></button>
        <form action="" method="post">
            <input type="text" name="hobby" id="inputHobby" placeholder="Add hobby">
            <button type="submit" id="buttonAddHobby">Add</button>
        </form>
    </div>
    <div class="likeUser display-hidden hidden-menu" id="likeUser">
        <h3>Like User</h3>
        <button type="button" class="closs-menu" id="clossLikeMenu"></button>
        <ul class="like-user-list" id="likeUserLIST"></ul>
    </div>
    <footer class="section">
    <div class="footer-copyright">
                ©    <a href="#">Have a nice meeting | </a><a href="#">  find your love</a>                 
              </div>
    </footer>
    <script src="../../script/MainPage.js"></script>
</body>
</html>