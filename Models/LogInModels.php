<?php
require_once('../../Confing/Database.php');
class LogInModels{
    private $conn;
    public $idUserLogIn;

    public function __construct($dbconn){
        $this ->conn = $dbconn;
    }
    // public function setIdUserLogIn($idUserLogIn){
    //     $this->idUserLogIn=$idUserLogIn;
    // }
    public function getIdUserLogIn(){
        return $this->idUserLogIn;
    }

    public function logInUserModels($email, $password){
        $sql_mail = "SELECT id FROM user WHERE email = :email";
        $stmt = $this->conn->prepare($sql_mail);
        $stmt -> execute([
            'email'=>$email
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res['id'] == null){
            return false;
        }
        $sql_check_password = "SELECT id FROM user WHERE email = :email AND password = MD5(:password)";
        $stmt = $this->conn->prepare($sql_check_password);
        $stmt -> execute([
            'email'=>$email,
            'password'=>$password
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res['id'] !== null){
            $sql_log = "UPDATE user_log SET id_log = '1' WHERE user_log.id_user = :id_user";
            $stmt=$this->conn->prepare($sql_log);
            $stmt -> execute([
                'id_user' => $res['id'] 
            ]);           
            $this->idUserLogIn = $res['id'];
            return true;
            
        }else {
            return false;
        }
    }
}
?>