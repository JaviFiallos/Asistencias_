<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de horas</title>
    <link rel="stylesheet" href="../Vista/Estilos/horario_docente.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    <script>
       $(document).ready(function() {
        var idEmpleado;
        $('#ROL_EMP').on('input', function() {
            var searchKeyword = $(this).val().trim();

            if (searchKeyword.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '../Modelo/buscar_docente.php',
                    data: { keyword: searchKeyword },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#resultado_busqueda').empty();

                        if (response.length > 0) {
                            response.forEach(function(persona) {
                                var nombreCompleto = persona.nombre + ' ' + persona.apellido;
                                idEmpleado = persona.id; // Obtener el ID_EMP del docente

                                $('#resultado_busqueda').append('<div class="nombre-docente" data-id="' + idEmpleado + '">' + nombreCompleto + '</div>');
                            });
                        } else {
                            $('#resultado_busqueda').html('<div class="nombre-docente">No se encontraron resultados</div>');
                        }
                    }
                });
            } else {
                $('#resultado_busqueda').html('');
            }
        });

        $(document).on('click', '.nombre-docente', function() {
            var nombreCompleto = $(this).text().trim();
            var idEmpleado = $(this).data('id'); // Obtener el ID_EMP del docente

            $('#ROL_EMP').val(nombreCompleto);
            $('#input_id').val(idEmpleado); // Asignar el ID_EMP al input oculto

            $('#resultado_busqueda').html('');
        });
        
           
        });
        
    </script>
</head>
<body>

<div class="container">
    <h1 class="titulo-seleccion">Asignación de horas</h1>
    <div id="resultado_busqueda"></div>

    <form method="POST" action="../Modelo/guardar_horarios.php">
        <label for="docente">Buscar Docente:</label>
        <input type="text" id="ROL_EMP" name="ROL_EMP" required>
        <?php
            // Supongamos que tienes el valor antiguo en esta variable
            $oldValue = isset($_POST['ID_EMP']) ? $_POST['ID_EMP'] : ''; // o cualquier otro origen de datos
        ?>
        <input type="text" name="ID_EMP" id="input_id" <?php if(!empty($oldValue)) echo 'value="' . htmlspecialchars($oldValue) . '"'; ?> required>


        
        <h4 class="titulo-jornada">Jornada matutina:</h4>
        <div class="formulario-jornada">
            <label for="hora_inicio_matutina">Desde:</label>
            <input type="time" id="hora_inicio_matutina" name="hora_inicio_matutina" min="07:00" max="13:00" required>
            <label for="hora_fin_matutina">Hasta:</label>
            <input type="time" id="hora_fin_matutina" name="hora_fin_matutina" min="07:00" max="13:00" required><br>
        </div>

        <h4 class="titulo-jornada">Jornada vespertina:</h4>
        <div class="formulario-jornada">
            <label for="hora_inicio_vespertina">Desde:</label>
            <input type="time" id="hora_inicio_vespertina" name="hora_inicio_vespertina" min="14:00" max="20:00" required>
            <label for="hora_fin_vespertina">Hasta:</label>
            <input type="time" id="hora_fin_vespertina" name="hora_fin_vespertina" min="14:00" max="20:00" required><br>
        </div>
        
        <div class="boton-container"> 
            <input type="submit" name="action" value="Eliminar" class="boton-secundario">
            <input type="submit" name="action" value="Editar" class="boton-tercero">
            <input type="submit" name="action" value="Asignar" class="boton-morado">
        </div>
    </form>
    <?php
        if (isset($_GET['mensaje'])) {
            $mensaje = htmlspecialchars($_GET['mensaje'], ENT_QUOTES, 'UTF-8');
            echo '<div><p>' . $mensaje . '</p></div>';
        }
    ?>

</div>

</body>
</html>
