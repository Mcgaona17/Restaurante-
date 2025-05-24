<?php
// Inclusiones corregidas
include __DIR__ . "/../../models/drivers/conexDB.php";
include __DIR__ . "/../../models/entities/entity.php";
include __DIR__ . "/../../models/entities/orden.php";
include __DIR__ . "/../../models/entities/detalleOrden.php";
include __DIR__ . "/../../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();

// Verificar si se ha proporcionado un ID
if (!isset($_GET["id"])) {
    header("Location: ../ordenes.php?mensaje=ID+de+orden+no+proporcionado&tipo=error");
    exit;
}

// Obtener la orden
$orden = $controller->getOrdenById($_GET["id"]);
if (!$orden) {
    header("Location: ../ordenes.php?mensaje=Orden+no+encontrada&tipo=error");
    exit;
}

// Obtener los detalles de la orden
$detalles = $controller->getDetallesByOrdenId($orden->get("id"));
?>

<?php include "../includes/header2.php"; ?>

<h2>Detalles de Orden #<?= $orden->get("id"); ?></h2>

<div class="factura">
    <div class="factura-header">
        <h3>Información de la Orden</h3>
    </div>

    <div class="factura-details">
        <p><strong>Fecha:</strong> <?= $orden->get("dateOrder"); ?></p>
        <p><strong>Mesa:</strong> <?= $orden->get("tableName"); ?></p>
        <p><strong>Estado:</strong> <?= $orden->get("anulada") == 1 ? "Anulada" : "Activa"; ?></p>
    </div>

    <div class="factura-items">
        <h4>Platos</h4>
        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($detalles as $detalle):
                    $subtotal = $detalle->calcularSubtotal();
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $detalle->get("quantity"); ?></td>
                    <td><?= $detalle->get("dishDescription"); ?></td>
                    <td>$<?= number_format($detalle->get("price"), 2); ?></td>
                    <td>$<?= number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="factura-total">
        <p>Total: $<?= number_format($orden->get("total"), 2); ?></p>
    </div>

    <div>
        <a href="../ordenes.php" class="btn">Volver a Órdenes</a>
        <?php if ($orden->get("anulada") == 0): ?>
            <a href="../acciones/anular_orden.php?id=<?= $orden->get("id"); ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de anular esta orden?');">Anular Orden</a>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmarEliminar(mensaje) {
    return confirm(mensaje);
}
</script>

<?php include "../includes/footer.php"; ?>
