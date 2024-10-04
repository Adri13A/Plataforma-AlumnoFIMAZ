<?php
// models/kardex.php

require_once('./config.php');

class kardex {

    private $PDO;

    //Tabla de la base de datos que se utiliza
    private $tablaCalificaciones = "calificaciones";
    private $tablaMaterias = "materia";
    private $tablaOptativa = "optativa";

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
    public function obtenerCalificacionesPorPeriodoYMatricula($periodo, $matricula){
        $query = "SELECT calificaciones.*, materia.Materia AS Materia, optativa.Optativa AS Optativa
        FROM calificaciones
        LEFT JOIN materia ON calificaciones.matricula_materia = materia.Codigo
        LEFT JOIN optativa ON calificaciones.matricula_materia = optativa.codigoOptativa
        WHERE calificaciones.periodo = :periodo AND calificaciones.matricula = :matricula";

        $stmt= $this->PDO->prepare($query);

        $stmt->bindParam(':periodo', $periodo);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();

        $calificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $calificaciones;
    }

    //Buscar nombre de la carrera del alumno
    public function obtenerCalificacionesPorMatricula($matricula){
        $query = "SELECT periodo, CalificacionAlumno FROM calificaciones WHERE matricula = :matricula";

        $stmt= $this->PDO->prepare($query);
        
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();

        $calificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $calificaciones;
    }


}
?>
