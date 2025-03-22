<?php 

    class Cajas extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $usuario = $_SESSION['nombre']; // capturar usuario
            $verificar = $this->model->verificarPermiso($id_rol, 'Cajas');
            if (!empty($verificar) || $id_rol == 1 ) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
        }
        public function listar(){

            $data = $this->model->getCaja();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['caja_estado'] == 1) {
                  $data[$i]['caja_estado'] = '<span class="badge badge-success">Activo</span>';
                  $data[$i]['acciones'] = '<div>
                                          <button class="btn btn-primary" type="button" onclick="btnEditarCaja('.$data[$i]['caja_id'].');"><i class= "fas fa-edit"></i></button>
                                          <button class="btn btn-danger" type="button" onclick="btnEliminarCaja('.$data[$i]['caja_id'].');"><i class= "fas fa-trash-alt"></i></button>
                                           
                                      </div>';
              }else{
                  $data[$i]['caja_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>                                    
                                           <button class="btn btn-success" type="button" onclick="btnReingresarCaja('.$data[$i]['caja_id'].');"><i class="fas fa-power-off"></i></button>
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
                        $data = $this->model->registrarCajas($nombre);
                        if ($data == "ok") {
                            $mensaje = 'Insertar';
                            $bitacora = $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                            $msg = "si";
                        }else if ($data == "existe"){
                            $msg = "La caja ya existe";
                        }else{
                            $msg = "Error al Registar la caja";
                        }
                }else{
                    $data = $this->model->modificarCajas($nombre, $id);
                    if ($data == "modificado") {
                        $name = $this->model->editarCaja($id);
                        $nombre = $name['caja_caja'];
                        $mensaje = 'Modificar';
                        $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "La caja ya existe";
                    } else {
                        $msg = "Error al Registrar la caja";
                    }
                }
                
            }

            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function editar(int $id){

            $data = $this->model->editarCaja($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id) {
            $validar = $this->model->validarcaja($id); 
            if ($validar === 0) { 
                $data = $this->model->accionCaja(0, $id);
                $name = $this->model->editarCaja($id);
                $nombre = $name['caja_caja'];
                if ($data == 1) {
                    $mensaje = 'Inhabilitar';
                    $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                    $msg = "ok";
                } else {
                    $msg = "Error al eliminar la caja";
                }
            } else {
                $msg = "La caja está asignada a un usuario";
            }
        
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionCaja(1 , $id);
            $name = $this->model->editarCaja($id);
            $nombre = $name['caja_caja'];
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el caja";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

    

    }//fin de la clase


?>

