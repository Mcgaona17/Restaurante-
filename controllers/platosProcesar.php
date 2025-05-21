<?php
require_once "../models/drivers/conexDB.php";
require_once "../models/entities/entity.php";
require_once "../models/entities/plato.php";
require_once "platosController.php";

use app\controllers\PlatosController;

$controller = new PlatosController();

// Procesar edición de plato
if (isset($_POST['editar_plato'])) {
    $_POST['idInput'] = $_POST['id'];
    $_POST['descripcionInput'] = $_POST['description'];
    $_POST['precioInput'] = $_POST['price'];
    $_POST['categoriaInput'] = $_POST['category_id'];

    if ($controller->updatePlato($_POST)) {
        header("Location: ../views/platos.php?mensaje=Plato+actualizado+correctamente&tipo=success");
    } else {
        header("Location: ../views/platos.php?mensaje=Error+al+actualizar+plato&tipo=error");
    }
    exit;
}

// Procesar creación de nuevo plato
if (isset($_POST['guardar_plato'])) {
    $_POST['descripcionInput'] = $_POST['description'];
    $_POST['precioInput'] = $_POST['price'];
    $_POST['categoriaInput'] = $_POST['category_id'];

    if ($controller->saveNewPlato($_POST)) {
        header("Location: ../views/platos.php?mensaje=Plato+registrado+correctamente&tipo=success");
    } else {
        header("Location: ../views/platos.php?mensaje=Error+al+registrar+plato&tipo=error");
    }
    exit;
}
