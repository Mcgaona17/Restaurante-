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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Restaurante - Gestión de Mesas</title>
    <!-- Asegurarse que la ruta al CSS sea correcta -->
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
                        <a href="acciones/eliminarMesa.php?id=<?php echo $mesa->get("id"); ?>" class="btn btn-danger" onclick="return confirmarEliminar('¿Está seguro de eliminar esta mesa?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
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