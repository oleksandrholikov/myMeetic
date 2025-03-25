<?php
require_once('../../Models/LogInModels.php');
require_once('../../Confing/Database.php');
// require_once('../../Controller/MainPageController.php');
class LogInController{
    private $isUserExist;
    private $dbconn;
    public static $idUserLogIn = 'test';

    public function __construct(){
        $database = new DataBaseConfing();
        $this ->dbconn = $database-> DataBaseConnection();
        $this->isUserExist = new LogInModels($this->dbconn);
    }    

    public function getIdUser(){
        return self::$idUserLogIn ?? "nothing";
    }

    public function logInUser(){
        $errors = [];
        $success=false;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];
        }else{
            return;
        }

        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "The email IS Obligatorily";}
        if(empty($password)){
            $errors[] = "The Password IS Obligatorily";}
        if(empty($errors)){
        if(($this->isUserExist->logInUserModels($email, $password)) != null){
            $success = true;
            self::$idUserLogIn = $this->isUserExist->getIdUserLogIn();
            session_start();
            $_SESSION["id"] = $this->isUserExist->getIdUserLogIn();
            
        }else{ $errors[] = "Can't logIn, check Your Email, or PassWord, or Create your account";
            
        }
        }    
        if($success){   
            // echo("id" . $this->getIdUser());        
             echo ("<script>
             alert('LOG in is Done');
             window.location.href='../MainPage/MainPage.php';</script>");
        }else{
            $mymessage = " ";
            function function_alert($message){
                echo"<script>alert(" . json_encode($message) . ");</script>";
            }
            foreach($errors as $error){               
                    $mymessage .= $error;        
                    $mymessage .= "\n";        
                };
                function_alert($mymessage);            
        }
        }
}

// print_r($_REQUEST);
// echo("<p><br>/p>");
// print_r($_SESSION);
// echo("<p><br></p>");
// print_r($_SERVER);
?>