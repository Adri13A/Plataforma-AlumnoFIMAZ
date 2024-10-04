<?php

require_once ('config.php');
require_once ('./models/carrera.php');
require_once ('./controllers/carreraController.php');
require_once ('./views/JsonView.php');

$database = new connection();
$carreraModel = new carrera($database);
$jsonView = new JsonView();
$carreraController = new carreraController($carreraModel, $jsonView);


$carreraController->buscar()
?>