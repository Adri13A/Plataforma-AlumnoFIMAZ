<?php
class connection{
    private $host = "localhost";
    private $database_name = "";
    private $user = "";
    private $pass = "";

    public $conn;

    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->database_name.";user=".$this->user.";password=".$this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->conn;
        }catch(PDOException $exception){
            echo "Error al conectar a la base de datos: ". $exception->getMessage();
            die();
        }

    }
}


?>