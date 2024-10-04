<?php
// models/horario.php

require_once('./config.php');

class horario {

    private $PDO;

    public function __construct()
    {
        $conn = new connection();
        $this->PDO = $conn->getConnection();
    }

    public function __destruct()
    {
        $this->PDO = null;
    }

      public function obtenerHorarioPorAlumno($matricula, $periodo){
        $query = "SELECT nombre_materia, horario, aula, nombre_maestro, imagen, color
        FROM (
            SELECT 
                m.Materia AS nombre_materia,
                h.horario,
                h.aula,
                CONCAT(ma.nombre, ' ', ma.apellidoPaterno, ' ', ma.apellidoMaterno) AS nombre_maestro,
                h.imagen, 
                h.color  
            FROM materia m
                      WHERE 
                m.Carrera = (
                    SELECT Carrera
                    FROM alumno
                    WHERE matricula = :matricula
                )
                AND m.Periodo = :periodo";

        $stmt= $this->PDO->prepare($query);

        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':periodo', $periodo);

        $stmt->execute();

        $horario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $horario;
    }

}
?>
