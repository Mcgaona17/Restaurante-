<h3>Órdenes ANULADAS</h3>
<table border="1">
<tr><th>ID</th><th>Fecha</th><th>Mesa</th><th>Total</th></tr>
<?php foreach($ordenes as $orden): ?>
<tr>
    <td><?= $orden['id'] ?></td>
    <td><?= $orden['fecha'] ?></td>
    <td><?= $orden['mesa'] ?></td>
    <td>$<?= $orden['total'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<p><strong>Total Anulado:</strong> $<?= $total ?></p>
<a href="index.php?controller=reportes&action=index">Volver</a>
