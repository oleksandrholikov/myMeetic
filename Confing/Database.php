<?php
class DataBaseConfing{
    private $db = 'mysql:dbname=my_meetic;host=127.0.0.1';
    private $username = 'sasha';
    private $password = 'losos';
    public $connection;

    
    public function DataBaseConnection(){
        $this -> connection = null;
        try {
           $this -> connection = new PDO($this->db, $this->username, $this->password);
           $this -> connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "toto\n";
        } catch (PDOException $exception) {
            if($exception->gerCode()==23000){
                die ("User with email like with already exicts");
            }else{
                die( "Connection ERROR" . $exception->getMessage());
            }
        }
        return $this -> connection;
    }
}

// try {
//     $usedb = new PDO($db, $username, $password);
//     echo "toto\n";
// } catch (PDOException $exception) {
//     echo $exception->getMessage();    
// }