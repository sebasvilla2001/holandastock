<?php 

    class BitMov extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Bitácora de Movimientos');
            if (!empty($verificar) || $id_rol == 1 ) {
                $data=$this->model->getUsuarios();
                // print_r($data);
                // die();
                $this->views->getView($this, "index", $data);

            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
        }

        public function listar()
        {
            $desde = $_POST['desde'];
            $hasta = $_POST['hasta'];
            $usuario = $_POST['usuario'];
            $tipoMov = $_POST['tipo_movimiento'];
        
            if (empty($desde) && empty($hasta) && empty($usuario) && empty($tipoMov)) {
                $resultados = $this->model->getMov(); 
            } else {
                if (!empty($desde) && !empty($hasta)) {
                    $desde .= " 00:00:00";
                    $hasta .= " 23:59:59";
                }
                
                $resultados = $this->model->getFiltros($desde, $hasta, $usuario, $tipoMov);
            }
        
            echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
            die();
        }
        
        

    }//fin de la clase


?>

