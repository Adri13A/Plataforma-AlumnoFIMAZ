<?php
//agregar_recursos.php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../views/login.php');
    exit();
}

// Utilizando una ruta absoluta para incluir send-notification.php
require_once('/home/connectmzt/public_html/app/send-notification.php');

require_once("../../config/config.php");
require_once("../../models/recurso.php");
require_once("../../controllers/recursoController.php");


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new connectionDB();
    $recursoModel = new recurso($database);
    $controller = new recursoController($recursoModel);

    // Manejar el formulario para agregar recurso
    $nombreRecurso = $_POST['nombreRecurso'];
    $idCarrera = $_POST['idCarrera'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];


    //Ruta para guardar las imagenes
    $baseDir = "../../views/imgUploads/";


    //Verificar si el directorio existe, si no crearlo
    if (!is_dir($baseDir)) {
        if (!mkdir($baseDir, 0755, true)) {
            error_log("No se pudo crear el directorio: " . $baseDir);
            echo json_encode(['success' => false, 'message' => 'No se pudo crear el directorio de subida']);
            exit();
        }
    }


    //Verificar si se ha cargado un archivo
    if (isset($_FILES['imgRecurso']) && $_FILES['imgRecurso']['error'] === UPLOAD_ERR_OK) {
        //Información del archivo
        $imgRecurso = $_FILES['imgRecurso'];
        $imgName = $imgRecurso['name'];
        $imgTmpName = $imgRecurso['tmp_name'];
        $imgSize = $imgRecurso['size'];
        $imgError = $imgRecurso['error'];
        $imgType = $imgRecurso['type'];
        //Obtener la extension del archivo
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        //Extensiones permitidas
        $allowed = array('jpg', 'jpeg', 'png');

        //Verificar la extension del archivo
        if (in_array($imgExt, $allowed)) {

            //Generar un nombre unico para la imagen
            $imgNewName = preg_replace("/[^a-zA-Z0-9_-]/", "-", $nombreRecurso) . "." . $imgExt;
            $imgDestination = $baseDir . $imgNewName;

            //Mover el archivo a la ubicacion destino
            if (move_uploaded_file($imgTmpName, $imgDestination)) {
                //Intentar agregar el recurso con la ruta de la imagen
                $result = $controller->agregarRecurso($nombreRecurso, $imgNewName, $idCarrera, $tipo, $fecha);

                //Enviar notificacion
                $titulo = "Nuevo Recursos Agregado";
                $mensaje = "Se ha agregado un nuevo recurso: $nombreRecurso";
                $calendarioId = $idCarrera;
                $calendarioNombre = $nombreRecurso;

                enviarNotificacion($titulo, $mensaje, $calendarioId, $calendarioNombre);

                // Preparar la respuesta JSON

                if(is_array($result) && isset($result['success'])){

                    if ($result['success']) {
                        $response['success'] = true;
                        $response['message'] = "Datos guardados exitosamente.";

                        error_log("Recurso agregado exitosamente: " . json_encode($result));
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Error! No se guardaron los datos.";

                        error_log("Error al agregar recurso: " . json_encode($result));
                    }
                }else{
                    error_log("Error inesperado al agregar recurso. El resultado no es un array: " . json_encode($result));
                    $response['success'] = false;
                    $response['message'] = 'Error inesperado al agregar recurso';
                }
                echo json_encode($response);
                exit();
            } else {
                $response = array(
                    'success' => false,
                    'message' => "Error al mover el archivo"
                );
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array(
                'success' => false,
                'message' => "Tipo de archivo no permitido"
            );
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array(
            'success' => false,
            'message' => "Error al cargar el archivo"
        );
        echo json_encode($response);
        exit();
    }
} else {
    // Mostrar un mensaje de error si se accede directamente a este script sin POST
    $response = array(
        'success' => false,
        'message' => 'Acceso no permitido'
    );
    echo json_encode($response);
    exit();
}
