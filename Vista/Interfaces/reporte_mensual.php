<div class="app-content-headerText">
    <h3>Reporte Mensual</h3>
</div>
<div class="card">
    <div class="card-body">
        <form id="reporteForm" action="../Modelo/RM.php" method="POST" target="_blank">
            <div class="mb-3">
                <label for="mes" class="form-label">Seleccione el Mes</label>
                <input type="month" class="form-control" id="mes" name="mes">
                <!-- Campos ocultos para la fecha de inicio y fin del mes -->
                <input type="hidden" id="fechaInicio" name="fechaInicio">
                <input type="hidden" id="fechaFin" name="fechaFin">
            </div>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('mes').addEventListener('change', function() {
        const mesInput = document.getElementById('mes');
        const fechaInicioInput = document.getElementById('fechaInicio');
        const fechaFinInput = document.getElementById('fechaFin');

        // Obtén el valor del campo de mes
        const mesValue = mesInput.value;

        if (!mesValue) {
            alert("Por favor, seleccione un mes.");
            return;
        }

        // Extraer el año y el mes del valor del campo de mes
        const [year, month] = mesValue.split('-');

        // Calcular la fecha correspondiente al primer día del mes
        const primerDiaMes = new Date(year, month - 1, 1);

        // Calcular la fecha correspondiente al último día del mes
        const ultimoDiaMes = new Date(year, month, 0);

        // Formatear las fechas como "yyyy-mm-dd"
        const fechaInicio = primerDiaMes.toISOString().split('T')[0];
        const fechaFin = ultimoDiaMes.toISOString().split('T')[0];

        // Actualizar los campos ocultos
        fechaInicioInput.value = fechaInicio;
        fechaFinInput.value = fechaFin;
    });

    document.getElementById('reporteForm').addEventListener('submit', function(event) {
        // Deja que el formulario se envíe
        setTimeout(function() {
            // Vaciar los campos después de enviar el formulario

            document.getElementById('mes').value = '';
            document.getElementById('fechaInicio').value = '';
            document.getElementById('fechaFin').value = '';
        }, 100); // Añadir un pequeño retraso para asegurar que el formulario se envíe primero
    });

    // Limpiar los campos cuando la página se carga de nuevo
    window.addEventListener('load', function() {
        document.getElementById('mes').value = '';
        document.getElementById('fechaInicio').value = '';
        document.getElementById('fechaFin').value = '';
    });
</script>
