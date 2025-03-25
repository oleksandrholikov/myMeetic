<?php
require_once('../../Confing/Database.php');
class MainPageModels{
    private $conn;

    public function __construct($dbconn){
        $this ->conn = $dbconn;
    }

    public function getInformation($id_user){
        $sql_user_info = "SELECT user.firstname AS 'firstname', user.lastname AS 'lastname',  user.birthdate AS 'birthdate', user.city AS 'city', log_status.name AS 'status', gender.name AS 'gender' 
        FROM user 
        LEFT JOIN user_gender ON user.id=user_gender.id_user 
        LEFT JOIN gender ON user_gender.id_gender=gender.id 
        LEFT JOIN user_log ON user.id=user_log.id_user 
        LEFT JOIN log_status ON user_log.id_log=log_status.id 
        WHERE user.id=:id_user ";
        $stmt = $this->conn->prepare($sql_user_info);
        $stmt ->execute(['id_user'=>$id_user]);
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($res);
        return $res;
    }

    public function setLogOutModul($id_user){
        $sql_log_off= "UPDATE user_log SET id_log = '2' 
                        WHERE user_log.id_user = :id_user";
        $stmt=$this->conn->prepare($sql_log_off);
        return $stmt->execute(['id_user'=>$id_user]);
        
    }

