<?php

class Ventas extends Controller{

    public function __construct(){
        session_start();
        parent::__construct();

    }

    public function index(){

        $id_rol = $_SESSION['id_rol'];
        $verificar = $this->model->verificarPermiso($id_rol, 'Ventas');
        if (!empty($verificar) || $id_rol == 1) {
            $data = $this->model->getClientes();
            $this->views->getView($this, "index", $data);
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
        $precio = $datos[0]['pro_precio_venta'];
        $cantidad = $_POST['cantidad'];
        $nombre = $datos[0]['pro_descripcion'];
        $vent_robar = $this->model->consultarDetalle($id_pro, $id_user);
        if (empty($vent_robar)) {
            if ($datos[0]['pro_cantidad'] >= $cantidad) {
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
                $msg = "stock0";
            }
           
        }else{
            $total_cantidad = $vent_robar['det_cantidad'] + $cantidad;
            $subtotal= $total_cantidad * $precio;
            if ($datos[0]['pro_cantidad'] < $total_cantidad) {

                $msg = "stock0";
            }else{
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
        }    
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
   }

   public function listar(){
    $id_usuario = $_SESSION['id_usuario'];
    $data['detalle'] = $this->model->getDetalle($id_usuario);  
    $data['total_pagar'] = $this->model->calcularVenta($id_usuario); 
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
    }

    public function delete($id){
        $datos = $this->model->getDetalleBit($id);
        $id_pro = $datos[0]['det_id_pro']; 
        $datos_pro =  $this->model->getProductos($id_pro);
        $nombre = $datos_pro[0]['pro_descripcion'];
        $data = $this->model->deleteDetalleVenta($id);  
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

     public function registararVenta(){
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularVenta($id_usuario); 
        $data = $this->model->registararVenta($total['total']); 
        // Validar que el total no sea nulo o incorrecto
        $total = $this->model->calcularVenta($id_usuario);
        if (!$total || !isset($total['total']) || !is_numeric($total['total']) || $total['total'] <= 0) {
            $msg = array('msg' => 'Error al calcular el total de la vent_ra. Verifique los detalles del carrito.', 'icono' => 'error');
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        if ($data == 'ok') {
            $detalle = $this->model->getDetalle($id_usuario);  
            $id_venta = $this->model->id_venta();
            foreach ($detalle as $row) {
                $cantidad = $row['det_cantidad'];
                $precio = $row['det_precio'];
                $descuento = $row['det_descuento'];
                $id_producto = $row['det_id_pro'];
                $sub_total = ($cantidad * $precio)- $descuento;
                $this->model->registrarDetalleVenta($id_venta['id'], $id_producto, $cantidad, $descuento, $precio, $sub_total);
                $stock_actual = $this->model->getProductos($id_producto);
                // var_dump($stock_actual); // Muestra el contenido del arreglo
                // die();   
                $stock = $stock_actual[0]['pro_cantidad'] - $cantidad; 
                $this->model->actualizarStock($stock, $id_producto);
            }
            $vaciar = $this->model->vaciarDetalle($id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_venta' => $id_venta['id']);
            }
        }else{
            $msg = 'Error al realizar la venta';
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
     }

     public function generarPdf($id_venta)
     {
         $empresa = $this->model->getEmpresa();
         $productos = $this->model->getProVenta($id_venta);
         $horaActual = date("H:i:s");
         require('Libraries/fpdf/fpdf.php');
     
         $pdf = new FPDF();
         $pdf->AddPage();
         $pdf->SetMargins(10, 10, 10);
         $pdf->SetTitle('Reporte Ventas');
         
         // Encabezado de la empresa
         $pdf->SetFont('Arial', 'B', 14);
         $pdf->Cell(0, 10, utf8_decode($empresa['con_nombre']), 0, 1, 'C');
         $imageX = $pdf->GetPageWidth() - 10 - 30; // 10 es el margen derecho, 30 es el ancho de la imagen
         $pdf->Image(base_url . 'Assets/img/logo.png', $imageX, 10, 35, 40); // Ajuste de posición y tamaño del logo
         $pdf->Ln(15); // Espaciado debajo del encabezado
     
         // Información de la empresa
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(60, 5, $empresa['con_telefono'], 0, 1, 'L');
     
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->MultiCell(0, 5, utf8_decode($empresa['con_direccion']), 0, 'L'); 

         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, utf8_decode('Mensaje: '), 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->MultiCell(0, 5, utf8_decode($empresa['con_mensaje']), 0, 'L'); 
     
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 5, 'Compra No: ', 0, 0, 'L');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(0, 5, $id_venta, 0, 1, 'L');
     
         $pdf->Ln(5);
     
         // Encabezado de productos
         $pdf->SetFillColor(0, 0, 0);
         $pdf->SetTextColor(255, 255, 255);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(20, 7, 'Cantidad', 1, 0, 'C', true);
         $pdf->Cell(80, 7, utf8_decode('Descripción'), 1, 0, 'C', true);

         $pdf->Cell(30, 7, utf8_decode('Precio'), 1, 0, 'C', true); 
         $pdf->Cell(30, 7, utf8_decode('Descuento'), 1, 0, 'C', true); 
         $pdf->Cell(30, 7, utf8_decode('Sub Total'), 1, 1, 'C', true);
     
         // Productos
         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetFont('Arial', '', 9);
         $total = 0.00;
         foreach ($productos as $row) {
             $total = $total + $row['deve_subtotal'];
             $horaActual = $row['vent_fecha'];
             $pdf->Cell(20, 6, $row['deve_cantidad'], 1, 0, 'C');
             $pdf->Cell(80, 6, utf8_decode($row['pro_descripcion']), 1, 0, 'L'); 
             $pdf->Cell(30, 6, number_format($row['deve_precio'], 2), 1, 0, 'R'); 
             $pdf->Cell(30, 6, number_format($row['deve_descuento'], 2), 1, 0, 'R'); 
             $pdf->Cell(30, 6, number_format($row['deve_subtotal'], 2), 1, 1, 'R'); 
         }
     
         // Total general
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->Cell(160, 7, 'Total a Pagar', 1, 0, 'R');
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
        $data = $this->model->getHistorialventas(); 
        for ($i=0; $i < count($data) ; $i++) { 
            $data[$i]['acciones'] = '<div>
            <a class="btn btn-danger" href="'.base_url."Ventas/generarPdf/".$data[$i]['vent_id'].'" target="_blank"><i class= "fas fa-file-pdf"></i></a>
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
            $data = $this->model->getHistorialventas();
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
         $pdf->SetTitle('Reporte Ventas');
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
            $pdf->Cell(30, 6, $row['vent_id'], 1, 0, 'C');
            $pdf->Cell(40, 6, number_format($row['vent_total'], 2), 1, 0, 'R');
            $pdf->Cell(50, 6, $row['vent_fecha'], 1, 1, 'C');
            $totalGeneral += $row['vent_total'];
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

    //  public function calcularDescuento($datos){
    //     $array = explode(",", $datos);
    //     $id = $array[0];
    //     $desc = $array[1];
    //     if (empty($id) || empty($desc)) {
    //         $msg = "Error";
    //         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    //     }else{
    //         $descuento_actual = $this->model->verificarDescuento($id);
    //         $descuento_total = $descuento_actual[0]['det_descuento'] + $desc;
            
    //         $sub_total = ($descuento_actual[0]['det_cantidad'] * $descuento_actual[0]['det_precio']) - $descuento_total;
    //         $data = $this->model->actualizarDescuento($descuento_total, $sub_total, $id);
    //         if ($data == 'ok') {
    //             $msg = "ok";
    //         }else{
    //             $msg = "Error";
                
    //         }
    //     }
    //     echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    //     die();
    //  }


     public function calcularDescuento($datos) {
        $array = explode(",", $datos);
        $id = $array[0];
        $desc = $array[1];
    
        if (empty($id) || empty($desc)) {
           $msg = "Error";
           echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        }else{
            $descuento_actual = $this->model->verificarDescuento($id);
            $descuento_total = $descuento_actual[0]['det_descuento'] + $desc;
        
            // Calcular el subtotal
            $sub_total = ($descuento_actual[0]['det_cantidad'] * $descuento_actual[0]['det_precio']);

            if ($descuento_total >= $sub_total) {
                 $msg = "El descuento no puede ser mayor que el subtotal";
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
            $nuevo_sub_total = $sub_total - $descuento_total;

            // Actualizar el descuento en la base de datos
            $data = $this->model->actualizarDescuento($descuento_total, $nuevo_sub_total, $id);
            if ($data == 'ok') {
                $msg = "ok";
            } else {
                $msg = "Error al actualizar el descuento";
            }

        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        return; // Usar return en lugar de die() para evitar terminar el script
    }
     


    } //fin de la clase 