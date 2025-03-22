<?php 

    class BitAcceso extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Bitácora de Acceso');
            if (!empty($verificar) || $id_rol == 1 ) {
                $data=$this->model->getUsuarios();
                $this->views->getView($this, "index", $data);
                
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
         
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

        public function listar()
        {
            $desde = $_POST['desde'];
            $hasta = $_POST['hasta'];
            $usuario = $_POST['usuario'];
        
            if (empty($desde) && empty($hasta) && empty($usuario)) {
                $resultados = $this->model->getAcceso();
            } else {
                if (!empty($desde) && !empty($hasta)) {
                    $desde .= " 00:00:00";
                    $hasta .= " 23:59:59";
                }
                
                $resultados = $this->model->getFiltros($desde, $hasta, $usuario);
            }

           // print_r($resultados);
        
            echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
            die();
        }

    }//fin de la clase


?>

