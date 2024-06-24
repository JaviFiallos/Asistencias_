<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Gestión de Usuarios</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
    color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;
}
.table-responsive {
    margin: 30px 0;
}
.table-wrapper {
    background: #fff;
    padding: 20px 25px;
    border-radius: 3px;
    min-width: 1000px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {        
    padding-bottom: 15px;
    background: #2048cc;
    color: #fff;
    padding: 16px 30px;
    min-width: 100%;
    margin: -20px -25px 10px;
    border-radius: 3px 3px 0 0;
}
.table-title h2 {
    margin: 5px 0 0;
    font-size: 24px;
}
.table-title .btn-group {
    float: right;
}
.table-title .btn {
    color: #fff;
    float: right;
    font-size: 13px;
    border: none;
    min-width: 50px;
    border-radius: 2px;
    border: none;
    outline: none !important;
    margin-left: 10px;
}
.table-title .btn i {
    float: left;
    font-size: 21px;
    margin-right: 5px;
}
.table-title .btn span {
    float: left;
    margin-top: 2px;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
    padding: 12px 15px;
    vertical-align: middle;
}
table.table tr th:first-child {
    width: 60px;
}
table.table tr th:last-child {
    width: 100px;
}
table.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
    background: #f5f5f5;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}   
table.table td:last-child i {
    opacity: 0.9;
    font-size: 22px;
    margin: 0 5px;
}
table.table td a {
    font-weight: bold;
    color: #566787;
    display: inline-block;
    text-decoration: none;
    outline: none !important;
}
table.table td a:hover {
    color: #2196F3;
}
table.table td a.edit {
    color: #FFC107;
}
table.table td a.delete {
    color: #F44336;
}
table.table td i {
    font-size: 19px;
}
table.table .avatar {
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 10px;
}
.pagination {
    float: right;
    margin: 0 0 5px;
}
.pagination li a {
    border: none;
    font-size: 13px;
    min-width: 30px;
    min-height: 30px;
    color: #999;
    margin: 0 2px;
    line-height: 30px;
    border-radius: 2px !important;
    text-align: center;
    padding: 0 6px;
}
.pagination li a:hover {
    color: #666;
}   
.pagination li.active a, .pagination li.active a.page-link {
    background: #03A9F4;
}
.pagination li.active a:hover {        
    background: #0397d6;
}
.pagination li.disabled i {
    color: #ccc;
}
.pagination li i {
    font-size: 16px;
    padding-top: 6px
}
.hint-text {
    float: left;
    margin-top: 10px;
    font-size: 13px;
}    
/* Custom checkbox */
.custom-checkbox {
    position: relative;
}
.custom-checkbox input[type="checkbox"] {    
    opacity: 0;
    position: absolute;
    margin: 5px 0 0 3px;
    z-index: 9;
}
.custom-checkbox label:before{
    width: 18px;
    height: 18px;
}
.custom-checkbox label:before {
    content: '';
    margin-right: 10px;
    display: inline-block;
    vertical-align: text-top;
    background: white;
    border: 1px solid #bbb;
    border-radius: 2px;
    box-sizing: border-box;
    z-index: 2;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
    content: '';
    position: absolute;
    left: 6px;
    top: 3px;
    width: 6px;
    height: 11px;
    border: solid #000;
    border-width: 0 3px 3px 0;
    transform: inherit;
    z-index: 3;
    transform: rotateZ(45deg);
}
.custom-checkbox input[type="checkbox"]:checked + label:before {
    border-color: #03A9F4;
    background: #03A9F4;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
    border-color: #fff;
}
.custom-checkbox input[type="checkbox"]:disabled + label:before {
    color: #b8b8b8;
    cursor: auto;
    box-shadow: none;
    background: #ddd;
}
/* Modal styles */
.modal .modal-dialog {
    max-width: 400px;
}
.modal .modal-header, .modal .modal-body, .modal .modal-footer {
    padding: 20px 30px;
}
.modal .modal-content {
    border-radius: 3px;
    font-size: 14px;
}
.modal .modal-footer {
    background: #ecf0f1;
    border-radius: 0 0 3px 3px;
}
.modal .modal-title {
    display: inline-block;
}
.modal .form-control {
    border-radius: 2px;
    box-shadow: none;
    border-color: #dddddd;
}
.modal textarea.form-control {
    resize: vertical;
}
.modal .btn {
    border-radius: 2px;
    min-width: 100px;
}   
.modal form label {
    font-weight: normal;
}   
</style>
<script>
$(document).ready(function(){
    // Activar tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    // Seleccionar/deseleccionar checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;                        
            });
        } else{
            checkbox.each(function(){
                this.checked = false;                        
            });
        } 
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });

    // Manejar el envío del formulario de agregar usuario mediante AJAX
    $('#addEmployeeModal form').submit(function(e) {
        e.preventDefault(); 

        var formData = $(this).serialize(); 
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            success: function(response) {
                alert("Empleado creado con éxito");
                $('#addEmployeeModal').modal('hide');
                refreshTable();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error al agregar el usuario. Inténtelo de nuevo más tarde.');
            }
        });
    });

    // Manejar la eliminación de usuario
    $('#deleteEmployeeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var cedula = button.data('id'); // Extraer el ID del usuario a eliminar
        var modal = $(this);
        modal.find('.modal-footer #deleteBtn').attr('data-id', cedula); // Asignar ID al botón de eliminación en el modal

        $('#deleteBtn').click(function(){
            var cedula = $(this).attr('data-id'); // Obtener el ID del usuario a eliminar

            $.ajax({
                type: 'POST',
                url: '../Modelo/eliminar_docente.php', 
                data: { cedula: cedula }, 
                dataType: 'json',
                success: function(response) {
                    alert('Usuario eliminado con éxito');
                    $('#deleteEmployeeModal').modal('hide');
                    refreshTable();
                },
                error: function(xhr, status, error) {
                    // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
                    console.error(xhr.responseText);
                    alert('Usuario eliminado con exito');
                    $('#deleteEmployeeModal').modal('hide');
                    refreshTable();
                }
            });
        });
    });

    // Abrir el modal de edición y llenar los campos
    $('a.edit').click(function(){
        // Reiniciar los campos del modal de edición
        $('#editForm')[0].reset();

        // Obtener los datos de la fila seleccionada
        var row = $(this).closest('tr');
        var cedula = row.find('td:eq(1)').text().trim();
        var contrasena = row.find('td:eq(2)').text().trim();
        var nombre = row.find('td:eq(3)').text().trim();
        var apellido = row.find('td:eq(4)').text().trim();
        var correo = row.find('td:eq(5)').text().trim();
        var rol = row.find('td:eq(6)').text().trim();

        // Llenar los campos del formulario de edición con los datos obtenidos
        $('#edit_cedula').val(cedula);
        $('#edit_contrasena').val(contrasena);
        $('#edit_nombre').val(nombre);
        $('#edit_apellido').val(apellido);
        $('#edit_correo').val(correo);
        $('#edit_rol').val(rol);

        // Mostrar el modal de edición
        $('#editEmployeeModal').modal('show');
    });

    // Manejar el envío del formulario de edición mediante AJAX
    $('#editForm').submit(function(e) {
        e.preventDefault(); 

        var formData = $(this).serialize(); 
        $.ajax({
            type: 'POST',
            url: '../Modelo/editar_docente.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                alert("Usuario actualizado con éxito");
                $('#editEmployeeModal').modal('hide');
                $('#editForm')[0].reset(); // Reiniciar el formulario de edición
                refreshTable();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error al actualizar el usuario. Inténtelo de nuevo más tarde.');
            }
        });
    });

    // Función para actualizar la tabla después de una operación de CRUD
    function refreshTable() {
        $('tbody').load('../Modelo/docente.php'); 
    }
});

