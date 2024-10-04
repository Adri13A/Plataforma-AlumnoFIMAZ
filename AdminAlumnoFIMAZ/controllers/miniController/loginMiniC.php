<?php
//controller/loginMiniC.php

session_start();

require_once("../../config/config.php");
require_once("../../models/usuario.php");
require_once("../../controllers/authController.php");

if (($_SERVER['REQUEST_METHOD'] === 'POST')){

    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    
    // Obtener la dirección IP del cliente
    $ip_address = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (!empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : 'UNKNOWN'));


    // Validar los datos
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Por favor, ingrese nombre de usuario y contraseña correctos.";
        header('Location: ../../views/login.php');
        exit();
    }

    $database = new connectionDB();
    $usuarioModel = new usuario($database);
    $authController = new authController($usuarioModel);
    $loginResult  = $authController->login($username, $password, $ip_address);

    if($loginResult  === 'locked'){
        $_SESSION['error'] = "Demasiados intentos fallidos. Por favor intente de nuevo en 15 minutos.";
        header('Location: ../../views/login.php');
        exit();
    }elseif($loginResult){
        //session_regenerate_id(true);
        $_SESSION['user'] = $loginResult;
        header('Location: ../../views/panel.php');
        exit();
    
    }else{
        $_SESSION['error'] = "Nombre de usuario o contraseña incorrectos.";
        header('Location: ../../views/login.php');
        exit();
    }
}else{
    include '../../views/login.php';
}


?>