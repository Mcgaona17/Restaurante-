<?php
include "../models/drivers/conexDB.php";
include "../models/entities/entity.php";
include "../models/entities/mesa.php";
include "../controllers/mesasController.php";

use app\controllers\MesasController;

$controller = new MesasController();
$mesa = null;
$titulo = "Nueva Mesa";

if(!empty($_GET["id"])){
    $mesa = $controller->getMesaById($_GET["id"]);
    $titulo = "Editar Mesa";
}
?>

<?php include "includes/header.php"; ?>

<h2><?php echo $titulo; ?></h2>

<form action="acciones/guardar_mesa.php" method="post">
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
        <a href="mesas.php" class="btn btn-danger">Cancelar</a>
    </div>
</form>

<?php include "includes/footer.php"; ?>