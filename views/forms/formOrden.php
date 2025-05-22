<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/mesa.php";
include "../../models/entities/plato.php";
include "../../controllers/mesasController.php";
include "../../controllers/platosController.php";

use app\controllers\MesasController;
use app\controllers\PlatosController;

$mesaController = new MesasController();
$mesas = $mesaController->queryAllMesas();

$platoController = new PlatosController();
$platos = $platoController->queryAllPlatos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Orden</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        .plato-group { margin-bottom: 10px; }
        .btn-add { margin-top: 10px; }
    </style>
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

        <h2>Nueva Orden</h2>
        <form action="../acciones/guardar_orden.php" method="POST" onsubmit="return prepararDetalles();">
            <input type="hidden" name="fechaInput" value="<?php echo date('Y-m-d H:i:s'); ?>">

            <label for="mesaInput">Mesa:</label>
            <select name="mesaInput" required>
                <option value="">Seleccione una mesa</option>
                <?php
                foreach ($mesas as $mesa) {
                    echo "<option value='{$mesa->get("id")}'>{$mesa->get("name")}</option>";
                }
                ?>
            </select>

            <div id="platosContainer">
                <div class="plato-group">
                    <select class="plato" required>
                        <option value="">Seleccione un plato</option>
                        <?php
                        foreach ($platos as $plato) {
                            echo "<option value='{$plato->get("id")}' data-precio='{$plato->get("price")}'>{$plato->get("description")} - \${$plato->get("price")}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" class="cantidad" min="1" value="1" required>
                    <button type="button" onclick="eliminarFila(this)">Eliminar</button>
                </div>
            </div>

            <button type="button" class="btn btn-add" onclick="agregarPlato()">+ Agregar Plato</button>

            <br><br>
            <label for="totalInput">Total:</label>
            <input type="text" name="totalInput" id="totalInput" readonly value="0">

            <input type="hidden
