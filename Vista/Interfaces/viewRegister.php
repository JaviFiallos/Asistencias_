<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Registros de Asistencia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar y mostrar los registros de asistencia
            function cargarRegistros() {
                $.ajax({
                    type: 'GET',
                    url: '../Modelo/selectAllRegister.php',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            var tableHtml = '<table class="table table-striped"><thead><tr><th>ID</th><th>Fecha</th><th>Jornada</th><th>Hora Ingreso</th><th>Hora Salida</th><th>Descuento</th><th>Horas por Jornada</th><th>Subtotal Jornada</th><th>ID Empleado</th></tr></thead><tbody>';

                            response.forEach(function(registro) {
                                tableHtml += '<tr>';
                                tableHtml += '<td>' + registro.ID_REG + '</td>';
                                tableHtml += '<td>' + registro.FECHA + '</td>';
                                tableHtml += '<td>' + registro.JORNADA + '</td>';
                                tableHtml += '<td>' + registro.HORA_INGRESO + '</td>';
                                tableHtml += '<td>' + registro.HORA_SALIDA + '</td>';
                                tableHtml += '<td>' + registro.DESCUENTO + '</td>';
                                tableHtml += '<td>' + registro.HORAS_POR_JORNADA + '</td>';
                                tableHtml += '<td>' + registro.SUBTOTAL_JORNADA + '</td>';
                                tableHtml += '<td>' + registro.ID_EMP_PER + '</td>';
                                tableHtml += '</tr>';
                            });

                            tableHtml += '</tbody></table>';
                            $('#tabla_registros').html(tableHtml);
                        } else {
                            $('#tabla_registros').html('<p>No hay registros disponibles.</p>');
                        }
                    },
                    error: function() {
                        $('#tabla_registros').html('<p>Error al cargar los registros.</p>');
                    }
                });
            }

            // Llamar a la función para cargar los registros al cargar la página
            cargarRegistros();
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="titulo-seleccion">Lista de Registros de Asistencia</h1>
        <div id="tabla_registros"></div>
    </div>
</body>
</html>
