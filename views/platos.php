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

<h2>Gestión de Platos</h2>

<?php
// Mostrar mensajes si existen
if(isset($_GET['mensaje'])) {
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';
    echo '<div class="message-' . $tipo . '">' . $_GET['mensaje'] . '</div>';
}
?>

<div>
    <a href="form_plato.php" class="btn">Nuevo Plato</a>
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
        <?php
        if(count($platos) > 0) {
            foreach($platos as $plato){
                echo "<tr>";
                echo "<td>".$plato->get("id")."</td>";
                echo "<td>".$plato->get("description")."</td>";
                echo "<td>".$plato->get("categoryName")."</td>";
                echo "<td>$".$plato->get("price")."</td>";
                echo "<td>";
                echo "<a href='form_plato.php?id=".$plato->get("id")."' class='btn btn-warning'>Editar</a> ";
                echo "<a href='acciones/eliminar_plato.php?id=".$plato->get("id")."' class='btn btn-danger' onclick='return confirmarEliminar(\"¿Está seguro de eliminar este plato?\")'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay platos registrados</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include "includes/footer.php"; ?>