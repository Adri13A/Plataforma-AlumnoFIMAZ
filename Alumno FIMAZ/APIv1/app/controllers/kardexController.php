<?php

require_once('./models/kardex.php');
require_once('./views/JsonView.php');
require_once('./HeaderHandler.php');

class kardexController
{

    private $kardexModel;
    private $jsonView;

    public function __construct($kardexModel, $jsonView)
    {
        $this->kardexModel = $kardexModel;
        $this->jsonView = $jsonView;
    }

    public function obtenerCalificaciones(){

        //Obtener el periodo y la matricula desde la solicitud POST
        $postData = json_decode(file_get_contents("php://input"), true);// Obtener los datos POST como un array asociativo
        
        // Suponiendo que se espera un parámetro 'periodo' y 'matricula' en los datos POST
        $periodo = $postData['periodo'];
        $matricula = $postData['matricula'];

        //Verificar si se proporcionaron el periodo y la matricula
        if(!isset($periodo) || !isset($matricula)){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se recibió el PERIODO o la MATRICULA");
            return;
        }

        //Obtener las calificaciones por periodo y matricula utilizando el modelo
        $calificaciones = $this->kardexModel->obtenerCalificacionesPorPeriodoYMatricula($periodo, $matricula);

        //Verificar si se obtuvieron las calificaciones correctamente
        if(!$calificaciones){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se obtuvieron las calificaciones para el periodo $periodo y la matricula $matricula");
            return;
        }

        //Si se obtuvieron las calificaciones correctamente, enviar las calificaciones como respuesta en JSON
        $this->jsonView->render($calificaciones);

    }

    public function obtenerCalificacionesDelAlumno(){

        //Obtener el periodo y la matricula desde la solicitud POST
        $postData = json_decode(file_get_contents("php://input"), true);// Obtener los datos POST como un array asociativo
        
        // Se espera un parámetro 'periodo' en los datos POST
        $matricula = $postData['matricula'];

        //Verificar si se proporcionaron el periodo y la matricula
        if(!isset($matricula)){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se recibió la MATRICULA");
            return;
        }

        //Obtener las calificaciones por periodo y matricula utilizando el modelo
        $calificaciones = $this->kardexModel->obtenerCalificacionesPorMatricula($matricula);

        //Verificar si se obtuvieron las calificaciones correctamente
        if(!$calificaciones){
            //Si no es así, enviar una respuesta de error
            $this->jsonView->renderError("No se obtuvieron las calificaciones para la matricula $matricula");
            return;
        }

        //Si se obtuvieron las calificaciones correctamente, enviar las calificaciones como respuesta en JSON
        $this->jsonView->render($calificaciones);

    }

}
