<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/mesa.php";
include "../controllers/mesasController.php";

use app\controllers\MesasController;

$controller = new MesasController();
$mesas = $controller->queryAllMesas();

// Procesar mensajes de operaciones (éxito o error)
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<?php include "includes/header.php"; ?>

<h2>Gestión de Mesas</h2>

<?php if(!empty($mensaje)): ?>
    <div class="message-<?php echo $tipo; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

<a href="forms/formMesa.php" class="btn">Nueva Mesa</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mesas as $mesa): ?>
        <tr>
            <td><?php echo $mesa->get("id"); ?></td>
            <td><?php echo $mesa->get("name"); ?></td>
            <td>
                <a href="forms/formMesa.php?id=<?php echo $mesa->get("id"); ?>" class="btn btn-warning">Editar</a>
                <a href="acciones/eliminar_mesa.php?id=<?php echo $mesa->get("id"); ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de eliminar esta mesa?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "includes/footer.php"; ?>