</script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gestión de <b>Usuarios</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Agregar Nuevo Usuario</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Eliminar</span></a>                      
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>Cédula</th>
                        <th>Contraseña</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../Modelo/docente.php'; ?>
                </tbody>
            </table>
            <div class="clearfix">
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Anterior</a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">Siguiente</a></li>
                </ul>
            </div>
        </div>
    </div>        
</div>
<!-- Agregar Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../Modelo/agregar_docente.php" method="post">
                <div class="modal-header">                      
                    <h4 class="modal-title">Agregar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">                  
                    <div class="form-group">
                        <label>Cédula</label>
                        <input type="text" name="cedula" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <select name="rol" class="form-control" required>
                            <option value="Administrador">ADMIN</option>
                            <option value="Docente">DOCENTE</option>
                        </select>
                    </div>       
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Agregar">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Editar Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">                      
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">                  
                    <div class="form-group">
                        <label>Cédula</label>
                        <input type="text" name="cedula" id="edit_cedula" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="contrasena" id="edit_contrasena" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" id="edit_apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" id="edit_correo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <select name="rol" id="edit_rol" class="form-control" required>
                            <option value="Administrador">ADMIN</option>
                            <option value="Docente">DOCENTE</option>
                        </select>
                    </div>       
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-info" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Eliminar Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">                      
                    <h4 class="modal-title">Eliminar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">                  
                    <p>¿Estás seguro que deseas eliminar este registro?</p>
                    <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <button type="button" class="btn btn-danger deleteBtn" id="deleteBtn">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
