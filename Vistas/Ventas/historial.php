<?php include "Vistas/Templates/header.php";?>
<ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Hitorial de Ventas</li>
    </ol>
    <form action="<?php echo base_url;?>Ventas/pdf"  method="POST" target="_blank">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="desde">Desde:</label>
                    <input type="date"  class="form-control"  value="<?php echo date('Y-m-d');?>" name="desde" id="desde">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="hasta">Hasta:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="hasta" id="hasta">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" class="btm btn-danger"> PDF </button>
                </div>
            </div>
        </div>
    </form>
    <table class="table table-light" id="t_historial_v">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Fecha Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
<?php include "Vistas/Templates/footer.php";?>
