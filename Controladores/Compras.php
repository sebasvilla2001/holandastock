<?php

class Compras extends Controller{

    public function __construct(){
        session_start();
        parent::__construct();

    }

    public function index(){

        $id_rol = $_SESSION['id_rol'];
        $verificar = $this->model->verificarPermiso($id_rol, 'Compras');
        if (!empty($verificar) || $id_rol == 1 ) {
            $this->views->getView($this, "index");
        } else {
            header('Location: ' .base_url. 'Errors/permisos');
        }



    }

    public function buscarCodigo($codigo){
         $data = $this->model->getProCod($codigo);
         echo json_encode($data, JSON_UNESCAPED_UNICODE);
         die();
    }

    public function ingresar(){
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);      
        $id_pro = $datos[0]['pro_id'];
        $id_user = $_SESSION['id_usuario'];
        $precio = $datos[0]['pro_precio_compra'];
        $cantidad = $_POST['cantidad'];
        $nombre = $datos[0]['pro_descripcion'];
        $comprobar = $this->model->consultarDetalle($id_pro, $id_user);
        if (empty($comprobar)) {
            $subtotal = $precio * $cantidad;
            $data =$this->model->registrarDetalle($id_pro, $id_user, $precio, $cantidad, $subtotal);
            $mensaje = 'Insertar';
                $datos_cliente = array(
                    "nombre" => $nombre,
                    "cantidad" => $cantidad,
                    "subtotal" => $subtotal
                );
            if ($data == "ok") {
                $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                $msg = "ok";
            }else{
                 $msg = "Error al regiestrar el producto";
            }
        }else{
            $total_cantidad = $comprobar['det_cantidad'] + $cantidad;
            $subtotal= $total_cantidad * $precio;
            $data =$this->model->actualizarDetalle($precio, $total_cantidad, $subtotal, $id_pro, $id_user);
            $mensaje = 'Modificar';
            $datos_cliente = array(
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "subtotal" => $subtotal
            );
            if ($data == "modificado") {
                $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                $msg = "modificado";
            }else{
                 $msg = "Error al modificar el producto";
            }

        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
   }

   public function listar(){
    $id_usuario = $_SESSION['id_usuario'];
    $data['detalle'] = $this->model->getDetalle($id_usuario);  
    $data['total_pagar'] = $this->model->calcularCompra($id_usuario); 
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
    }

