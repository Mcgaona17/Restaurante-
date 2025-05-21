<h3>Órdenes NO Anuladas</h3>
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

<p><strong>Total Recaudado:</strong> $<?= $total ?></p>

<h4>Ranking de platos más vendidos</h4>
<ol>
<?php foreach($ranking as $plato): ?>
    <li><?= $plato['description'] ?> (<?= $plato['cantidad'] ?> vendidos)</li>
<?php endforeach; ?>
</ol>
<a href="index.php?controller=reportes&action=index">Volver</a>
