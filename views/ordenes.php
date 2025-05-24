<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/orden.php";
include "../models/entities/detalleOrden.php";
include "../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();
$ordenes = $controller->queryAllOrdenes();

<<<<<<< HEAD
<?php include "includes/header.php"; ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Órdenes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="container">

<h2>Gestión de Órdenes</h2>

<?php
// Mostrar mensajes si existen
if (isset($_GET['mensaje'])) {
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';
    echo '<div class="message-' . htmlspecialchars($tipo) . '">' . htmlspecialchars($_GET['mensaje']) . '</div>';
}
?>

<div>
    <a href="../views/forms/formOrden.php" class="btn">Nueva Orden</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Mesa</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($ordenes) > 0): ?>
            <?php foreach ($ordenes as $orden): ?>
                <tr>
                    <td><?= $orden->get("id") ?></td>
                    <td><?= $orden->get("dateOrder") ?></td>
                    <td><?= $orden->get("tableName") ?></td>
                    <td>$<?= number_format($orden->get("total"), 0, ',', '.') ?></td>
                    <td><?= $orden->get("anulada") == 1 ? "Anulada" : "Activa" ?></td>
                    <td>
                    <a href="acciones/verOrden.php?id=<?= $orden->get('id') ?>" class="btn btn-info">Ver Detalles</a>
                        <?php if ($orden->get("anulada") == 0): ?>
                            <a href="acciones/anular_orden.php?id=<?= $orden->get("id") ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de anular esta orden?')">Anular</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay órdenes registradas</td></tr>
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
=======
// Mostrar mensajes si existen
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Órdenes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <?php include "includes/header.php"; ?>

    <h2>Gestión de Órdenes</h2>

    <?php if (!empty($mensaje)) {
        echo '<div class="message-' . $tipo . '">' . $mensaje . '</div>';
    } ?>

    <div>
        <a href="forms/formOrden.php" class="btn">Nueva Orden</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Mesa</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($ordenes) > 0) {
                foreach ($ordenes as $orden) {
                    echo "<tr>
                        <td>{$orden->get('id')}</td>
                        <td>{$orden->get('dateOrder')}</td>
                        <td>{$orden->get('tableName')}</td>
                        <td>\${$orden->get('total')}</td>
                        <td>" . ($orden->get('anulada') == 1 ? 'Anulada' : 'Activa') . "</td>
                        <td>
                             <a href='acciones/detallesOrden.php?id={$orden->get('id')}'>Ver Detalles</a> |
                             <a href='acciones/anularOrden.php?id={$orden->get('id')}'
                                onclick=\"return confirm('¿Está seguro de anular esta orden?');\">Anular</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay órdenes registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php include "includes/footer.php"; ?>
>>>>>>> b3aa740b9b23e9aaeed91e871012f34471caa90f
</body>
</html>
