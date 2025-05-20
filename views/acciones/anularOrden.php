<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/orden.php";
include "../../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();

if(isset($_GET["id"])){
    $result = $controller->anularOrden($_GET["id"]);
    
    // Mensaje según el resultado
    if($result){
        $mensaje = "Orden anulada correctamente";
        $tipo = "success";
    } else {
        $mensaje = "No se pudo anular la orden";
        $tipo = "error";
    }
} else {
    $mensaje = "ID de orden no proporcionado";
    $tipo = "error";
}

// Redirigir a la página de órdenes con un mensaje
header("Location: ../ordenes.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;