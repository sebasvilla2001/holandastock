<?php include "Vistas/Templates/header.php";?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Historial de Compras</li>
    </ol>
    <form action="<?php echo base_url;?>Compras/pdf" method="POST" target="_blank">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="min">Desde:</label>
                    <input type="date"  class="form-control" value="<?php echo date('Y-m-d');?>" name="desde" id="min">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="hasta">Hasta:</label>
                    <input type="date"  class="form-control" value="<?php echo date('Y-m-d');?>" name="hasta" id="hasta">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" class="btm btn-danger"> PDF </button>
                </div>
            </div>
        </div>
    </form>
    <table class="table table-light" id="t_historial_c">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Fecha Compra</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
<?php include "Vistas/Templates/footer.php";?>
