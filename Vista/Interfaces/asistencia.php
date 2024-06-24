<?php
$empleado = $_SESSION['empleado'];
$empleadoId = $empleado['id'];
include '../Modelo/conexion.php';

include '../Modelo/selectHorario.php';

?>

<!-- Tabla para mostrar la información del empleado -->
<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;" class="bg-danger bg-opacity-25">Información Personal</th>
                </tr>
            </thead>
            <tbody>
                <tr> <!-- Fila azul opaco -->
                    <td class="bg-primary bg-opacity-25"><strong>Nombre:</strong> <?php echo htmlspecialchars($empleado['nombre']); ?></td>
                    <td class="bg-primary bg-opacity-25"><strong>Apellido:</strong> <?php echo htmlspecialchars($empleado['apellido']); ?></td>
                    <td class="bg-primary bg-opacity-25"><strong>Cédula:</strong> <?php echo htmlspecialchars($empleado['cedula']); ?></td>
                    <td class="bg-primary bg-opacity-25" style="text-transform: lowercase;"><strong>Correo:</strong> <?php echo htmlspecialchars($empleado['correo']); ?></td>
                    <td class="bg-primary bg-opacity-25"><strong>Rol:</strong> <?php echo htmlspecialchars($empleado['rol']); ?></td>
                </tr>
                <tr> <!-- Fila verde opaco -->
                    <td class="bg-success bg-opacity-25"><strong>Jornada:</strong> <?php echo htmlspecialchars($jornadaMatutino); ?></td>
                    <td class="bg-success bg-opacity-25"><strong>Entrada:</strong> <?php echo htmlspecialchars($entradaMatutino); ?></td>
                    <td class="bg-success bg-opacity-25" colspan="3"><strong>Salida:</strong> <?php echo htmlspecialchars($salidaMatutino); ?></td>
                </tr>
                <tr> <!-- Fila roja opaco -->
                    <td class="bg-danger bg-opacity-25"><strong>Jornada:</strong> <?php echo htmlspecialchars($jornadaVespertino); ?></td>
                    <td class="bg-danger bg-opacity-25"><strong>Entrada:</strong> <?php echo htmlspecialchars($entradaVespertino); ?></td>
                    <td class="bg-danger bg-opacity-25" colspan="3"><strong>Salida:</strong> <?php echo htmlspecialchars($salidaVespertino); ?></td>
                </tr>
                <tr>
                    <td class="bg-primary bg-opacity-25" colspan="2">Puede registrar su ingreso con 15 minutos de anticipación</td>
                    <td class="bg-primary bg-opacity-25" colspan="3">Puede registrar su salida con 10 minutos después de la hora</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../Modelo/selectRegister.php'; ?>
<?php include '../Modelo/getTime.php'; ?>

<!-- Contenedor flexible para iframe y texto -->
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center p-1 border">
        <div style="flex: 1; text-align: center;">
            <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FGuayaquil" width="100%" height="140" frameborder="0" seamless style="pointer-events:none;"></iframe>
        </div>
        <div style="flex: 1; text-align: center;">
            <?php
            if ($hora_actual_dt >= $entradaMatutinoMargin && $hora_actual_dt <= $salidaMatutinoMarginR) {
                echo "<p>Jornada En Curso: <strong>MATUTINA</strong></p>";
                if (!$matutinoRegistrado) {
                    echo '<button id="registrarIngresoMatutino" class="btn btn-primary mt-3 p-3">Registrar Ingreso</button>';
                } elseif ($hora_actual_dt >= $salidaMatutinoMargin && $hora_actual_dt <= $salidaMatutinoMarginR  && $matutinoSalidaRegistrada !== null) {
                    echo '<button id="registrarSalidaMatutino" class="btn btn-primary mt-3 p-3">Registrar Salida</button>';
                } else {
                    echo '<p>Ya se ha registrado el ingreso</p>';
                }
            } elseif ($hora_actual_dt >= $entradaVespertinoMargin && $hora_actual_dt <= $salidaVespertinoMarginR) {
                echo "<p>Jornada En Curso: <strong>VESPERTINA</strong></p>";
                if (!$vespertinoRegistrado) {
                    echo '<button id="registrarIngresoVespertino" class="btn btn-primary mt-3 p-3">Registrar Ingreso</button>';
                } elseif ($hora_actual_dt >= $salidaVespertinoMargin  && $hora_actual_dt <= $salidaVespertinoMarginR  && $vespertinoSalidaRegistrada !== null) {
                    echo '<button id="registrarSalidaVespertino" class="btn btn-primary mt-3 p-3">Registrar Salida</button>';
                } else {
                    echo '<p>Ya se ha registrado el ingreso</p>';
                }
            } else {
                echo "<p>Jornada En Curso: <strong>Fuera de Horario</strong></p>";
                echo '<button class="btn btn-primary mt-3 p-3" disabled>Inhabilitado</button>';
            }
            ?>

        </div>
    </div>
</div>
<br>

