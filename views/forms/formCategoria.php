<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/categoria.php";
include "../controllers/categoriasController.php";

use app\controllers\CategoriasController;

$controller = new CategoriasController();
$categoria = null;
$titulo = "Nueva Categoría";

if(!empty($_GET["id"])){
    $categoria = $controller->getCategoriaById($_GET["id"]);
    $titulo = "Editar Categoría";
}
?>

<?php include "includes/header.php"; ?>

<h2><?php echo $titulo; ?></h2>

<form action="acciones/guardar_categoria.php" method="post">
    <?php
    if($categoria != null){
        echo '<input type="hidden" name="idInput" value="'.$categoria->get("id").'">';
    }
    ?>
    <div>
        <label>Nombre</label>
        <input type="text" name="nombreInput" required value="<?php echo $categoria ? $categoria->get("name") : ''; ?>">
    </div>
    <div>
        <button type="submit">Guardar</button>
        <a href="categorias.php" class="btn btn-danger">Cancelar</a>
    </div>
</form>

<?php include "includes/footer.php"; ?>