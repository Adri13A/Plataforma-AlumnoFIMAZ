<?php
session_start();

// Verificar el usuario si está autenticado
if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Acceso no permitido']);
    exit();
}

require_once("../../config/config.php");
require_once("../../models/recurso.php");
require_once("../../controllers/recursoController.php");

// Verificar si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que se ha recibido el id del recurso
    if (isset($_POST['id_recurso']) && !empty($_POST['id_recurso'])) {
        $id_recurso = $_POST['id_recurso'];

        // Creación de conexión a la BD y controlador
        $database = new connectionDB();
        $recursoModel = new recurso($database);
        $recursoController = new recursoController($recursoModel);

        // Eliminar el recurso
        $result = $recursoController->eliminarRecurso($id_recurso);

        if ($result) {
            // Preparar la respuesta JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Recurso eliminado con éxito']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el recurso']);
        }
    } else {
        // Mostrar un mensaje de error si no se ha enviado el id del recurso
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'ID del recurso no proporcionado']);
    }
} else {
    // Mostrar un mensaje de error si se accede directamente a este script sin POST
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Acceso no permitido']);
}
?>
