<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Docentes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Listado Docentes</h2>
    <button class="btn btn-primary mb-3" onclick="newEmpleado()">Nuevo Empleado</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Contraseña</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="employeesTable">
            <!-- Los datos de los empleados se cargarán aquí -->
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Empleado -->
<div class="modal fade" id="empleadoModal" tabindex="-1" aria-labelledby="empleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="empleadoModalLabel">Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="empleadoForm">
                    <input type="hidden" id="id_emp" name="id_emp">
                    <div class="mb-3">
                        <label for="ced_emp" class="form-label">Cédula:</label>
                        <input type="text" class="form-control" id="ced_emp" name="ced_emp" required>
                        <div id="cedulaError" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pass_emp" class="form-label">Contraseña:</label>
                        <input type="text" class="form-control" id="pass_emp" name="pass_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom_emp" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nom_emp" name="nom_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="ape_emp" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="ape_emp" name="ape_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="corr_emp" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="corr_emp" name="corr_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="est_emp" class="form-label">Estado:</label>
                        <select class="form-select" id="est_emp" name="est_emp" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rol_emp" class="form-label">Rol:</label>
                        <select class="form-select" id="rol_emp" name="rol_emp" required>
                            <option value="ADMIN">Admin</option>
                            <option value="DOCENTE">Docente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Empleado -->
<div class="modal fade" id="empleadoModalEdit" tabindex="-1" aria-labelledby="empleadoModalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="empleadoModalEditLabel">Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="empleadoEditForm">
                    <input type="hidden" id="id_emp_edit" name="id_emp">
                    <div class="mb-3">
                        <label for="ced_emp_edit" class="form-label">Cédula:</label>
                        <input type="text" class="form-control" id="ced_emp_edit" name="ced_emp" required>
                        <div id="cedulaErrorEdit" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pass_emp_edit" class="form-label">Contraseña:</label>
                        <input type="text" class="form-control" id="pass_emp_edit" name="pass_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom_emp_edit" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nom_emp_edit" name="nom_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="ape_emp_edit" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="ape_emp_edit" name="ape_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="corr_emp_edit" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="corr_emp_edit" name="corr_emp" required>
                    </div>
                    <div class="mb-3">
                        <label for="est_emp_edit" class="form-label">Estado:</label>
                        <select class="form-select" id="est_emp_edit" name="est_emp" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rol_emp_edit" class="form-label">Rol:</label>
                        <select class="form-select" id="rol_emp_edit" name="rol_emp" required>
                            <option value="ADMIN">Admin</option>
                            <option value="DOCENTE">Docente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnGuardarEdit">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        loadEmployees();

        $('#empleadoForm').on('submit', function(event) {
            event.preventDefault();
            var id_emp = $('#id_emp').val();
            if (id_emp === '') {
                saveNewEmpleado();
            }
        });

        $('#empleadoEditForm').on('submit', function(event) {
            event.preventDefault();
            var id_emp = $('#id_emp_edit').val();
            if (id_emp !== '') {
                saveEmpleadoEdit(id_emp);
            }
        });

        // Validación de cédula: debe tener exactamente 10 dígitos numéricos
        $('#ced_emp').on('input', function() {
            var cedula = $(this).val().trim();
            if (cedula.length === 10 && /^\d+$/.test(cedula)) {
                $(this).removeClass('is-invalid');
                $('#cedulaError').text('');
                $('#btnGuardar').prop('disabled', false); // Habilitar botón de guardar si la cédula es válida
            } else {
                $(this).addClass('is-invalid');
                $('#cedulaError').text('La cédula debe contener 10 dígitos numéricos.');
                $('#btnGuardar').prop('disabled', true); // Deshabilitar botón de guardar si la cédula no es válida
            }
        });

        $('#empleadoModal').on('hidden.bs.modal', function() {
            resetForm();
        });

        $('#empleadoModalEdit').on('hidden.bs.modal', function() {
            resetForm();
        });
    });

    function resetForm() {
        $('#empleadoForm')[0].reset();
        $('#empleadoEditForm')[0].reset();
        $('#id_emp').val('');
        $('#id_emp_edit').val('');
        $('#ced_emp').prop('readonly', false); // Permitir edición de cédula al agregar nuevo empleado
        $('#ced_emp').removeClass('is-invalid');
        $('#cedulaError').text('');
        $('#btnGuardar').prop('disabled', false); // Habilitar botón de guardar al abrir nuevamente el modal
    }

    function loadEmployees() {
        $.getJSON('../Modelo/docente.php', function(data) {
            var $table = $('#employeesTable');
            $table.empty();
            $.each(data, function(key, val) {
                var estado = (val.EST_EMP == 1) ? 'Activo' : 'Inactivo';
                $table.append('<tr>' +
                    '<td>' + val.CED_EMP + '</td>' +
                    '<td>' + val.PASS_EMP + '</td>' +
                    '<td>' + val.NOM_EMP + '</td>' +
                    '<td>' + val.APE_EMP + '</td>' +
                    '<td>' + val.CORR_EMP + '</td>' +
                    '<td>' + val.ROL_EMP + '</td>' +
                    '<td>' + estado + '</td>' +
                    '<td>' +
                    '<button class="btn btn-warning btn-sm" onclick="editEmpleado(' + val.ID_EMP + ')">Editar</button> ' +
                    '<button class="btn btn-danger btn-sm" onclick="deleteEmpleado(' + val.ID_EMP + ')">Eliminar</button>' +
                    '</td>' +
                    '</tr>');
            });
        });
    }

    function newEmpleado() {
        resetForm();
        $('#empleadoModalLabel').text('Nuevo Empleado');
        $('#empleadoModal').modal('show');
    }

    function editEmpleado(id) {
        $.getJSON('../Modelo/docenteID.php', { id_emp: id }, function(data) {
            $('#id_emp_edit').val(data.ID_EMP);
            $('#ced_emp_edit').val(data.CED_EMP);
            $('#pass_emp_edit').val(data.PASS_EMP);
            $('#nom_emp_edit').val(data.NOM_EMP);
            $('#ape_emp_edit').val(data.APE_EMP);
            $('#corr_emp_edit').val(data.CORR_EMP);
            $('#est_emp_edit').val(data.EST_EMP);
            $('#rol_emp_edit').val(data.ROL_EMP);
            $('#empleadoModalEditLabel').text('Editar Empleado');
            $('#empleadoModalEdit').modal('show');

            // Restablecer validación y estado de los campos
            $('#ced_emp_edit').removeClass('is-invalid');
            $('#cedulaErrorEdit').text('');
            $('#btnGuardarEdit').prop('disabled', false);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error al cargar datos del empleado:", textStatus, errorThrown);
            // Puedes mostrar un mensaje de error o manejar la falla de otra manera aquí
        });
    }

    function saveNewEmpleado() {
        $.ajax({
            url: '../Modelo/agregar_docente.php',
            method: 'POST',
            data: $('#empleadoForm').serialize(),
            success: function(response) {
                $('#empleadoModal').modal('hide');
                loadEmployees();
            }
        });
    }

    function saveEmpleadoEdit(id) {
        $.ajax({
            url: '../Modelo/editar_docente.php',
            method: 'POST',
            data: $('#empleadoEditForm').serialize(),
            success: function(response) {
                $('#empleadoModalEdit').modal('hide');
                loadEmployees();
            }
        });
    }

    function deleteEmpleado(id) {
        if (confirm('¿Está seguro?')) {
            $.post('../Modelo/eliminar_docente.php', { id_emp: id }, function(response) {
                loadEmployees();
            });
        }
    }
</script>

</body>
</html>
