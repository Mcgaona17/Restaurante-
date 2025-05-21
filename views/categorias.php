<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/categoria.php";
include "../controllers/categoriasController.php";

use app\controllers\CategoriasController;

$controller = new CategoriasController();
$categorias = $controller->queryAllCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Restaurante</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistema de Gestión de Restaurante</h1>
        </header>
        <nav>
            <ul>
                <li><a href="platos.php">Platos</a></li>
                <li><a href="categorias.php">Categorías</a></li>
                <li><a href="mesas.php">Mesas</a></li>
                <li><a href="ordenes.php">Órdenes</a></li>
                <li><a href="reportes.php">Reportes</a></li>
            </ul>
        </nav>

        <h2>Gestión de Categorías</h2>

        <?php
        // Mostrar mensajes si existen
        if(isset($_GET['mensaje'])) {
            $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';
            echo '<div class="message-' . $tipo . '">' . $_GET['mensaje'] . '</div>';
        }
        ?>

        <div>
            <a href="forms/formCategoria.php" class="btn">Nueva Categoría</a>
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
                        echo "<a href='forms/formCategoria.php?id=".$categoria->get("id")."' class='btn btn-warning'>Editar</a> ";
                        echo "<a href='acciones/eliminarCategoria.php?id=".$categoria->get("id")."' class='btn btn-danger' onclick='return confirmarEliminar(\"¿Está seguro de eliminar esta categoría?\")'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay categorías registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        // Función para confirmar eliminación
        function confirmarEliminar(mensaje) {
            return confirm(mensaje);
        }
        
        // Función para calcular total en formulario de orden
        function calcularTotal() {
            let total = 0;
            const detalles = document.querySelectorAll('.detalle-item');
            
            detalles.forEach(detalle => {
                const cantidad = parseInt(detalle.querySelector('.cantidad-input').value);
                const precio = parseFloat(detalle.querySelector('.precio-input').value);
                total += cantidad * precio;
            });
            
            document.getElementById('totalInput').value = total.toFixed(2);
        }
    </script>
</body>
</html>