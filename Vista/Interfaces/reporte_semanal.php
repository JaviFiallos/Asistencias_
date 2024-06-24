<div class="app-content-headerText">
    <h3>Reporte Semanal</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="../Modelo/RS.php" method="POST">
            <div class="mb-3">
                <label for="cedula" class="form-label">Ingrese la Cedula del Empleado a Reportar</label>
                <input type="text" class="form-control" id="cedula" name="cedula">
            </div>
            <div class="mb-3">
                <label for="semana" class="form-label">Seleccione la Semana</label>
                <input type="week" class="form-control" id="semana" name="semana">
                <!-- Campos ocultos para la fecha de inicio y fin de la semana -->
                <input type="hidden" id="fechaInicio" name="fechaInicio">
                <input type="hidden" id="fechaFin" name="fechaFin">
            </div>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('semana').addEventListener('change', function() {
        const semanaInput = document.getElementById('semana');
        const fechaInicioInput = document.getElementById('fechaInicio');
        const fechaFinInput = document.getElementById('fechaFin');

        // Obtén el valor del campo de semana
        const semanaValue = semanaInput.value;

        if (!semanaValue) {
            alert("Por favor, seleccione una semana.");
            return;
        }

        // Extraer el año y el número de semana del valor del campo de semana
        const [year, week] = semanaValue.split('-W');

        // Calcular la fecha correspondiente al primer día de la semana
        const primerDiaSemana = new Date(year, 0, (week - 1) * 7 + 1);
        // Ajustar al primer día de la semana (lunes)
        const dayOfWeek = primerDiaSemana.getDay();
        const diff = primerDiaSemana.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
        primerDiaSemana.setDate(diff);

        // Calcular la fecha correspondiente al último día de la semana (domingo)
        const ultimoDiaSemana = new Date(primerDiaSemana);
        ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);

        // Formatear las fechas como "yyyy-mm-dd"
        const fechaInicio = primerDiaSemana.toISOString().split('T')[0];
        const fechaFin = ultimoDiaSemana.toISOString().split('T')[0];

        // Actualizar los campos ocultos
        fechaInicioInput.value = fechaInicio;
        fechaFinInput.value = fechaFin;
    });
</script>
