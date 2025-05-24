<?php include "includes/header.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="container">
        <h2>Reportes</h2>
        <form action="reporte.php?controller=reportes&action=verActivos" method="post">
            <h3>Órdenes NO Anuladas</h3>
            Desde: <input type="date" name="fecha_inicio" required>
            Hasta: <input type="date" name="fecha_fin" required>
            <input type="submit" value="Ver Reporte">
        </form>



        <form action="reporte.php?controller=reportes&action=verAnulados" method="post">
            <h3>Órdenes Anuladas</h3>
            Desde: <input type="date" name="fecha_inicio" required>
            Hasta: <input type="date" name="fecha_fin" required>
            <input type="submit" value="Ver Reporte">
        </form>
    </div>
</body>

</html>


<?php include "includes/footer.php"; ?>