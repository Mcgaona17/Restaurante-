<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/orden.php";
include "../models/entities/detalleOrden.php";
include "../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();
$ordenes = $controller->queryAllOrdenes();
?>

<?php include "includes/header.php"; ?>

<h2>Gestión de Órdenes</h2>

<?php
// Mostrar mensajes si existen
if(isset($_GET['mensaje'])) {
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';
    echo '<div class="message-' . $tipo . '">' . $_GET['mensaje'] . '</div>';
}
?>

<div>
    <a href="form_orden.php" class="btn">Nueva Orden</a>
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
        if(count($ordenes) > 0) {
            foreach($ordenes as $orden){
                echo "<tr>";
                echo "<td>".$orden->get("id")."</td>";
                echo "<td>".$orden->get("dateOrder")."</td>";
                echo "<td>".$orden->get("tableName")."</td>";
                echo "<td>$".$orden->get("total")."</td>";
                echo "<td>".($orden->get("anulada") == 1 ? "Anulada" : "Activa")."</td>";
                echo "<td>";
                echo "<a href='ver_orden.php?id=".$orden->get("id")."' class='btn btn-info'>Ver Detalles</a> ";
                if($orden->get("anulada") == 0) {
                    echo "<a href='acciones/anular_orden.php?id=".$orden->get("id")."' class='btn btn-danger' onclick='return confirmarEliminar(\"¿Está seguro de anular esta orden?\")'>Anular</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay órdenes registradas</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include "includes/footer.php"; ?>