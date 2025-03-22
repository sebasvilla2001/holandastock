<?php include "Vistas/Templates/header.php";?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>
    <button class="btn btn-primary mb-2" type="button" onclick="frmUsuario();">Nuevo Usuario <i class="fas fa-plus"></i> </button>
    
    <table class="table table-light" id="tblUsuarios">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Caja</th>
                <th>Roles</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="nuevo_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" >
                    <h5 class="modal-title text-white" id="title">Nuevo Usuario</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frmUsuario">
                    <input type="hidden" id="modo" value="nuevo"> <!-- para formulario nuevo -->
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="hidden" id="id" name="id">
                            <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Ingrese un Usuario">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Usuario">
                        </div>
                        <div class="form-group">
                            <label for="apellido1">Primer Apellido</label>
                            <input id="apellido1" class="form-control" type="text" name="apellido1" placeholder="Primer Apellido">
                        </div>
                        <div class="form-group">
                            <label for="apellido2">Segundo Apellido</label>
                            <input id="apellido2" class="form-control" type="text" name="apellido2" placeholder="Segundo Apellido">
                        </div>
                        <div class="row" id="claves">
                            <div class="col md6">
                                <div class="form-group">
                                    <label for="clave">Contraseña</label>
                                    <input id="clave" class="form-control" type="password" name="clave" placeholder="Ingrese una Contraseña">
                                </div>
                            </div>

                            <div class="col md6">
                                <div class="form-group">
                                    <label for="confirmar">Confirmar Contraseña</label>
                                    <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirme la contraseña">
                                </div>
                            </div>
                            
                       </div>
                        <div class="form-group">
                            <label for="caja">Caja</label>
                            <select id="caja" class="form-control" name="caja">
                            <?php foreach ($data['cajas'] as $row) { ?>
                                <option value="<?php echo $row['caja_id']?>"><?php echo $row['caja_caja']?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rol">Roles</label>
                            <select id="rol" class="form-control" name="rol">
                            <?php foreach ($data['roles'] as $row) { ?>
                                <option value="<?php echo $row['id_rol']?>"><?php echo $row['nombre_rol']?></option>
                            <?php }?>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="button" onclick="registrarUser(event)" id="btnModificar">Registrar</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal" >Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include "Vistas/Templates/footer.php";?>



