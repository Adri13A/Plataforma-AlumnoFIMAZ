<?php

require_once ('config.php');
require_once ('./models/horario.php');
require_once ('./controllers/horarioController.php');
require_once ('./views/JsonView.php');

$database = new connection();
$horarioModel = new horario($database);
$jsonView = new JsonView();
$horarioController = new horarioController($horarioModel, $jsonView);


$horarioController->obtenerHorario();

?>