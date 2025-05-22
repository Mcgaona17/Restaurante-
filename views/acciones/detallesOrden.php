<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/orden.php";
include "../../models/entities/detalleOrden.php";
include "../../controllers/ordenesController.php";

use app\controllers\OrdenesController;

$controller = new OrdenesController();
$orden = $controller->getOrdenById($_GET["id"]);
$detalles = $orden->get("detalles");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Orden</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistema de Gestión de Restaurante</h1>
        </header>   
        <nav>
            <ul>
                <li><a href="../platos.php">Platos</a></li>
                <li><a href="../categorias.php">Categorías</a></li>
                <li><a href="../mesas.php">Mesas</a></li>
                <li><a href="../ordenes.php">Órdenes</a></li>
                <li><a href="../reportes.php">Reportes</a></li>
            </ul>
        </nav>

        <h2>Detalle de la Orden #<?php echo $orden->get("id"); ?></h2>
        <p><strong>Fecha:</strong> <?php echo $orden->get("dateOrder"); ?></p>
        <p><strong>Mesa:</strong> <?php echo $orden->get("tableName"); ?></p>
        <p><strong>Total:</strong> $<?php echo $orden->get("total"); ?></p>
        <p><strong>Estado:</strong> <?php echo ($orden->get("anulada") == 1 ? "Anulada" : "Activa"); ?></p>

        <h3>Platos incluidos:</h3>
        <table>
            <thead>
                <tr>
                    <th>Plato</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($detalles)) {
                    foreach ($detalles as $detalle) {
                        echo "<tr>
                               <td>" . $detalle->get("dishDescription") . "</td>
                               <td>" . $detalle->get("quantity") . "</td>
                               <td>$" . number_format($detalle->calcularSubtotal(), 2) . "</td>
</tr>";

                    }
                } else {
                    echo "<tr><td colspan='3'>No hay detalles disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <br>
        <a href="../ordenes.php" class="btn">Volver a Órdenes</a>
    </div>
</body>
</html>