<!-- Tabla para mostrar los registros de asistencia -->
<div class="container">
    <div id="registrosTable" class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center;" class="bg-danger bg-opacity-25">Registros de Asistencia</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Jornada</th>
                    <th>Hora Ingreso</th>
                    <th>Hora Salida</th>
                    <th>Descuento</th>
                    <th>Horas por Jornada</th>
                    <th>Subtotal Jornada</th>
                </tr>
            </thead>
            <tbody>
                <?php $horaDeIngreso = "00:00:00" ?>
                <?php foreach ($registros as $registro) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registro['FECHA']); ?></td>
                        <td><?php echo htmlspecialchars($registro['JORNADA']); ?></td>
                        <td><?php echo htmlspecialchars($registro['HORA_INGRESO']); ?></td>
                        <?php $horaDeIngreso = $registro['HORA_INGRESO'] ?>
                        <td><?php echo htmlspecialchars($registro['HORA_SALIDA']); ?></td>
                        <td><?php echo htmlspecialchars($registro['DESCUENTO']); ?></td>
                        <td><?php echo htmlspecialchars($registro['HORAS_POR_JORNADA']); ?></td>
                        <td><?php echo htmlspecialchars($registro['SUBTOTAL_JORNADA']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function autoReloadPage() {
        setInterval(function() {
            window.location.reload();
        }, 60000); // 60000 milisegundos = 1 minuto 
    }

    function getCurrentDateTime(callback) {
        $.ajax({
            url: '../Modelo/getDateTime.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                callback(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching date and time:', error);
            }
        });
    }

    $(document).ready(function() {

        autoReloadPage();

        $('#registrarIngresoMatutino').on('click', function() {
            getCurrentDateTime(function(datetime) {
                let fecha = datetime.date;
                //let horaIngreso = datetime.time;
                let horaIngreso = "07:58:00";

                let idEmpPer = <?php echo json_encode($empleadoId); ?>;
                let jornada = 'MATUTINA';

                $.ajax({
                    url: '../Modelo/insertIngresoMatutino.php',
                    method: 'POST',
                    data: {
                        fecha: fecha,
                        jornada: jornada,
                        hora_ingreso: horaIngreso,
                        id_emp_per: idEmpPer
                    },
                    success: function(response) {
                        alert(response);
                        window.location.reload(); // Recargar la página completa
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });

        $('#registrarSalidaMatutino').on('click', function() {
            getCurrentDateTime(function(datetime) {
                let fecha = datetime.date;
                //let horaRegistroDeSalida = datetime.time;
                let horaRegistroDeSalida = "13:15:00";

                let idEmpPer = <?php echo json_encode($empleadoId); ?>;
                let horaEntrada = <?php echo json_encode($entradaMatutino); ?>;
                let horaSalida = <?php echo json_encode($salidaMatutino); ?>;
                let horaRegistroDeIngreso = <?php echo json_encode($horaDeIngreso); ?>;
                let jornada = 'MATUTINA';

                $.ajax({
                    url: '../Modelo/insertSalidaMatutino.php',
                    method: 'POST',
                    data: {
                        fecha: fecha,
                        jornada: jornada,
                        horaEntrada: horaEntrada,
                        horaSalida: horaSalida,
                        horaRegistroDeIngreso: horaRegistroDeIngreso,
                        horaRegistroDeSalida: horaRegistroDeSalida,
                        id_emp_per: idEmpPer
                    },
                    success: function(response) {
                        alert(response);
                        window.location.reload(); // Recargar la página completa
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });

        $('#registrarIngresoVespertino').on('click', function() {
            getCurrentDateTime(function(datetime) {
                let fecha = datetime.date;
                //let horaIngreso = datetime.time;
                let horaIngreso = "17:02:00";

                let idEmpPer = <?php echo json_encode($empleadoId); ?>;
                let jornada = 'VESPERTINA';

                $.ajax({
                    url: '../Modelo/insertIngresoVespertino.php',
                    method: 'POST',
                    data: {
                        fecha: fecha,
                        jornada: jornada,
                        hora_ingreso: horaIngreso,
                        id_emp_per: idEmpPer
                    },
                    success: function(response) {
                        alert(response);
                        window.location.reload(); // Recargar la página completa
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });

        $('#registrarSalidaVespertino').on('click', function() {
            getCurrentDateTime(function(datetime) {
                let fecha = datetime.date;
                //let horaRegistroDeSalida = datetime.time;
                let horaRegistroDeSalida = "20:15:00";

                let idEmpPer = <?php echo json_encode($empleadoId); ?>;
                let horaEntrada = <?php echo json_encode($entradaVespertino); ?>;
                let horaSalida = <?php echo json_encode($salidaVespertino); ?>;
                let horaRegistroDeIngreso = <?php echo json_encode($horaDeIngreso); ?>;
                let jornada = 'VESPERTINA';

                $.ajax({
                    url: '../Modelo/insertSalidaVespertino.php',
                    method: 'POST',
                    data: {
                        fecha: fecha,
                        jornada: jornada,
                        horaEntrada: horaEntrada,
                        horaSalida: horaSalida,
                        horaRegistroDeIngreso: horaRegistroDeIngreso,
                        horaRegistroDeSalida: horaRegistroDeSalida,
                        id_emp_per: idEmpPer
                    },
                    success: function(response) {
                        alert(response);
                        window.location.reload(); // Recargar la página completa
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });
    });
</script>