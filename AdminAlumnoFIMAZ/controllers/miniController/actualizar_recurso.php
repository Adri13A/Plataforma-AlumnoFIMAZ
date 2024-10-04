<?php
//editar_recurso.php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: ../../views/login.php');
    exit();
}

require_once("../../config/config.php");
require_once("../../models/recurso.php");
require_once("../../controllers/recursoController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener los datos del formulario
    $id_recurso = $_POST['id_recurso'];
    $nombreRecurso = $_POST['nombreRecurso'];
    $imgRecursoActual = $_POST['imgRecurso'];
    $idCarrera = isset($_POST['idCarrera']) && $_POST['idCarrera'] !== '' ? $_POST['idCarrera'] : null; // Cambiar null si está vacío
    $tipo = $_POST['tipo'];


    //Ruta para guardar las imagenes
    $baseDir = "../../views/imgUploads/";

    //Verificar si se ha cargado una imagen
    $imgRecurso = $_FILES['imgRecurso'];
    $imgRecursoPath = $imgRecursoActual;

    if (isset($imgRecurso) && $imgRecurso['error'] === UPLOAD_ERR_OK) {
        $imgRecursoName = $imgRecurso['name'];
        $imgRecursoTmpName = $imgRecurso['tmp_name'];
        $imgRecursoExt = strtolower(pathinfo($imgRecursoName, PATHINFO_EXTENSION));

        //Extensiones permitidas
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($imgRecursoExt, $allowed)) {
            $imgRecursoPath = preg_replace("/[^a-zA-Z0-9_-]/", "-", $nombreRecurso) . "." . $imgRecursoExt;
            $imgDestination = $baseDir . $imgRecursoPath;

            //Mover el archivo a la ubicacion destino
            if (!move_uploaded_file($imgRecursoTmpName, $imgDestination)) {
                echo json_encode(['success' => false, 'message' => 'Error al mover el archivo.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
            exit();
        }
    }

    $dataBase = new connectionDB();
    $recursoModel = new recurso($dataBase);
    $controller = new recursoController($recursoModel);

    //Actualizar el recurso
    $result = $controller->actualizarRecurso($id_recurso, $nombreRecurso, $tipo, $idCarrera, $imgRecursoPath);

    // Preparar la respuesta JSON

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Datos guardados exitosamente.']);
    }else{
        echo json_encode(['success' => true, 'message' => 'Error al guardar los datos.']);
    }
    exit();
} else {
    // Mostrar un mensaje de error si se accede directamente a este script sin POST
    echo json_encode(['success' => false, 'message' => 'Acceso restringido']);
    exit();
}
