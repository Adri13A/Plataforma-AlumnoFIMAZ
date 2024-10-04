<?php

require_once('./models/alumno.php');
require_once('./views/JsonView.php');
require_once('./HeaderHandler.php');

class LoginController{
    
    private $usuarioModel;
    private $jsonView;

    public function __construct($usuarioModel, $jsonView){

        $this->usuarioModel = $usuarioModel;
        $this->jsonView = $jsonView;
    }

    public function login(){
        //Vetirificar si se recibio solicitud POST
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            //Si no es una solicitud POSST, responder con un error 405  (Método no permitido)
           http_response_code(405);
           return;
        }

       
        if(!isset($requestData['matricula']) || !isset($requestData['nip'])){
            $mensajeError = "Falta de información del usuario";
            $respuesta = $this->jsonView->renderError($mensajeError, 400);

            echo $respuesta;
            return;
        }

        //Obtener la matricula y nip del cuerpo de la solicitud
        $matricula = $requestData['matricula'];
        $nip = $requestData['nip'];

        //Validar credenciales
        $usuario = $this->usuarioModel->validarCredenciales($matricula, $nip);

        if($usuario){
            //Obtener datos del usuario
            $datosUsuario = $this->usuarioModel->obtenerDatosUsuario($matricula);

            //Agregar la clase "success" al JSON de respeuesta
            $datosUsuario["success"] = true;

            $respuesta =  $this->jsonView->render($datosUsuario);

            //Agregar las cabeceras de respuesta
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 200);
            echo $respuesta;
        }else{
            $mensajeError = "Credenciales incorrectas";
            $respuesta = $this->jsonView->renderError($mensajeError);

            //Agregar la clave "success" con valir de false al JSON de respuesta
            $respuesta["success"] = false;

            //Agregar las cabeceras de respuesta
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 401);
            echo $respuesta;
        }
    }
}
?>
