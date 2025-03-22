<?php include "Vistas/Templates/header.php";?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Roles y Permisos</li>
    </ol>
    <button class="btn btn-primary mb-2" type="button" onclick="frmRoles();"> Nuevo Rol <i class="fas fa-plus"></i> </button>
    
    <table class="table table-light" id="tblRoles">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Descripción del Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="nuevo_rol" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" >
                    <h5 class="modal-title text-white" id="title">Nuevo Rol</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frmMedida">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="hidden" id="id" name="id">
                            <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Rol">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripción del Rol">
                        </div>            
                       
                        <button class="btn btn-primary" type="button" onclick="registrarRol(event)" id="btnModificar">Registrar</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal" >Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include "Vistas/Templates/footer.php";?>