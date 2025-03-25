<?php
require_once('../../Models/MainPageModels.php');
require_once('../../Confing/Database.php');

    
class MainPageController{
    private $dbconn;
    private $user;
    private $userId;
    private $mainModels;
    private $userHobbies;
    private $usersList;
    // public $userLogIn;
    public function __construct($id){
        $this->userId = $id;
        $database = new DataBaseConfing();
        $this ->dbconn = $database-> DataBaseConnection();
        $this->mainModels = new MainPageModels($this->dbconn);
    }

    public function setUser($res){
        $this->user=$res;
    }

    public function getUser(){
        // print_r($this->user);
        return $this->user;
    }
    public function setUserHobbies($res){
        $this->userHobbies=$res;
    }
    public function getUserHobbies(){
        return $this->userHobbies;
    }
    public function getUserList(){
        return $this->usersList;
    }
    public function setUserList($result){
        $this->usersList=$result;
    } 
    // public function getId(){
    //     return ($this->userId);
    // }
    public function getInfo(){
        $res= $this->mainModels->getInformation($this->userId);
        $this->setUser($res);      
    }

    
    public function logOut(){
        if($this->mainModels->setLogOutModul($this->userId)){
            echo ("<script>            
            window.location.href='../../index.php';</script>");
            //  alert('LOG OUT is Done');
        }
    }
    public function changEmail($newEmail){
        $errors=[];
        $email = $newEmail;
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "You wrote wrong Email";
        }
        if(empty($errors)){
            if($this->mainModels->upDateEmail($email, $this->userId)){
                echo(
                    "<script>
                    alert('Email was changed!');
                    </script>"
                );
            }else{
                echo(
                    "<script>
                    alert('Email wasnt changed! Maybe this emais is alredy exist!');
                    </script>"
                );
            };
        };
        
    }
    
    public function changPassWord($oldPass, $newPass){
        if($this->mainModels->changePass($oldPass, $newPass, $this->userId)){
            echo(
                "<script>
                alert('Password was changed!');
                </script>"
            );
        }else{
            echo(
                "<script>
                alert('Password wasnt changed! Maybe you wrote wrong oldPassWord!');
                </script>"
            );
        };
    }

    public function getHobbies(){
        $hobbies = $this->mainModels->getHobbies($this->userId);
        $this->setUserHobbies($hobbies);
    }

    public function addNewHobby($newHobby){
        if($this->mainModels->addNewHobbyModel($newHobby, $this->userId)){
            echo(
                "<script>
                alert('New Hobby was added!');
                location.reload(); 
                </script>"
            ); 
            unset($_POST['hobby']);           
        }else{
            echo(
                "<script>
                
                </script>"
            );
        }
        unset($_POST['hobby']);
    }
    
    public function searchUserController($filter){
        $empty = "true";
        foreach($filter as $value){
            if(!empty($value)){
                $empty="false";
            }
        };
        if(!empty($empty)){
            $result = $this->mainModels->searchUserModels($filter, $this->userId);
            $this->setUserList($result);
            // echo("
            // <script>
            //     document.querySelector('#search-resalt').
            // </script>
            // ")
        }
        // echo("empty: " . $empty);
        // print_r($filter);
    }
}


?>