<?php include "Vistas/Templates/header.php";?>
<div class="col-md-6 mx-auto">

    <div class="card">
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
        <div class="card-header text-center text-white bg-primary">

            Asignar Permisos

         </div>
         <div class="card-body">
         <form id="formulario" onsubmit="registrarPermisos(event)">
    <div class="row">
        <?php foreach ($data['datos'] as $row) { ?>
            <div class="col-md-4 text-center text-capitalize">
                <div class="permission-item">
                    <label class="permission-label"><?php echo $row['nombre_permiso']; ?></label>
                    <label class="button-checkbox">
                    <input type="checkbox" name="permisos[]" value="<?php echo $row['id_permiso']; ?>" id="checkbox_<?php echo $row['id_permiso']; ?>" <?php echo isset($data['asignados'][$row['id_permiso']]) ? 'checked' : ''; ?>>
                        <span class="button-slider"></span>
                    </label>
                </div>
            </div>
        <?php } ?>
        <input type="hidden" name="id_rol" value="<?php echo $data['id_rol']; ?>">
    </div>
    
    <div class="button-group mt-3">
        <button class="btn btn-outline-primary w-100" type="submit" >Aceptar</button>
        <button class="btn btn-outline-danger w-100" type="button" onclick="window.location.href='<?php echo base_url; ?>Roles_Permisos'">Cancelar</button>
    </div>
</form>
            </div>
    </div>

</div>

<?php include "Vistas/Templates/footer.php";?>