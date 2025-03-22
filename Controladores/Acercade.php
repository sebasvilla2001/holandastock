<?php 

    class Acercade extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Acerca De');
            if (!empty($verificar) || $id_rol == 1 ) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
           
        }

    }//fin de la clase


?>

