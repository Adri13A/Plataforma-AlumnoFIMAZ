<?php
// controller/horarioController.php

require_once('./models/horario.php');
require_once('./views/JsonView.php');
require_once('./HeaderHandler.php');

class horarioController
{

    private $horarioModel;
    private $jsonView;

    public function __construct($horarioModel, $jsonView)
    {
        $this->horarioModel = $horarioModel;
        $this->jsonView = $jsonView;
    }

    public function obtenerHorario(){

        //Obtener el periodo y la matricula desde la solicitud POST
        $postData = json_decode(file_get_contents("php://input"), true);// Obtener los datos POST como un array asociativo
        
        // Suponiendo que se espera un parámetro 'periodo' y 'matricula' en los datos POST
        $matricula = $postData['matricula'];
        $periodo = $postData['periodo'];

        //Verificar si se proporcionaron el periodo y la matricula
        if(!isset($matricula) || !isset($periodo)){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se recibió el PERIODO o la MATRICULA");
            return;
        }

        //Obtener las horario por periodo y matricula utilizando el modelo
        $horario = $this->horarioModel->obtenerHorarioPorAlumno($matricula, $periodo);

        //Verificar si se obtuvieron las horario correctamente
        if(!$horario){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se obtuvieron las horario para el periodo $periodo y la matricula $matricula");
            return;
        }

        //Si se obtuvieron las horario correctamente, enviar las horario como respuesta en JSON
        $this->jsonView->render($horario);

    }


}
