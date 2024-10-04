<?php
//recursoContrioller.php
require_once('../../models/recurso.php');


class recursoController{

    private $recursoModel;

    public function __construct(){

        $this->recursoModel = new recurso();

    }

    public function agregarRecurso($nombreRecurso, $imgRecurso, $idCarrera, $tipo, $fecha){
       return $this->recursoModel->insertarRecurso($nombreRecurso, $imgRecurso, $idCarrera, $tipo, $fecha);

    }

    public function obtenerRecurso(){
        return ($this->recursoModel->obtenerRecursos()) ? $this->recursoModel->obtenerRecursos() : false;
    }

    public function eliminarRecurso($id_recurso){
        return($this->recursoModel->eliminarRecursos($id_recurso)) ? $this->recursoModel->eliminarRecursos($id_recurso) : false;
    }

    public function obtenerRecursoPorID($id_recurso){
        return ($this->recursoModel->obtenerRecursosPorID($id_recurso)) ? $this->recursoModel->obtenerRecursosPorID($id_recurso) : false;
    }

    public function actualizarRecurso($id_recurso, $nombreRecurso, $tipo, $idCarrera, $imgRecursoPath) {
        return $this->recursoModel->actualizarRecursos($id_recurso, $nombreRecurso, $tipo, $idCarrera, $imgRecursoPath);
    }
}
?>
