<?php
require_once('../../config/config.php');
require_once('../../controllers/authController.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $authController  = new authController(new usuario($PDO) );

    $username = $_POST['username'];
    $password = $_POST['password'];

    $signResult = $authController->signup($username, $password);
    if  ($signResult){
        header('Location: ../../views/login.php');

        exit();
    }else{
        header('Location: ../../views/signup.php?error=username_taken');
        exit();
    }
}else{
    include './views/signup.php';
}

?>