    public function upDateEmail($email, $id_user){
        $sql_check_email = "SELECT id FROM user WHERE email=:email";
        $stmt=$this->conn->prepare($sql_check_email);
        $stmt->execute(['email'=>$email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($res);
        if($res['id'] !== null){
            // echo("FALSE");
            return false;
        }else{
            $sql_upDate_email= "UPDATE user SET email=:email WHERE id=:id_user";
            $stmt=$this->conn->prepare($sql_upDate_email);
            $resa = $stmt->execute([
                'email'=>$email,
                'id_user'=> $id_user
            ]);
            // print_r("resa:  " . $resa);
            return $resa;
        }
    }

    public function changePass($oldPass, $newPass, $id_user){
        $sql_check_oldPass = "SELECT password FROM user WHERE id=:id_user";
        $stmt=$this->conn->prepare($sql_check_oldPass);
        $stmt->execute([
            'id_user'=>$id_user
        ]);
        $pass = $stmt->fetch(PDO::FETCH_ASSOC);
        if($pass['password']==md5($oldPass)){
            $sql_upDate_pass = "UPDATE user SET password=MD5(:newPass) WHERE user.id=:id_user";
            $stmt=$this->conn->prepare($sql_upDate_pass);
            $resalt = $stmt->execute([
                'newPass'=>$newPass,
                'id_user'=>$id_user
            ]);
            return $resalt;
        }
    }

    public function checkUserHobbies($newHobby, $idUser){
        $sql_check_user_hobby="SELECT id_user FROM user_loisir 
                                WHERE id_loisir = (SELECT id FROM loisir WHERE name = LOWER(:newHobby))";
        $stmt=$this->conn->prepare($sql_check_user_hobby);
        $stmt->execute([
            'newHobby'=>$newHobby
        ]);
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        $exiteHobby = false;
        foreach($res as $k =>$v){
            if($v['id_user']==$idUser){
                $exiteHobby =true;
            }
        }
        return $exiteHobby;
    }

    public function getHobbies($id_user){
        $sql_get_hobbies = "SELECT loisir.name AS 'hobbies' FROM loisir 
                            JOIN user_loisir ON loisir.id=user_loisir.id_loisir 
                            WHERE user_loisir.id_user = :id_user";
        $stmt=$this->conn->prepare($sql_get_hobbies);
        $stmt->execute([
            'id_user'=>$id_user
        ]);
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        $hobbies=[];
        foreach($res as $k=>$v){
            array_push($hobbies, $v['hobbies']);            
        }
        // print_r($hobbies);
        return $hobbies;
    }


    public function addNewHobbyModel($newHobby, $id_user){
        $sql_check_hobby = "SELECT id  FROM loisir WHERE name=LOWER(:newHobby)";
        $stmt=$this->conn->prepare($sql_check_hobby);
        $stmt->execute([
            'newHobby'=>$newHobby
        ]);
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        $id_hobby = $res['id'];
        if($id_hobby == null){
            $sql_create_new_hobby = "INSERT INTO loisir (name) 
                                        VALUE(LOWER(:newHobby))";
            $stmt=$this->conn->prepare($sql_create_new_hobby);
            $stmt->execute([
                'newHobby'=> $newHobby
            ]);
        }
        $exist=$this->checkUserHobbies($newHobby, $id_user);
        if($exist){
            return false;
        }else{
            $sql_add_hobby_user="INSERT INTO user_loisir(id_user, id_loisir)
                                        VALUE(:id_user, (SELECT id FROM loisir WHERE name = LOWER(:newHobby)))";
             $stmt=$this->conn->prepare($sql_add_hobby_user);
             return $stmt->execute([
                'id_user'=>$id_user,
                'newHobby'=>$newHobby
             ]);
        }
                                
    } 
    
    public function searchUserModels($filter, $id_user){
        $sql_search_users="SELECT user.firstname AS 'firstname', user.lastname AS 'lastname',  user.birthdate AS 'birthdate', user.city AS 'city',GROUP_CONCAT(DISTINCT gender.name) AS 'gender', GROUP_CONCAT(DISTINCT loisir.name) AS 'hobbies', GROUP_CONCAT(DISTINCT user_log.id_log) AS 'status'  
                            FROM user
                            LEFT JOIN user_gender ON user.id=user_gender.id_user 
                            LEFT JOIN gender ON user_gender.id_gender=gender.id
                            LEFT JOIN user_loisir ON user.id=user_loisir.id_user
                            LEFT JOIN loisir ON user_loisir.id_loisir=loisir.id
                            LEFT JOIN user_log ON user.id = user_log.id_user
                            WHERE 1=1";
        $parametrs = [];                    
        if(!empty($filter['male']) && empty($filter['female'])){
            $sql_search_users .= " AND user_gender.id_gender = :male";
            $parametrs['male'] = '2';
        }
        if(empty($filter['male']) && !empty($filter['female'])){
            $sql_search_users .= " AND user_gender.id_gender = :female";
            $parametrs['female'] = '1';
        }
        if(!empty($filter['male']) && !empty($filter['female'])){
            $sql_search_users .=" AND (user_gender.id_gender = :female OR user_gender.id_gender = :male)";
            $parametrs['male'] = '2';
            $parametrs['female'] = '1';
        }
        if(!empty($filter['minAge'])){
            $sql_search_users .=" AND (TIMESTAMPDIFF(YEAR, user.birthdate, CURDATE())) >= :minAge";
            $parametrs['minAge'] = $filter['minAge'];
        }
        if(!empty($filter['maxAge'])){
            $sql_search_users .=" AND (TIMESTAMPDIFF(YEAR, user.birthdate, CURDATE())) =< :minAge";
            $parametrs['maxAge'] = $filter['maxAge'];
        }

        if (!empty($filter['city'])){
            
            $cityConditions = [];
            
            
            foreach ($filter['city'] as $index => $city) {
                $cityConditions[] = "user.city = :city" . $index;
                $parametrs['city' . $index] = $city;  
            }
        
            
            if (!empty($cityConditions)) {
                $sql_search_users .= " AND (" . implode(" OR ", $cityConditions) . ")";
            }
        }
        
        if (!empty($filter['hobby'])){
            
            $hobbyConditions = [];
            
            
            foreach ($filter['hobby'] as $index => $hobby) {
                $hobbyConditions[] = "loisir.name = :hobby" . $index;
                $parametrs['hobby' . $index] = strtolower($hobby);
            }
        
            
            if (!empty($hobbyConditions)) {
                $sql_search_users .= " AND (" . implode(" OR ", $hobbyConditions) . ")";
            }
        }

        // if(!empty($filter['city'])){
        //     $cities = rtrim(str_repeat('?, ', count($filter['city'])),', ');
        //     $sql_search_users .= " AND user.city IN ($cities)";
        //     $parametrs = array_merge($parametrs, $filter['city']);
        // }
        
        // if(!empty($filter['hobby'])){
        //     $hobbiesToLOWER = array_map('strtolower',$filter['hobby'] );
        //     $hobbies = rtrim(str_repeat('?, ', count($hobbiesToLOWER)),', ');
        //     $sql_search_users .= " AND loisir.name IN ($hobbies)";
        //     $parametrs = array_merge($parametrs, $hobbiesToLOWER);
        // }
        $sql_search_users .= " AND user.id <> :id_user GROUP BY user.id";
        // echo($sql_search_users);
        $parametrs['id_user'] = $id_user;
        // print_r($parametrs);
        $stmt = $this->conn->prepare($sql_search_users);
        $stmt ->execute($parametrs);
        $users_resalt = $stmt->fetchALL(PDO::FETCH_ASSOC);
        // print_r($users_resalt);
        return $users_resalt;
    }
}
?>