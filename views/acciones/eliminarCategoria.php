<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/categoria.php";
include "../../controllers/categoriasController.php";

use app\controllers\CategoriasController;

$controller = new CategoriasController();

if(isset($_GET["id"])){
    $result = $controller->deleteCategoria($_GET["id"]);
    
    // Mensaje según el resultado
    if($result){
        $mensaje = "Categoría eliminada correctamente";
        $tipo = "success";
    } else {
        $mensaje = "No se puede eliminar la categoría porque tiene platos asociados";
        $tipo = "error";
    }
} else {
    $mensaje = "ID de categoría no proporcionado";
    $tipo = "error";
}

// Redirigir a la página de categorías con un mensaje
header("Location: ../categorias.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;