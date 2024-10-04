<?php

require_once('./models/carrera.php');
require_once('./views/JsonView.php');
require_once('./HeaderHandler.php');

class carreraController{
    
    private $carreraModel;
    private $jsonView;

    public function __construct($carreraModel, $jsonView){

        $this->carreraModel = $carreraModel;
        $this->jsonView = $jsonView;
    }

    public function buscar(){
        //Vetirificar si se recibio solicitud POST
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            //Si no es una solicitud POST, responder con un error 405  (Método no permitido)
           http_response_code(405);
           return;
        }

        //Leer el cuerpo JSON de la solicitud
        $postData = file_get_contents('php://input');
        $requestData = json_decode( $postData, true);


        if(!isset($requestData['id_Carrera'])){
            $mensajeError = "Falta de información de la carrera";
            $respuesta = $this->jsonView->renderError($mensajeError, 400);

            echo $respuesta;
            return;
        }

        //Obtener la matricula y nip del cuerpo de la solicitud
        $idCarrera = $requestData['id_Carrera'];
        

        //Validar datos
        $usuario = $this->carreraModel->nombreCarrera($idCarrera);

        if($usuario){
            //Obtener nombre de la  carrera para mostrarlo en la respuesta
            $datosCarrera = $this->carreraModel->nombreCarrera($idCarrera); 
          
            //Agregar las cabeceras de respuesta
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 200);
            echo $respuesta;
        }else{
            $mensajeError = "El ID de la carrera incorrecto";
            $respuesta = $this->jsonView->renderError($mensajeError);

            //Agregar la clave "success" con valor de false al JSON de respuesta
            $respuesta["success"] = false;

            //Agregar las cabeceras de respuesta
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 401);
            echo $respuesta;
        }
    }
}
?>
