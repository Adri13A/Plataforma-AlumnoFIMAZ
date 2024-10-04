<?php
//models/usuario.php

require_once('../../config/config.php');

class usuario {

    private $PDO;

    //Tabla de la base de datos que se utiliza
    private $table = "admin";
    private $attemptsTable = "login_attempts ";

    public function __construct()
    {
        $conn = new connectionDB();
        $this->PDO = $conn->getConnection();
    }

    public function __destruct()
    {
        $this->PDO = null;
    }

    public function createUser($user, $password){
        if($this->userExists($user)){
            throw new Exception('User already exists');
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->PDO->prepare("INSERT INTO ".$this->table." (username, password) VALUES (:username, :password)");
        
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $hashedPassword);
        
        return  $stmt->execute();
    }

    public function getUserByUserName($username){
        $stmt = $this->PDO->prepare("SELECT * FROM ".$this->table." WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function userExists($user){
        $stmt = $this->PDO->prepare("SELECT COUNT(*) FROM ".$this->table." WHERE username = ?");
        $stmt->execute([$user]);

        return $stmt->fetchColumn() > 0;
    }

    public function logAttempt($username, $ip_address){
        $stmt = $this->PDO->prepare("INSERT INTO ".$this->attemptsTable." (username, ip_address, attempt_time) VALUES (:username, :ip_address, NOW())");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':ip_address', $ip_address);
        return $stmt->execute();
    }


    public function getAttempts($username, $ip_address, $lockout_time){

        $stmt = $this->PDO->prepare("SELECT COUNT(*) as attempt_count, MIN(attempt_time) as first_attempt_time 
                                    FROM ".$this->attemptsTable." 
                                    WHERE username = :username AND ip_address = :ip_address 
                                    AND attempt_time > DATE_SUB(NOW(), INTERVAL :lockout_time MINUTE)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':lockout_time', $lockout_time, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function clearAttempts($username, $ip_address){
        $stmt = $this->PDO->prepare("DELETE FROM ".$this->attemptsTable." WHERE username = :username AND ip_address = :ip_address");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
    }

}
?>
