<?php 

    class Medidas extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Medidas de los Productos');
            if (!empty($verificar) || $id_rol == 1) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
            
        }
        public function listar(){

            $data = $this->model->getMedidas();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['med_estado'] == 1) {
                  $data[$i]['med_estado'] = '<span class="badge badge-success">Activo</span>';
                  $data[$i]['acciones'] = '<div>
                                          <button class="btn btn-primary" type="button" onclick="btnEditarMed('.$data[$i]['med_id'].');"><i class= "fas fa-edit"></i></button>
                                          <button class="btn btn-danger" type="button" onclick="btnEliminarMed('.$data[$i]['med_id'].');"><i class= "fas fa-trash-alt"></i></button>
                                           
                                      </div>';
              }else{
                  $data[$i]['med_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>                                    
                                           <button class="btn btn-success" type="button" onclick="btnReingresarMed('.$data[$i]['med_id'].');"><i class="fas fa-power-off"></i></button>
                                      </div>';
              }
              
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
        }
        public function registrar() {
            $nombre = $_POST['nombre'];
            $nomcorto = strtoupper($_POST['nomcorto']);  // Convertir a mayúsculas
            $id = $_POST['id'];
        
            if (empty($nombre) || empty($nomcorto)) {
                $msg = "Los campos 'Nombre' y 'Abreviatura' son obligatorios para completar el registro";
            } elseif (strlen($nomcorto) > 5) {
                $msg = "La abreviatura no puede tener más de 5 caracteres";
            } else {
                if ($id == "") {
                    $data = $this->model->registrarMed($nombre, $nomcorto);
                    if ($data == "ok") {
                        $mensaje = 'Insertar';
                        $datos_cliente = array(
                            "nombre" => $nombre,
                            "abreviatura" => $nomcorto
                        );
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "si";
                    } elseif ($data == "existe") {
                        $msg = "La Medida ya existe";
                    } else {
                        $msg = "Error al Registrar la Medida";
                    }
                } else {
                    $data = $this->model->modificarMedida($nombre, $nomcorto, $id);
                    if ($data == "modificado") {
                        $mensaje = 'Modificar';
                        $datos_cliente = array(
                            "nombre" => $nombre,
                            "abreviatura" => $nomcorto
                        );
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "La medida ya existe";
                    } else {
                        $msg = "Error al Registrar la medida";
                    }
                }
            }
        
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        

        public function editar(int $id){

            $data = $this->model->editarMed($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id){
            $validar = $this->model-> validarmed($id); 
            if ($validar === 0) {
                $data = $this->model->accionMed(0, $id);
                $name = $this->model->editarMed($id);
                $nombre = $name['med_nombre'];
                if ($data == 1) {
                    $mensaje = 'Inhabilitar';
                    $this->model->registrarMov($_SESSION['usuario'],$nombre, $mensaje );
                    $msg = "ok";
                }else{
                    $msg = "Error al eliminar el Medidas";
                }
            }else{
                $msg = "La medida está asignada a un producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionMed(1 , $id);
            $name = $this->model->editarMed($id);
            $nombre = $name['med_nombre'];
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el Medidas";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

    }//fin de la clase


?>

