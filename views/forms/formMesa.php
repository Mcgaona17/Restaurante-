<?php
// Adjust the include paths to correctly point to the required files
// Use relative paths from this file's location (assuming it's in views/forms/)
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/mesa.php";
include "../../controllers/mesasController.php";

use app\controllers\MesasController;

$controller = new MesasController();
$mesa = null;
$titulo = "Nueva Mesa";

if(!empty($_GET["id"])){
    $mesa = $controller->getMesaById($_GET["id"]);
    $titulo = "Editar Mesa";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Restaurante - <?php echo $titulo; ?></title>
    <!-- Use correct relative path to the CSS file -->
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

        <h2><?php echo $titulo; ?></h2>

        <form action="../acciones/guardarMesa.php" method="post">
            <?php
            if($mesa != null){
                echo '<input type="hidden" name="idInput" value="'.$mesa->get("id").'">';
            }
            ?>
            <div>
                <label>Nombre</label>
                <input type="text" name="nombreInput" required value="<?php echo $mesa ? $mesa->get("name") : ''; ?>">
            </div>
            <div>
                <button type="submit">Guardar</button>
                <a href="../mesas.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>

        <!-- Include footer content directly -->
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