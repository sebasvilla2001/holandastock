<?php include "Vistas/Templates/header.php";?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Datos de la Empresa</li>
       
    </ol>
<div class="card">

    <div class="card-body">
        <form id="frmEmpresa">
            <div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                    <input id="id" class="form-control" type="Hidden" name="id" value="<?php echo $data['con_id'];?>">
                    <label for="nombre">Nombre de la Empresa</label>
                    <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre de la Empresa" value="<?php echo $data['con_nombre'];?>">
                 </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input id="cedula" class="form-control" type="text" name="cedula" disabled value="<?php echo $data['con_cedula'];?>">
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" value="<?php echo $data['con_telefono'];?>">
                 </div>
            </div>
            <div class="col-md-6">  
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" value="<?php echo $data['con_direccion'];?>">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" class="form-control" name="mensaje" placeholder="Mensaje" rows="3" ><?php echo $data['con_mensaje'];?></textarea>
            </div>
            </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="modificarEmpresa()" id="btnModificar">Modificar</button>
        </form>
    </div>
</div>

<?php include "Vistas/Templates/footer.php";?>