<?php 

    class Administracion extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Configuración de la Empresa');
            if (!empty($verificar) || $id_rol == 1 ) {
                $data = $this->model->getEmpresa();
                $this->views->getView($this, "index", $data);
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
           
        }

        public function home(){
            $this->views->getView($this, "home");
            
        }

        public function modificar(){
            $nombre = $_POST['nombre'];
            $tel = $_POST['telefono'];
            $dir = $_POST['direccion'];
            $mensaje = $_POST['mensaje'];
            $id = $_POST['id'];
            $data = $this->model->modificar($nombre, $tel, $dir, $mensaje, $id);
            if ($data == 'ok') {
                $msg = "ok";
            }else{
                $msg = "error";
            }

            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

    }//fin de la clase


?>

