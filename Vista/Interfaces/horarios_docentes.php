<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar de horario</title>
    <link rel="stylesheet" href="../Vista/Estilos/horario_docente.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para buscar y mostrar los resultados de la búsqueda
            $('#CED_EMP').on('input', function() {
                var searchKeyword = $(this).val().trim();

                if (searchKeyword.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '../Modelo/buscar_docente.php',
                        data: { keyword: searchKeyword },
                        dataType: 'json',
                        success: function(response) {
                            $('#resultado_busqueda').empty();

                            if (response.length > 0) {
                                response.forEach(function(persona) {
                                    var nombreCompleto = persona.nombre + ' ' + persona.apellido;
                                    var idEmpleado = persona.id;

                                    $('#resultado_busqueda').append('<div style="border: 1px solid palevioletred; border-radius: 8px; margin: 5px; padding: 5px;" class="nombre-docente" data-id="' + idEmpleado + '">' + nombreCompleto + '</div>');
                                });
                            } else {
                                $('#resultado_busqueda').html('<div style="border: 1px solid palevioletred; border-radius: 8px; margin: 5px; padding: 5px;" class="nombre-docente">No se encontraron resultados</div>');
                            }
                        }
                    });
                } else {
                    $('#resultado_busqueda').html('');
                }
            });

            // Función para seleccionar un empleado al hacer clic en su nombre
            $(document).on('click', '.nombre-docente', function() {
                var nombreCompleto = $(this).text().trim();
                var idEmpleado = $(this).data('id');

                $('#CED_EMP').val(nombreCompleto);
                $('#input_id').val(idEmpleado);

                $('#resultado_busqueda').html('');

                // Cargar horarios existentes del docente seleccionado
                $.ajax({
                    type: 'GET',
                    url: '../Modelo/obtener_horarios.php',
                    data: { ID_EMP: idEmpleado },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            var horarios = response.horarios;
                            $('#hora_inicio_matutina').val(horarios.matutina.inicio);
                            $('#hora_fin_matutina').val(horarios.matutina.fin);
                            $('#hora_inicio_vespertina').val(horarios.vespertina.inicio);
                            $('#hora_fin_vespertina').val(horarios.vespertina.fin);
                        } else {
                            $('#hora_inicio_matutina').val('');
                            $('#hora_fin_matutina').val('');
                            $('#hora_inicio_vespertina').val('');
                            $('#hora_fin_vespertina').val('');
                        }
                    }
                });
            });

            // Función para manejar el envío del formulario (Agregar/Editar horario)
            $('#form_horarios').on('submit', function(e) {
                e.preventDefault();
                
                var horaInicioMatutina = $('#hora_inicio_matutina').val();
                var horaFinMatutina = $('#hora_fin_matutina').val();
                var horaInicioVespertina = $('#hora_inicio_vespertina').val();
                var horaFinVespertina = $('#hora_fin_vespertina').val();

                var totalHoras = calcularTotalHoras(horaInicioMatutina, horaFinMatutina, horaInicioVespertina, horaFinVespertina);

                if (totalHoras !== 8) {
                    alert('Las horas de trabajo deben sumar 8 horas');
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '../Modelo/guardar_horarios.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            $('#form_horarios')[0].reset();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Función para eliminar el horario del docente
            $('#eliminar_horario').on('click', function() {
                var idEmpleado = $('#input_id').val();

                if (idEmpleado) {
                    if (confirm('¿Estás seguro de eliminar los horarios de este docente?')) {
                        $.ajax({
                            type: 'POST',
                            url: '../Modelo/eliminar_horarios.php',
                            data: { ID_EMP: idEmpleado },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message);
                                    $('#form_horarios')[0].reset();
                                } else {
                                    alert(response.message);
                                }
                            }
                        });
                    }
                } else {
                    alert('Selecciona un docente primero.');
                }
            });

            // Función para calcular las horas totales entre las dos jornadas
            function calcularTotalHoras(horaInicioMatutina, horaFinMatutina, horaInicioVespertina, horaFinVespertina) {
                var inicioMatutina = new Date('1970-01-01T' + horaInicioMatutina + 'Z');
                var finMatutina = new Date('1970-01-01T' + horaFinMatutina + 'Z');
                var inicioVespertina = new Date('1970-01-01T' + horaInicioVespertina + 'Z');
                var finVespertina = new Date('1970-01-01T' + horaFinVespertina + 'Z');

                var horasMatutina = (finMatutina - inicioMatutina) / (1000 * 60 * 60);
                var horasVespertina = (finVespertina - inicioVespertina) / (1000 * 60 * 60);

                return horasMatutina + horasVespertina;
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="titulo-seleccion">Asignar de horario</h1>
        <div id="resultado_busqueda" style="border: 1px solid palevioletred; border-radius: 8px; margin: 5px; padding: 5px;"></div>

        <form id="form_horarios">
            <label for="docente">Buscar Docente por Cédula:</label>
            <input type="text" id="CED_EMP" name="CED_EMP" required>
            <input type="hidden" name="ID_EMP" id="input_id">
            
            <h4 class="titulo-jornada">Jornada matutina:</h4>
            <div class="formulario-jornada">
                <label for="hora_inicio_matutina">Desde:</label>
                <input type="time" id="hora_inicio_matutina" name="hora_inicio_matutina" min="07:00" max="13:00" required>
                <label for="hora_fin_matutina">Hasta:</label>
                <input type="time" id="hora_fin_matutina" name="hora_fin_matutina" min="07:00" max="13:00" required>
            </div>

            <h4 class="titulo-jornada">Jornada vespertina:</h4>
            <div class="formulario-jornada" style=" margin: 5px; padding: 5px;">
                <label for="hora_inicio_vespertina">Desde:</label>
                <input type="time" id="hora_inicio_vespertina" name="hora_inicio_vespertina" min="14:00" max="20:00" required>
                <label for="hora_fin_vespertina">Hasta:</label>
                <input type="time" id="hora_fin_vespertina" name="hora_fin_vespertina" min="14:00" max="20:00" required>
            </div>

            <div class="boton-container">
                <button type="button" id="eliminar_horario" class="boton-secundario">Eliminar</button>
                <button type="submit" class="boton-tercero">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>
