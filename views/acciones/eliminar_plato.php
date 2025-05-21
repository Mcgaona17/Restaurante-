<?php
require_once "../../models/drivers/conexDB.php";
require_once "../../models/entities/entity.php";
require_once "../../models/entities/plato.php";
require_once "../../controllers/platosController.php";

use app\controllers\PlatosController;

if (!isset($_GET['id'])) {
    header("Location: ../platos.php?mensaje=ID+no+especificado&tipo=error");
    exit;
}

$id = $_GET['id'];
$controller = new PlatosController();

if ($controller->deletePlato($id)) {
    header("Location: ../platos.php?mensaje=Plato+eliminado+correctamente&tipo=success");
} else {
    header("Location: ../platos.php?mensaje=No+se+pudo+eliminar+el+plato.+Puede+estar+relacionado+con+una+orden.&tipo=error");
}
exit;
