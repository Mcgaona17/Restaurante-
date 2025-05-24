<?php
include "../../models/drivers/conexDB.php";
include "../../models/entities/entity.php";
include "../../models/entities/plato.php";
include "../../models/entities/categoria.php";
include "../../controllers/platosController.php";
include "../../controllers/categoriasController.php";

use app\controllers\PlatosController;
use app\controllers\CategoriasController;

$controller = new PlatosController();
$categoriaController = new CategoriasController();

$plato = null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $plato = $controller->getPlatoById($id);
}

$categorias = $categoriaController->queryAllCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Editar Plato' : 'Nuevo Plato'; ?> - Restaurante</title>
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

        <h2><?php echo $id ? 'Editar Plato' : 'Nuevo Plato'; ?></h2>

        <form method="POST" action="../../controllers/platosProcesar.php">
            <?php if ($id): ?>
                <input type="hidden" name="id" value="<?php echo $plato->get('id'); ?>">
            <?php endif; ?>

            <label for="description">Descripción:</label>
            <input type="text" name="description" required value="<?php echo $plato ? $plato->get('description') : ''; ?>">

            <label for="category_id">Categoría:</label>
            <select name="category_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria->get('id'); ?>"
                        <?php if ($plato && $categoria->get('id') == $plato->get('idCategory')) echo 'selected'; ?>>
                        <?php echo $categoria->get('name'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="price">Precio:</label>
            <input type="number" name="price" step="0.01" required value="<?php echo $plato ? $plato->get('price') : ''; ?>">

            <br><br>
            <?php if ($id): ?>
                <button type="submit" name="editar_plato">Actualizar</button>
            <?php else: ?>
                <button type="submit" name="guardar_plato">Guardar</button>
            <?php endif; ?>
        </form>

        <br>
        <a href="../platos.php" class="btn">Volver a la lista de Platos</a>
    </div>
</body>
</html>
