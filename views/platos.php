<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/plato.php";
include "../controllers/platosController.php";

use app\controllers\PlatosController;

$controller = new PlatosController();
$platos = $controller->queryAllPlatos();
?>

<?php include "includes/header.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Platos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="container">
   
<h2>Gestión de Platos</h2>

<?php
// Mostrar mensajes si existen
if (isset($_GET['mensaje'])) {
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';
    echo '<div class="message-' . $tipo . '">' . htmlspecialchars($_GET['mensaje']) . '</div>';
}
?>

<div>
    <a href="forms/form_plato.php" class="btn">Nuevo Plato</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($platos) > 0): ?>
            <?php foreach ($platos as $plato): ?>
                <tr>
                    <td><?= $plato->get("id") ?></td>
                    <td><?= $plato->get("description") ?></td>
                    <td><?= $plato->get("categoryName") ?></td>
                    <td>$<?= number_format($plato->get("price"), 0, ',', '.') ?></td>
                    <td>
                        <a href="forms/form_plato.php?id=<?= $plato->get("id") ?>" class="btn btn-warning">Editar</a>
                        <a href="acciones/eliminar_plato.php?id=<?= $plato->get("id") ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de eliminar este plato?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No hay platos registrados</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function confirmarEliminar(mensaje) {
    return confirm(mensaje);
}
</script>

<?php include "includes/footer.php"; ?>
</div>
</body>
</html>
