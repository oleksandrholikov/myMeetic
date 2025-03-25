<?php
// echo "SetUpModels1";
require('../../Confing/Database.php');
// echo "SetUpModels";
class SetUpModels{
    private $conn;
    private $table = 'user';
    private $user_gender = 'user_gender';
    
    public function __construct($dbconn){
        $this-> conn = $dbconn;
    }
    public function checkUserEmail($email){
        $sql_email = "SELECT id FROM user WHERE email = :email";
        $stmt = $this->conn->prepare($sql_email);
        $stmt -> execute([
            'email'=>$email
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r("Res" . $res['id']);
        return $res['id'];
    }

    public function createUser($firstname, $lastname, $birthdate, $address, $zipcode, $city,$country, $email, $password, $gender){
        if($this->checkUserEmail($email) !== null){
            return false;

        }else{
            $sql = "INSERT INTO {$this->table}(firstname, lastname, birthdate,address,zipcode,city,country,email,password)
                    VALUE(:firstname, :lastname, :birthdate,:address,:zipcode,:city,:country,:email,MD5(:password))";
            $stmt = $this->conn->prepare($sql);
            // $stmt->bindParam(':firstname', $firstname);
            // $stmt->bindParam(':lastname', $lastname );
            // $stmt->bindParam(':birthdate', $birthdate);
            // $stmt->bindParam(':address', $address );
            // $stmt->bindParam(':zipcode', $zipcode);
            // $stmt->bindParam(':city', $city);
            // $stmt->bindParam(':country', $country);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':password', $password);
            
            // return $stmt->execute();
            $stmt->execute([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'birthdate' => $birthdate,
                'address' => $address,
                'zipcode' => $zipcode,
                'city' => $city,
                'country' => $country,
                'email' => $email,
                'password' => $password
            ]);
            $sql_gender = "INSERT INTO {$this->user_gender}(id_user, id_gender)
                    VALUE((SELECT user.id FROM user WHERE user.email = :email), :gender)";
            $stmt = $this->conn->prepare($sql_gender);
            $stmt->execute([
                'email'=>$email,
                'gender'=>$gender
            ]);
            $sql_log_status = "INSERT INTO user_log (id_user, id_log)
                        VALUES((SELECT user.id FROM user WHERE user.email = :email), '2')";
            // echo print_r($stmt);
            $stmt=$this->conn->prepare($sql_log_status);
            $stmt->execute([
                'email'=>$email
                
            ]);
            return $stmt;
        }


        
    }

}
// SetUpModels::createUser();
