<?php
// Utilizando rutas absolutas para resolver el problema de inclusión
$baseDir = $_SERVER['DOCUMENT_ROOT'] . '/Restaurante-';

require_once $baseDir . '/models/drivers/conexDB.php';
require_once $baseDir . '/models/entities/entity.php';
require_once $baseDir . '/models/entities/mesa.php';
require_once $baseDir . '/controllers/mesasController.php';

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

// Redirigir a la página de mesas con un mensaje (utilizando también ruta absoluta)
header("Location: " . '/Restaurante-/views/mesas.php?mensaje=' . urlencode($mensaje) . "&tipo=" . $tipo);
exit;