<?php

require_once ('config.php');
require_once ('./models/alumno.php');
require_once ('./controllers/datosAlumnoController.php');
require_once ('./views/JsonView.php');

$database = new connection();
$alumnoModel = new alumno($database);
$jsonView = new JsonView();
$datosAlumnoController = new datosAlumnoController($alumnoModel, $jsonView);


$datosAlumnoController->buscarDatosUsuario();

?>