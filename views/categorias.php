<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/categoria.php";
include "../controllers/categoriasController.php";

use app\controllers\CategoriasController;

$controller = new CategoriasController();
$categorias = $controller->queryAllCategorias();
?>

<?php include "includes/header.php"; ?>

<h2>Gestión de Categorías</h2>

<div>
    <a href="form_categoria.php" class="btn">Nueva Categoría</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(count($categorias) > 0) {
            foreach($categorias as $categoria){
                echo "<tr>";
                echo "<td>".$categoria->get("id")."</td>";
                echo "<td>".$categoria->get("name")."</td>";
                echo "<td>";
                echo "<a href='form_categoria.php?id=".$categoria->get("id")."' class='btn btn-warning'>Editar</a> ";
                echo "<a href='acciones/eliminar_categoria.php?id=".$categoria->get("id")."' class='btn btn-danger' onclick='return confirmarEliminar(\"¿Está seguro de eliminar esta categoría?\")'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay categorías registradas</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include "includes/footer.php"; ?>