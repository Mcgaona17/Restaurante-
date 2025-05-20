<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/mesa.php";
include "../../controllers/mesasController.php";

use app\controllers\MesasController;

$controller = new MesasController();

if(isset($_GET["id"])){
    $result = $controller->deleteMesa($_GET["id"]);
    
    // Mensaje según el resultado
    if($result){
        $mensaje = "Mesa eliminada correctamente";
        $tipo = "success";
    } else {
        $mensaje = "No se puede eliminar la mesa porque tiene órdenes asociadas";
        $tipo = "error";
    }
} else {
    $mensaje = "ID de mesa no proporcionado";
    $tipo = "error";
}

// Redirigir a la página de mesas con un mensaje
header("Location: ../mesas.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;