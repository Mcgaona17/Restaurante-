<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/categoria.php";
include "../../controllers/categoriasController.php";

use app\controllers\CategoriasController;

$controller = new CategoriasController();

// Verificar si es una nueva categoría o una actualización
$result = empty($_POST["idInput"])
    ? $controller->saveNewCategoria($_POST)
    : $controller->updateCategoria($_POST);

// Redirigir a la página de categorías con un mensaje
$mensaje = $result ? "Categoría guardada correctamente" : "Error al guardar la categoría";
header("Location: ../categorias.php?mensaje=" . urlencode($mensaje) . "&tipo=" . ($result ? "success" : "error"));
exit;