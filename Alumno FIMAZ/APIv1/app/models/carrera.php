<?php
// models/AlumnoModel.php

require_once('./config.php');

class carrera {

    private $PDO;

    //Tabla de la base de datos que se utiliza
    private $tabla = "carrera";

    public function __construct()
    {
        $conn = new connection();
        $this->PDO = $conn->getConnection();
    }

    public function __destruct()
    {
        $this->PDO = null;
    }

    //Buscar nombre de la carrera del alumno
    public function nombreCarrera($idCarrera){
        $query = "SELECT NombreCarrera FROM ".$this->tabla ." WHERE id_Carrera =:idCarrera";
        $stmt= $this->PDO->prepare($query);

        $stmt->bindParam(":idCarrera",$idCarrera);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario;
    }


}
?>
