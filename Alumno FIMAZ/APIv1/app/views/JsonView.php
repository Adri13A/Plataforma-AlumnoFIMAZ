<?php

class JsonView{

    public function render($datos){
        header('Content-Type: application/json');
        echo json_encode($datos);
    }

    public function renderError($mensajeError){
        header('Content-Type: application/json');
        echo json_encode(["error" => $mensajeError]);
    }
}


?>