    public function delete($id){
        $datos = $this->model->getDetalleBit($id);
        $id_pro = $datos[0]['det_id_pro']; 
        $datos_pro =  $this->model->getProductos($id_pro);
        $nombre = $datos_pro[0]['pro_descripcion']; 
        $data = $this->model->deleteDetalle($id);  
        if ($data == "ok") {
            $mensaje = 'Inhabilitar';
            $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
            $msg = "ok";
        }else{

            $msg = "Error al eliminar el producto";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();

     }

     public function registararCompra(){
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularCompra($id_usuario); 
        $data = $this->model->registararCompra($total['total']); 
        // Validar que el total no sea nulo o incorrecto
        $total = $this->model->calcularCompra($id_usuario);
        if (!$total || !isset($total['total']) || !is_numeric($total['total']) || $total['total'] <= 0) {
            $msg = array('msg' => 'Error al calcular el total de la compra. Verifique los detalles del carrito.', 'icono' => 'error');
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        if ($data == 'ok') {
            $detalle = $this->model->getDetalle($id_usuario);  
            $id_compra = $this->model->id_compra();
            foreach ($detalle as $row) {
                $cantidad = $row['det_cantidad'];
                $precio = $row['det_precio'];
                $id_producto = $row['det_id_pro'];
                $sub_total = $cantidad * $precio;
                $this->model->registrarDetalleCompra($id_compra['id'], $id_producto, $cantidad, $precio, $sub_total);
                $stock_actual = $this->model->getProductos($id_producto);
                // var_dump($stock_actual); // Muestra el contenido del arreglo
                // die();   
                $stock = $stock_actual[0]['pro_cantidad'] + $cantidad; 
                $this->model->actualizarStock($stock, $id_producto);
            }
            $vaciar = $this->model->vaciarDetalle($id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
            }
        }else{
            $msg = 'Error al realizar la compra';
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
     }

     public function generarPdf($id_compra)
     {
         $empresa = $this->model->getEmpresa();
         $productos = $this->model->getProCompra($id_compra);
     
         require('Libraries/fpdf/fpdf.php');
     
         $pdf = new FPDF();
         $pdf->AddPage();
         $pdf->SetMargins(10, 10, 10);
         $pdf->SetTitle('Reporte Compra');
         
         // Encabezado de la empresa
         $pdf->SetFont('Arial', 'B', 14);
         $pdf->Cell(0, 10, utf8_decode($empresa['con_nombre']), 0, 1, 'C');
         $imageX = $pdf->GetPageWidth() - 10 - 30; // 10 es el margen derecho, 30 es el ancho de la imagen
         $pdf->Image(base_url . 'Assets/img/logo.png', $imageX, 10, 35, 40); // Ajuste de posición y tamaño del logo
         $pdf->Ln(15); // Espaciado debajo del encabezado
     
         // Información de la empresa
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Cédula: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->MultiCell(0, 5, utf8_decode($empresa['con_cedula']), 0, 'L'); 
     
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(60, 5, $empresa['con_telefono'], 0, 1, 'L');
     
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->MultiCell(0, 5, utf8_decode($empresa['con_direccion']), 0, 'L'); 
     
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, 'Compra No: ', 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(0, 5, $id_compra, 0, 1, 'L');
     
         $pdf->Ln(5);
     
         // Encabezado de productos
         $pdf->SetFillColor(0, 0, 0);
         $pdf->SetTextColor(255, 255, 255);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 7, 'Cantidad', 1, 0, 'C', true);
         $pdf->Cell(80, 7, utf8_decode('Descripción'), 1, 0, 'C', true);
         $pdf->Cell(30, 7, utf8_decode('Precio'), 1, 0, 'C', true); 
         $pdf->Cell(30, 7, utf8_decode('Sub Total'), 1, 1, 'C', true);
     
         // Productos
         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetFont('Arial', '', 9);
         $total = 0.00;
         foreach ($productos as $row) {
             $total = $total + $row['deco_subtotal'];
             $horaActual = $row['comp_fecha'];
             $pdf->Cell(20, 6, $row['deco_cantidad'], 1, 0, 'C');
             $pdf->Cell(80, 6, utf8_decode($row['pro_descripcion']), 1, 0, 'L'); 
             $pdf->Cell(30, 6, number_format($row['deco_precio'], 2), 1, 0, 'R'); 
             $pdf->Cell(30, 6, number_format($row['deco_subtotal'], 2), 1, 1, 'R'); 
         }
     
         // Total general
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(130, 7, 'Total a Pagar', 1, 0, 'R');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(30, 7, number_format($total, 2), 1, 1, 'R');
     
         // Pie de página
         $pdf->SetY(-26);
         $pdf->SetFont('Arial', 'I', 8);
         $pdf->Cell(0, 5, utf8_decode('Reporte generado el: ') . $horaActual, 0, 0, 'L'); //revisar fecha y hora que no es correcto
         $pdf->Cell(0, 5, utf8_decode('Página ') . $pdf->PageNo(), 0, 1, 'R');

         $pdf->Output();
     }

     public function historial(){
        $this->views->getView($this, "historial");

     }

     public function listar_historial(){
        $data = $this->model->getHistorialcompras(); 
        for ($i=0; $i < count($data) ; $i++) { 
            $data[$i]['acciones'] = '<div>
            <a class="btn btn-danger" href="'.base_url."Compras/generarPdf/".$data[$i]['comp_id'].'" target="_blank"><i class= "fas fa-file-pdf"></i></a>
             </div>';
          }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
     }

     public function pdf()
     {
        $empresa = $this->model->getEmpresa();
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
         if (empty($desde) || empty($hasta) ) {
            $data = $this->model->getHistorialcompras();
         }else {
            $desde .= " 00:00:00";
            $hasta .= " 23:59:59";
            $data = $this->model->getRangoFechas($desde, $hasta);
         }
         $horaActual = date("H:i:s");
         require('Libraries/fpdf/fpdf.php');
     
         $pdf = new FPDF();
         $pdf->AddPage();
         $pdf->SetMargins(10, 10, 10);
         $pdf->SetTitle('Reporte Compras');
         $pdf->SetFont('Arial', 'B', 14);
                // Encabezado de la empresa
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode($empresa['con_nombre']), 0, 1, 'C');
        
        // Logo de la empresa
        $imageX = $pdf->GetPageWidth() - 10 - 30; // Ajustar posición del logo
        $pdf->Image(base_url . 'Assets/img/logo.png', $imageX, 10, 35, 40);
        $pdf->Ln(15);
        
        // Información de la empresa
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(60, 5, $empresa['con_telefono'], 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 5, utf8_decode($empresa['con_direccion']), 0, 'L');
        
        // Espacio antes de la tabla
        $pdf->Ln(5);
        
        // Encabezado de la tabla
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(30, 7, 'ID Venta', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Total', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'Fecha', 1, 1, 'C', true);
        
        // Datos de ventas
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $totalGeneral = 0;
        
        foreach ($data as $row) {
            $pdf->Cell(30, 6, $row['comp_id'], 1, 0, 'C');
            $pdf->Cell(40, 6, number_format($row['comp_total'], 2), 1, 0, 'R');
            $pdf->Cell(50, 6, $row['comp_fecha'], 1, 1, 'C');
            $totalGeneral += $row['comp_total'];
        }

        
        
        // Total general
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(0, 0, 0); // Fondo negro
        $pdf->SetTextColor(255, 255, 255); // Texto blanco
        $pdf->Cell(70, 7, 'Total General:', 1, 0, 'R', true);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 7, number_format($totalGeneral, 2), 1, 1, 'R', true);
        
        // Pie de página con la fecha y hora actual
        $pdf->SetY(-26);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 5, utf8_decode('Reporte generado el: ') . $horaActual, 0, 0, 'L');
        $pdf->Cell(0, 5, utf8_decode('Página ') . $pdf->PageNo(), 0, 1, 'R');
        
        $pdf->Output();
     }
    

    } //fin de la clase