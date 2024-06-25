<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Asistencia</title>
    <link rel="stylesheet" href="../Vista/Estilos/horario_docente.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para buscar y mostrar los registros de asistencia por cédula
            $('#buscar_cedula').on('input', function() {
                var searchKeyword = $(this).val().trim();

                if (searchKeyword.length >= 0) {
                    $.ajax({
                        type: 'POST',
                        url: '../Modelo/selectAllRegister.php',
                        data: { keyword: searchKeyword },
                        dataType: 'json',
                        success: function(response) {
                            mostrarRegistros(response);
                        }
                    });
                } else {
                    // Si no hay texto en el campo, mostrar todos los registros
                    $.ajax({
                        type: 'POST',
                        url: '../Modelo/selectAllRegister.php',
                        dataType: 'json',
                        success: function(response) {
                            mostrarRegistros(response);
                        }
                    });
                }
            });

            function mostrarRegistros(registros) {
                // Limpiar la tabla antes de añadir los nuevos registros
                $('#tabla_registros').empty();

                // Construir filas de la tabla con los datos recibidos
                registros.forEach(function(registro) {
                    var fila = '<tr>';
                    fila += '<td>' + registro.ID_REG + '</td>';
                    fila += '<td>' + registro.FECHA + '</td>';
                    fila += '<td>' + registro.JORNADA + '</td>';
                    fila += '<td>' + registro.HORA_INGRESO + '</td>';
                    fila += '<td>' + registro.HORA_SALIDA + '</td>';
                    fila += '<td>' + registro.DESCUENTO + '</td>';
                    fila += '<td>' + registro.HORAS_POR_JORNADA + '</td>';
                    fila += '<td>' + registro.SUBTOTAL_JORNADA + '</td>';
                    fila += '</tr>';

                    $('#tabla_registros').append(fila);
                });
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="titulo-seleccion">Registros de Asistencia</h1>
        <div class="form-group">
            <label for="buscar_cedula">Buscar por Cédula:</label>
            <input type="text" class="form-control" id="buscar_cedula">
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Jornada</th>
                        <th>Hora de Ingreso</th>
                        <th>Hora de Salida</th>
                        <th>Descuento</th>
                        <th>Horas por Jornada</th>
                        <th>Subtotal Jornada</th>
                    </tr>
                </thead>
                <tbody id="tabla_registros">
                    <!-- Aquí se cargarán dinámicamente los registros -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
