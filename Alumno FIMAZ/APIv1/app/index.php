<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('config.php');
require_once ('./models/alumno.php');
require_once ('./controllers/loginController.php');
require_once ('./views/JsonView.php');

$database = new connection();
$alumnoModel = new alumno($database);
$jsonView = new JsonView();
$loginController = new LoginController($alumnoModel, $jsonView);

$loginController->login();
