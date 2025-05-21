<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/mesa.php";
include "../../controllers/mesasController.php";

use app\controllers\MesasController;

$controller = new MesasController();
$mensaje = "";
$tipo = "";

// Verificar si se enviaron los datos del formulario
if(isset($_POST["nombreInput"])){
    // Verificar si es una actualización o un nuevo registro
    if(isset($_POST["idInput"])){
        // Actualizar mesa existente
        $request = [
            'idInput' => $_POST["idInput"],
            'nombreInput' => $_POST["nombreInput"]
        ];
        
        $result = $controller->updateMesa($request);
        
        if($result){
            $mensaje = "Mesa actualizada correctamente";
            $tipo = "success";
        } else {
            $mensaje = "Error al actualizar la mesa";
            $tipo = "error";
        }
    } else {
        // Crear nueva mesa
        $request = [
            'nombreInput' => $_POST["nombreInput"]
        ];
        
        $result = $controller->saveNewMesa($request);
        
        if($result){
            $mensaje = "Mesa creada correctamente";
            $tipo = "success";
        } else {
            $mensaje = "Error al crear la mesa";
            $tipo = "error";
        }
    }
} else {
    $mensaje = "No se recibieron datos del formulario";
    $tipo = "error";
}

// Redirigir a la página de mesas con un mensaje
// La ruta relativa correcta desde acciones/ a mesas.php
header("Location: ../mesas.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;