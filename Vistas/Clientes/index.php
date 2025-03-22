<?php include "Vistas/Templates/header.php";?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Clientes</li>
    </ol>
    <button class="btn btn-primary mb-2" type="button" onclick="frmCliente();">Nuevo Cliente <i class="fas fa-plus"></i> </button>
    
    <table class="table table-light" id="tblClientes">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nacionalidad</th>
                <th>Tipo de Cédula</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="nuevo_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" >
                    <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post" id="frmCliente">
                <input type="hidden" id="modo" value="nuevo"> <!-- para formulario nuevo -->
                    <div class="form-group">
               
                        <label for="nacionalidad">Nacionalidad</label>
                        <select id="nacionalidad" class="form-control" name="nacionalidad" onchange="toggleDocumento()">
                            <option value="">Seleccione</option>
                            <option value="Nacional">Nacional</option>
                            <option value="Internacional">Internacional</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="tipoDocumentoNacional" style="display: none;">
                        <label for="tipoCedulaNacional">Tipo de Cédula</label>
                        <select id="tipoCedulaNacional" class="form-control" name="tipoCedulaNacional">
                            <option value="">Seleccione</option>
                            <option value="Fisica">Cédula Física</option>
                            <option value="Juridica">Cédula Jurídica</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="tipoDocumentoInternacional" style="display: none;">
                        <label for="tipoCedulaInternacional">Tipo de Documento</label>
                        <select id="tipoCedulaInternacional" class="form-control" name="tipoCedulaInternacional">
                            <option value="">Seleccione</option>
                            <option value="Pasaporte">Pasaporte</option>
                            <option value="Cedula_Residente">Cédula de Residente</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="cedula">Cédula / Documento</label>
                        <input type="hidden" id="id" name="id">
                        <input id="cedula" class="form-control" type="text" name="cedula" placeholder="Ingrese el Documento">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Cliente">
                    </div>
                    <div class="form-group">
                        <label for="apellido1">Primer Apellido</label>
                        <input id="apellido1" class="form-control" type="text" name="apellido1" placeholder="Primer Apellido">
                    </div>
                    <div class="form-group">
                        <label for="apellido2">Segundo Apellido</label>
                        <input id="apellido2" class="form-control" type="text" name="apellido2" placeholder="Segundo Apellido">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" class="form-control" name="direccion" rows="3" placeholder="Dirección"></textarea>
                    </div>

                    <button class="btn btn-primary" type="button" onclick="registrarCli(event)" id="btnModificar">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
</form>
                </div>
            </div>
        </div>
    </div>
<?php include "Vistas/Templates/footer.php";?>



