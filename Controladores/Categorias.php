<?php 

    class Categorias extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Categorías de los Productos');
            if (!empty($verificar) || $id_rol == 1 ) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
        }
        public function listar(){

            $data = $this->model->getCat();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['cat_estado'] == 1) {
                  $data[$i]['cat_estado'] = '<span class="badge badge-success">Activo</span>';
                  $data[$i]['acciones'] = '<div>
                                          <button class="btn btn-primary" type="button" onclick="btnEditarCat('.$data[$i]['cat_id'].');"><i class= "fas fa-edit"></i></button>
                                          <button class="btn btn-danger" type="button" onclick="btnEliminarCat('.$data[$i]['cat_id'].');"><i class= "fas fa-trash-alt"></i></button>
                                           
                                      </div>';
              }else{
                  $data[$i]['cat_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>                                    
                                           <button class="btn btn-success" type="button" onclick="btnReingresarCat('.$data[$i]['cat_id'].');"><i class="fas fa-power-off"></i></button>
                                      </div>';
              }
              
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
        }

        public function registrar(){
            $nombre = $_POST['nombre'];
            $id = $_POST['id'];
            
            if (empty($nombre)) {
                $msg = "Todos los campos son obligatorios para completar el registro";
            }else{
                if ($id == "") {
                        $data = $this->model->registrarCategoria($nombre);
                        if ($data == "ok") {
                            $mensaje = 'Insertar';
                            $bitacora = $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                            $msg = "si";
                        }else if ($data == "existe"){
                            $msg = "La categoría ya existe";
                        }else{
                            $msg = "Error al Registar la categoría";
                        }
                }else{
                    $data = $this->model->modificarCategoria($nombre, $id);
                    if ($data == "modificado") {
                        $name = $this->model->editarCat($id);
                        $nombre = $name['cat_nombre'];
                        $mensaje = 'Modificar';
                        $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "La categoría ya existe";
                    } else {
                        $msg = "Error al Registrar la categoría";
                    }
                }
                
            }

            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function editar(int $id){

            $data = $this->model->editarCat($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id){
            $validar = $this->model->validarcat($id); 
            if ($validar === 0) {
                $data = $this->model->accionCat(0, $id);
                if ($data == 1) {
                    $name = $this->model->editarCat($id);
                    $nombre = $name['cat_nombre'];
                    $mensaje = 'Inhabilitar';
                    $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                    $msg = "ok";
                }else{
                    $msg = "Error al eliminar la categoria";
                }
            }else{
                $msg = "La categoría está asignada a un producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionCat(1 , $id);
            if ($data == 1) {
                $name = $this->model->editarCat($id);
                $nombre = $name['cat_nombre'];
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el categoria";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

    }//fin de la clase


?>

