<?php
// models/recurso.php

require_once('../../config/config.php');

class recurso {
    private $PDO;
    private $tablaRecursos = "recursos";

    public function __construct() {
        $conn = new connectionDB();
        $this->PDO = $conn->getConnection();
    }

    public function __destruct() {
        $this->PDO = null;
    }

    public function insertarRecurso($nombreRecurso, $imgRecurso, $idCarrera, $tipo, $fecha) {
        // Ajustamos el valor de $idCarrera a NULL si es una cadena vacía
        if ($idCarrera === '') {
            $idCarrera = null;
        }

        $query = "INSERT INTO ".$this->tablaRecursos." (nombreRecurso, imgRecurso, id_Carrera, tipo, fecha_publicacion) VALUES (:nombreRecurso, :imgRecurso, :id_Carrera, :tipo, :fecha_publicacion)";

        $stmt = $this->PDO->prepare($query);

        $stmt->bindParam(':nombreRecurso', $nombreRecurso);
        $stmt->bindParam(':imgRecurso', $imgRecurso);
        $stmt->bindParam(':id_Carrera', $idCarrera, PDO::PARAM_INT); // Aseguramos que sea INT o NULL
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':fecha_publicacion', $fecha);

       if($stmt->execute()){
        return true;
       }else{
        error_log("Error en la ejecucion de la consulta: ".implode(", ",$stmt->errorInfo()));
       }
    }

    public function obtenerRecursos(){
        $query = "SELECT * FROM ".$this->tablaRecursos." ORDER BY fecha_publicacion";

        $stmt =  $this->PDO->prepare($query);
        $stmt->execute();
        $recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $recursos;
    }

    public function eliminarRecursos($id_recurso){
        $query = "DELETE FROM ".$this->tablaRecursos." WHERE id_recurso = :id_recurso";

        $stmt = $this->PDO->prepare($query);

        $stmt->bindParam(':id_recurso', $id_recurso);

        return ($stmt->execute()) ? true : false;
    }

    public function obtenerRecursosPorID($id_recurso){
        $query = "SELECT * FROM ".$this->tablaRecursos." WHERE id_recurso = :id_recurso";

        $stmt = $this->PDO->prepare($query);

        $stmt->bindParam(':id_recurso', $id_recurso, PDO::PARAM_INT);

        $stmt->execute();

        $recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $recursos;
    }

    public function actualizarRecursos($id_recurso, $nombreRecurso, $tipo, $idCarrera, $imgRecursoPath){
        $query = "UPDATE ".$this->tablaRecursos." SET
                    nombreRecurso = :nombreRecurso,
                    tipo = :tipo,
                    id_Carrera = :idCarrera,
                    imgRecurso = :imgRecurso
                    WHERE id_recurso = :id_recurso";

        $stmt = $this->PDO->prepare($query);

        $stmt->bindParam(':nombreRecurso', $nombreRecurso);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':idCarrera', $idCarrera);
        $stmt->bindParam(':imgRecurso', $imgRecursoPath);
        $stmt->bindParam(':id_recurso', $id_recurso);

        return $stmt->execute();
    }
}
?>
