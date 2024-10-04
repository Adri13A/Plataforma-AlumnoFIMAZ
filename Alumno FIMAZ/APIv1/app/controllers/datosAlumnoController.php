<?php

require_once('./models/alumno.php');
require_once('./views/JsonView.php');
require_once('./HeaderHandler.php');

class datosAlumnoController
{

    private $usuarioModel;
    private $jsonView;

    public function __construct($usuarioModel, $jsonView)
    {
        $this->usuarioModel = $usuarioModel;
        $this->jsonView = $jsonView;
    }

    public function buscarDatosUsuario()
    {

        //Vetirificar si se recibio solicitud POST
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            //Si no es una solicitud POSST, responder con un error 405  (Método no permitido)
            http_response_code(405);
            return;
        }

        // Obtener la matrícula del cuerpo de la solicitud
        $postData = file_get_contents('php://input');
        $requestData = json_decode($postData, true);

        $matricula = $requestData['matricula'];

        // Obtener datos del usuario
        $datosUsuario = $this->usuarioModel->obtenerDatosUsuario($matricula);

        if ($datosUsuario) {
            // Si se encuentran los datos del usuario
            $datosUsuario["success"] = true;
            $respuesta = $this->jsonView->render($datosUsuario);
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 200);
            echo $respuesta;
        } else {
            // Si no se encuentran los datos del usuario
            $mensajeError = "Datos del usuario no encontrados";
            $respuesta = $this->jsonView->renderError($mensajeError);
            $respuesta["success"] = false;
            $headerHandler = new HeaderHandler();
            $headerHandler->setHttpHeaders("application/json", 404);
            echo $respuesta;
        }
    }

    public function actualizarDatosUsuario()
    {
        // Verificar si se recibió una solicitud POST
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Si no es una solicitud POST, responder con un error 405 (Método no permitido)
            http_response_code(405);
            return;
        }

        // Obtener los datos del cuerpo de la solicitud
        $postData = file_get_contents('php://input');

        // Verificar si se recibieron datos válidos
        if (empty($postData)) {
            // Si no se recibieron datos válidos, responder con un error 400 (Solicitud incorrecta)
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "Error: Datos no recibidos."));
            return;
        }

        // Convertir los datos recibidos a un array asociativo
        $requestData = json_decode($postData, true);

        // Verificar si se recibieron los datos necesarios
        if (!isset($requestData['matricula'])) {
            // Si no se recibieron los datos necesarios, responder con un error 400 (Solicitud incorrecta)
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "Error: Datos incompletos."));
            return;
        }

        // Llamar al modelo para actualizar los datos del usuario
        $mensaje = $this->usuarioModel->actualizarDatosUsuarioModel($requestData);
        
        // Verificar si la actualización fue exitosa
        if (strpos($mensaje, 'Actualización de datos con matrícula') !== false) {
            // Si la actualización fue exitosa, responder con un código 200 (OK) y el mensaje de éxito
            http_response_code(200);
            echo json_encode(array("success" => true, "message" => $mensaje));
        } else {
            // Si la actualización no fue exitosa, responder con un código 500 (Error interno del servidor) y el mensaje de error
            http_response_code(500);
            echo json_encode(array("success" => false, "message" => $mensaje));
        }
    }
}
