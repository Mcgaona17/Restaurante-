<?php
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/drivers/conexDB.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/entities/entity.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/entities/orden.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/entities/detalleOrden.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/entities/plato.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/models/entities/mesa.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/controllers/ordenesController.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/controllers/platosController.php";
include $_SERVER["DOCUMENT_ROOT"] . "/Mono/controllers/mesasController.php";



use app\controllers\OrdenesController;
use app\controllers\PlatosController;
use app\controllers\MesasController;

// Instanciar controladores
$ordenesController = new OrdenesController();
$platosController = new PlatosController();
$mesasController = new MesasController();

// Obtener mesas y platos para los selectores
$mesas = $mesasController->queryAllMesas();
$platos = $platosController->queryAllPlatos();

// Inicializar variables
$titulo = "Nueva Orden";
?>

<?php include "../includes/header2.php"; ?>

<h2><?php echo $titulo; ?></h2>

<form action="acciones/guardar_orden.php" method="post" id="ordenForm">
    <div class="orden-form-container">
        <div class="orden-form-left">
            <div>
                <label>Fecha</label>
                <input type="datetime-local" name="fechaInput" id="fechaInput" required value="<?php echo date('Y-m-d\TH:i'); ?>">
            </div>
            <div>
                <label>Mesa</label>
                <select name="mesaInput" required>
                    <option value="">Seleccione una mesa</option>
                    <?php foreach($mesas as $mesa): ?>
                    <option value="<?php echo $mesa->get('id'); ?>"><?php echo $mesa->get('name'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Total</label>
                <input type="number" name="totalInput" id="totalInput" step="0.01" readonly value="0.00">
            </div>
            <h3>Agregar Platos</h3>
            <div>
                <label>Plato</label>
                <select id="platosSelector">
                    <option value="">Seleccione un plato</option>
                    <?php foreach($platos as $plato): ?>
                    <option value="<?php echo $plato->get('id'); ?>" 
                            data-precio="<?php echo $plato->get('price'); ?>"
                            data-descripcion="<?php echo $plato->get('description'); ?>">
                        <?php echo $plato->get('description'); ?> - $<?php echo $plato->get('price'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Cantidad</label>
                <input type="number" id="cantidadSelector" min="1" value="1">
            </div>
            <button type="button" id="btnAgregarPlato" class="btn">Agregar Plato</button>
        </div>
        
        <div class="orden-form-right">
            <h3>Detalle de la Orden</h3>
            <div class="detalle-list" id="detallesList">
                <p>No hay platos agregados</p>
            </div>
        </div>
    </div>
    
    <div>
        <button type="submit">Guardar Orden</button>
        <a href="../ordenes.php" class="btn btn-danger">Cancelar</a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const platoSelector = document.getElementById('platosSelector');
        const cantidadSelector = document.getElementById('cantidadSelector');
        const btnAgregarPlato = document.getElementById('btnAgregarPlato');
        const detallesList = document.getElementById('detallesList');
        const ordenForm = document.getElementById('ordenForm');
        let detalleCount = 0;
        
        // Función para actualizar el total
        function actualizarTotal() {
            let total = 0;
            const detalles = document.querySelectorAll('.detalle-item');
            
            detalles.forEach(detalle => {
                const cantidad = parseInt(detalle.querySelector('.cantidad-input').value);
                const precio = parseFloat(detalle.querySelector('.precio-input').value);
                total += cantidad * precio;
            });
            
            document.getElementById('totalInput').value = total.toFixed(2);
        }
        
        // Agregar un plato al detalle
        btnAgregarPlato.addEventListener('click', function() {
            const platoId = platoSelector.value;
            if (!platoId) {
                alert('Por favor seleccione un plato');
                return;
            }
            
            const cantidad = parseInt(cantidadSelector.value);
            if (cantidad <= 0) {
                alert('La cantidad debe ser mayor a 0');
                return;
            }
            
            const selectedOption = platoSelector.options[platoSelector.selectedIndex];
            const descripcion = selectedOption.getAttribute('data-descripcion');
            const precio = parseFloat(selectedOption.getAttribute('data-precio'));
            
            // Verificar si el plato ya está en la lista
            const existingItem = document.querySelector(`.detalle-item[data-plato-id="${platoId}"]`);
            if (existingItem) {
                const cantidadInput = existingItem.querySelector('.cantidad-input');
                cantidadInput.value = parseInt(cantidadInput.value) + cantidad;
                actualizarTotal();
                return;
            }
            
            // Si es el primer detalle, limpiar el mensaje
            if (detalleCount === 0) {
                detallesList.innerHTML = '';
            }
            
            // Crear el elemento HTML para el detalle
            const detalleItem = document.createElement('div');
            detalleItem.className = 'detalle-item';
            detalleItem.dataset.platoId = platoId;
            
            detalleItem.innerHTML = `
                <input type="hidden" name="detalles[${detalleCount}][idPlato]" value="${platoId}">
                <input type="number" name="detalles[${detalleCount}][cantidad]" value="${cantidad}" min="1" class="cantidad-input" style="width: 60px;" onchange="calcularTotal()">
                <input type="hidden" name="detalles[${detalleCount}][precio]" value="${precio}" class="precio-input">
                <span>${descripcion} - $${precio}</span>
                <button type="button" class="btn btn-danger btn-eliminar">X</button>
            `;
            
            detallesList.appendChild(detalleItem);
            
            // Agregar evento para eliminar el detalle
            const btnEliminar = detalleItem.querySelector('.btn-eliminar');
            btnEliminar.addEventListener('click', function() {
                detalleItem.remove();
                detalleCount--;
                actualizarTotal();
                
                if (detalleCount === 0) {
                    detallesList.innerHTML = '<p>No hay platos agregados</p>';
                }
            });
            
            detalleCount++;
            actualizarTotal();
            
            // Limpiar la selección
            platoSelector.selectedIndex = 0;
            cantidadSelector.value = 1;
        });
        
        // Validar el formulario antes de enviar
        ordenForm.addEventListener('submit', function(e) {
            if (detalleCount === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un plato a la orden');
            }
        });
    });
</script>

<?php include "../includes/footer.php"; ?>