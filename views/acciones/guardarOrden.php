<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/orden.php";
include "../../models/entities/detalleOrden.php";
include "../../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los datos necesarios están presentes
    if (isset($_POST['fechaInput']) && isset($_POST['mesaInput']) && isset($_POST['totalInput']) && isset($_POST['detalles'])) {
        
        // Preparar los datos para guardar
        $request = [
            'fechaInput' => $_POST['fechaInput'],
            'mesaInput' => $_POST['mesaInput'],
            'totalInput' => $_POST['totalInput']
        ];
        
        // Guardar la orden y sus detalles
        $result = $controller->saveNewOrden($request, $_POST['detalles']);
        
        if ($result) {
            $mensaje = "Orden guardada correctamente con ID: " . $result;
            $tipo = "success";
        } else {
            $mensaje = "Error al guardar la orden";
            $tipo = "error";
        }
    } else {
        $mensaje = "Faltan datos requeridos para crear la orden";
        $tipo = "error";
    }
} else {
    $mensaje = "Método no permitido";
    $tipo = "error";
}

// Redirigir a la página de órdenes con un mensaje
header("Location: ../ordenes.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;