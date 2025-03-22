<?php include "Vistas/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Bitacora de Movimientos</li>
</ol>

<!-- Formulario de filtros -->
<form id="formFiltro"  method="POST">
    <div class="row mb-3">
        <div class="col">
            <label for="desde">Desde:</label>
            <input type="date" class="form-control"  name="desde" id="desde">
        </div>
        <div class="col">
            <label for="hasta">Hasta:</label>
            <input type="date" class="form-control"   name="hasta" id="hasta">
        </div>
        <div class="col">
            <label for="usuario">Usuario:</label>
            <select class="form-control" id="usuario" name="usuario">
                <option value="">Seleccione un usuario</option>
                <?php foreach ($data as $row) { ?>
                    <option value="<?php echo $row['user_usuario']?>"><?php echo $row['user_usuario']?></option> 
                <?php }?>                   
            </select>
        </div>
        <div class="col">
            <label for="tipo_movimiento">Tipo de Movimiento:</label>
            <select class="form-control" id="tipo_movimiento" name="tipo_movimiento">
                <option value="">Seleccione un tipo de movimiento</option>
                <option value="Insertar">Insertar</option>
                <option value="Modificar">Modificar</option>
                <option value="Inhabilitar">Inhabilitar</option>
                <option value="Habilitar">Habilitar</option>
            </select>
        </div>
        <div class="col-md-3">
    <div class="form-group">
    <button type="button" id="btnFiltrar" class="btn btn-primary btn-block">Filtrar</button>

    </div>
    </div>
</div>
</form>

<table class="table table-light" id="tblMov">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Tipo de Movimiento</th>
            <th>Fecha</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody id="tablaResultados">
        <!-- Aquí se insertarán los resultados dinámicamente -->
    </tbody>
</table>
<?php include "Vistas/Templates/footer.php"; ?>