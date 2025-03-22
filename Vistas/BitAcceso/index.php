<?php include "Vistas/Templates/header.php"; ?>

<div class="header-container">
    <div class="image">
    </div>
</div>

<!-- Tabla de Accesos -->
<ol class="breadcrumb mb-4 no-style">
    <li class="breadcrumb-item active">Bitácora de Acceso</li>
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
        <div class="col-md-3">
    <div class="form-group">
    <button type="button" id="btnFiltrar" class="btn btn-primary btn-block">Filtrar</button>

    </div>
    </div>
</div>
<table class="table table-light" id="tblAcceso">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de Salida</th>
        </tr>
    </thead>
    <tbody>
        <section id="tabla_resultado"> </section>  
    </tbody>
</table>

<?php include "Vistas/Templates/footer.php"; ?>