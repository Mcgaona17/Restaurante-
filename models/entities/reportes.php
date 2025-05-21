<h2>Reportes</h2>
<form action="index.php?controller=reportes&action=verActivos" method="post">
    <h3>Órdenes NO Anuladas</h3>
    Desde: <input type="date" name="fecha_inicio" required>
    Hasta: <input type="date" name="fecha_fin" required>
    <input type="submit" value="Ver Reporte">
</form>

<hr>

<form action="index.php?controller=reportes&action=verAnulados" method="post">
    <h3>Órdenes Anuladas</h3>
    Desde: <input type="date" name="fecha_inicio" required>
    Hasta: <input type="date" name="fecha_fin" required>
    <input type="submit" value="Ver Reporte">
</form>
