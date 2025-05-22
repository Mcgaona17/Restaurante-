<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/plato.php";
include "../controllers/platosController.php";

use app\controllers\PlatosController;

$controller = new PlatosController();
$platos = $controller->queryAllPlatos();

// Mostrar mensajes si existen
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Platos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <?php include "includes/header.php"; ?>

    <h2>Gestión de Platos</h2>

    <?php if (!empty($mensaje)) {
        echo '<div class="message-' . $tipo . '">' . $mensaje . '</div>';
    } ?>

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
    <?php
    if (count($platos) > 0) {
        foreach ($platos as $plato) {
            echo "<tr>
                <td>{$plato->get('id')}</td>
                <td>{$plato->get('description')}</td>
                <td>{$plato->get('categoryName')}</td>
                <td>\${$plato->get('price')}</td>
                <td>
                    <a href='forms/form_plato.php?id={$plato->get('id')}'>Editar</a> |
                    <a href='acciones/eliminar_plato.php?id={$plato->get('id')}'
                       onclick=\"return confirm('¿Está seguro de eliminar este plato?');\">Eliminar</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay platos registrados.</td></tr>";
    }
    ?>
</tbody>

    </table>

    <?php include "includes/footer.php"; ?>
</body>
</html>
