<?php 

    class Usuarios extends Controller{

        public function __construct(){

            session_start();
            
            parent::__construct();


        }

        public function index(){

            if (empty($_SESSION['activo'])) {
                header("location: ".base_url);
             }

             $id_rol = $_SESSION['id_rol'];
             $verificar = $this->model->verificarPermiso($id_rol, 'Usuarios');
             if (!empty($verificar) || $id_rol == 1 ) {
                $data['roles']=$this->model->getRoles();
                $data['cajas']=$this->model->getCajas();
                $this->views->getView($this, "index", $data);
             } else {
                 header('Location: ' .base_url. 'Errors/permisos');
             }



        }

        public function listar(){

            $data = $this->model->getUsuarios();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['user_estado'] == 1) {
            $data[$i]['user_estado'] = '<span class="badge badge-success">Activo</span>';  
              if ($data[$i]['user_id'] == 1) {
                $data[$i]['acciones'] = '<div>
                    <span class="badge badge-primary">Administrador</span>
                    </div>';
              }else{
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarUser('.$data[$i]['user_id'].');"><i class= "fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarUser('.$data[$i]['user_id'].');"><i class= "fas fa-trash-alt"></i></button>
                </div>';  
              }
              }else{
                  $data[$i]['user_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>
                   <button class="btn btn-success" type="button" onclick="btnReingresarUser('.$data[$i]['user_id'].');"><i class="fas fa-power-off"></i></button>
              </div>';
              }
            
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
          }

        public function validar(){

            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
                $msg = "Los campos están vacíos";
            } else {
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave'];
                $hash = hash("SHA256", $clave);
                $data = $this->model->getUsuario($usuario, $hash);
            
                if ($data) {
                    if ($data['user_estado'] == 1) { // Verifica si el estado del usuario es 1
                        $_SESSION['id_usuario'] = $data['user_id'];
                        $_SESSION['usuario'] = $data['user_usuario'];
                        $_SESSION['nombre'] = $data['user_nombre'];
                        $_SESSION['id_rol'] = $data['user_idrol'];
                        $_SESSION['activo'] = true;
                        $msg = "ok";
                        $bitacora = $this->model->registrarAcceso($data['user_usuario']);
                        
                    } else if ($data['user_estado'] != 1){
                        $msg = "Usuario inactivo. Comuníquese con el administrador.";
                    }
                } else {
                    $msg = "Credenciales incorrectas o el usuario está inactivo.Verifique sus datos o contacte al administrador.";
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();


        }


        public function registrar(){
            // print_r($_POST);
            // die();
            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $clave = $_POST['clave'];
            $id = $_POST['id'];
            $hash = hash("SHA256", $clave);
            $confirmar = $_POST['confirmar'];
            $caja = $_POST['caja'];
            $rol= $_POST['rol'];

            if (empty($usuario) || empty($nombre) || empty($caja) || empty($apellido1) || empty($apellido2)  || empty($rol) ){
                $msg = "Todos los campos son obligatorios";
            }else{
                if ($id == "") {
                    if ($clave != $confirmar) {
                        $msg = "Las constraseñas no coinciden";
                    }else{
                        $data = $this->model->registrarUsuario($usuario, $nombre, $apellido1, $apellido2, $hash, $caja, $rol);
                        $mensaje = 'Insertar';
                        $datos_cliente = array(
                            "usuario" => $usuario,
                            "nombre" => $nombre,
                            "apellido1" => $apellido1,
                            "apellido2" => $apellido2,
                            "caja" => $caja,
                            "rol" => $rol
                        );
                        if ($data == "ok") {
                            $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                            $msg = "si";
                        }else if ($data == "existe"){
                            $msg = "El Usuario ya existe";
                        }else{
                            $msg = "Error al Registar el Usuario";
                        }
                    }
                }else{
                    $data = $this->model->modificarUsuario($usuario, $nombre, $apellido1, $apellido2, $caja, $rol, $id);
                    $mensaje = 'Modificar';
                    $datos_cliente = array(
                        "usuario" => $usuario,
                        "nombre" => $nombre,
                        "apellido1" => $apellido1,
                        "apellido2" => $apellido2,
                        "caja" => $caja,
                        "rol" => $rol
                    );
                    if ($data == "modificado") {
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "El Usuario ya existe";
                    } else {
                        $msg = "Error al Registrar el Usuario";
                    }
                }
                
            }
            
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function editar(int $id){

            $data = $this->model->editarUser($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id){
            $data = $this->model->accionUser(0, $id);
            $name = $this->model->editarUser($id);
            $nombre = $name['user_usuario'];
            if ($data == 1) {
                $mensaje = 'Inhabilitar';
                $this->model->registrarMov($_SESSION['usuario'],$nombre, $mensaje );
                $msg = "ok";
            }else{
                $msg = "Error al eliminar el usuario";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionUser(1 , $id);
            $name = $this->model->editarUser($id);
            $nombre = $name['user_usuario'];
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el usuario";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function salir(){
            
            $bitacora = $this->model->registrarSalida();
            session_destroy();
            header("location: ".base_url);

        }

        public function cerrarSesion() {
            $bitacora = $this->model->registrarSalida();
            session_start();
            session_destroy();
            echo json_encode(["status" => "success"]);
            exit();
        }

        public function validarUsuario()
        {
            if (isset($_POST["usuario"])) {
                $usuario = $_POST['usuario'];
                $data= $this->model->verificarUsuario($usuario); // Llamamos al modelo
                //print_r($data);
                //die();
                if ($data == "existe") {
                   $msg="existe";
                }else{
                    $msg="no";
                }
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();

            }
        }



    }//fin de la clase


?>

