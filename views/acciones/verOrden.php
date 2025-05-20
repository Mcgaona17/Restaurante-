<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/orden.php";
include "../models/entities/detalleOrden.php";
include "../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();

// Verificar si se ha proporcionado un ID
if(!isset($_GET["id"])){
    header("Location: ordenes.php?mensaje=ID+de+orden+no+proporcionado&tipo=error");
    exit;
}

// Obtener la orden
$orden = $controller->getOrdenById($_GET["id"]);
if(!$orden){
    header("Location: ordenes.php?mensaje=Orden+no+encontrada&tipo=error");
    exit;
}

// Obtener los detalles de la orden
$detalles = $controller->getDetallesByOrdenId($orden->get("id"));
?>

<?php include "includes/header.php"; ?>

<h2>Detalles de Orden #<?php echo $orden->get("id"); ?></h2>

<div class="factura">
    <div class="factura-header">
        <h3>Información de la Orden</h3>
    </div>
    
    <div class="factura-details">
        <p><strong>Fecha:</strong> <?php echo $orden->get("dateOrder"); ?></p>
        <p><strong>Mesa:</strong> <?php echo $orden->get("tableName"); ?></p>
        <p><strong>Estado:</strong> <?php echo ($orden->get("anulada") == 1 ? "Anulada" : "Activa"); ?></p>
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
                foreach($detalles as $detalle): 
                    $subtotal = $detalle->calcularSubtotal();
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $detalle->get("quantity"); ?></td>
                    <td><?php echo $detalle->get("dishDescription"); ?></td>
                    <td>$<?php echo number_format($detalle->get("price"), 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="factura-total">
        <p>Total: $<?php echo number_format($orden->get("total"), 2); ?></p>
    </div>
    
    <div>
        <a href="ordenes.php" class="btn">Volver a Órdenes</a>
        <?php if($orden->get("anulada") == 0): ?>
        <a href="acciones/anular_orden.php?id=<?php echo $orden->get("id"); ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de anular esta orden?');">Anular Orden</a>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>