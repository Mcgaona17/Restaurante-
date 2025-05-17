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
