<?php

require_once ('config.php');
require_once ('./models/kardex.php');
require_once ('./controllers/kardexController.php');
require_once ('./views/JsonView.php');

$database = new connection();
$kardexModel = new kardex($database);
$jsonView = new JsonView();
$kardexController = new kardexController($kardexModel, $jsonView);


$kardexController->obtenerCalificacionesDelAlumno();

?>