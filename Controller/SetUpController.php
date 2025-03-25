<?php
// echo"SetUpControler1\n";
require('../../Models/SetUpModels.php');
require_once('../../Confing/Database.php');
// echo"SetUpControler2\n";

// print_r($_POST);
class SetUpControler{
    // public $date = [
    //     'firstname',
    //     'lastname',
    //     'birthdate',
    //     'address',
    //     'zipcode',
    //     'city',
    //     'country',
    //     'email',
    //     'gender'
    // ];
    // public function __construct($firstname, $lastname, $birthdate, $address, $zipcode, $city, $country, $email, $gender){
    //     $this ->date['firstname'] =  $firstname;
    //     $this ->date['lastname'] =  $lastname;
    //     $this ->date['birthdate'] =  $birthdate;
    //     $this ->date['address'] =  $address;
    //     $this ->date['zipcode'] =  $zipcode;
    //     $this ->date['city'] =  $city;
    //     $this ->date['country'] =  $country;
    //     $this ->date['email'] =  $email;
    //     $this ->date['gender'] =  $gender;
    // }
   private $createUserModel;
   private $dbconn;
   
   public function __construct(){
        $database = new DataBaseConfing();
        $this ->dbconn = $database-> DataBaseConnection();
        $this->createUserModel = new SetUpModels($this->dbconn);
   }

   public function overEighteen($bdate){
    if(time()<strtotime('+18 years',strtotime($bdate))){
        return true;
    }else{
        return false;
    }
   }

   public function verefieUser(){
        $errors = [];
        $success = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $address = $_POST['address'];
            $zipcode = $_POST['zipcode'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $gender = $_POST['gender'];            
        }else{
            return;
        }
        if(empty($firstname)){
            $errors[] = "The First Name IS Obligatorily";}
        if(empty($lastname)){
            $errors[] = "The Last Name IS Obligatorily";}
        if(empty($birthdate)){
            $errors[] = "The BirthDate IS Obligatorily";}
        if($this->overEighteen($birthdate)){
            $errors[] = "You have to be over 18 years old";
        }
        if(empty($address)){
            $errors[] = "The Address Is Obligatorily";}
        if(empty($zipcode)){
            $errors[] = "The Zipcode IS Obligatorily";}
        if(empty($city)){
            $errors[] = "The City IS Obligatorily";}
        if(empty($country)){
            $errors[] = "The Country IS Obligatorily!";}
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "The email IS Obligatorily";}
        if(empty($password)){
            $errors[] = "The Password IS Obligatorily";}
        if(empty($gender)){
            $errors[] = "The Gender IS Obligatorily";}
        if(empty($errors)){
            if($this->createUserModel->createUser($firstname, $lastname, $birthdate, $address, $zipcode, $city,$country, $email, $password, $gender)){
                $success = true;
            } else {
                $errors[] = "Can't create a new user. Mayby you have been already regestrated";
            }
        } 
        
        include_once('../../Views/SetUp/SetUpResult.php');
   }

}
// print_r($_REQUEST);
// echo("<p><br> SERVER</p>");
// print_r($_SERVER);
// echo"out class";
// $new = new SetUpControler($_POST['firstname'] ,$_POST['lastname'] ,$_POST['birthdate'] ,$_POST['address'] ,$_POST['zipcode'], $_POST['city'], $_POST['country'],$_POST['email'],$_POST['gender'] );
// $new -> display();