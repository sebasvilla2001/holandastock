<?php 

    class Roles_Permisos extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Roles y Permisos');
            if (!empty($verificar) || $id_rol == 1 ) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
           
        }
        public function listar(){

            $data = $this->model->getRoles();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['rol_estado'] == 1) {
                $data[$i]['rol_estado'] = '<span class="badge badge-success">Activo</span>';
                if ($data[$i]['id_rol'] == 1) {
                    $data[$i]['acciones'] = '<div>
                    <span class="badge badge-primary">Administrador</span>
                    </div>';
                } else {
                    $data[$i]['acciones'] = '<div>
                                            <a class="btn btn-dark" href="'.base_url.'Roles_permisos/permisos/'.$data[$i]['id_rol'].'"><i class= "fas fa-key"></i></a>
                                            <button class="btn btn-primary" type="button" onclick="btnEditarRol('.$data[$i]['id_rol'].');"><i class= "fas fa-edit"></i></button>
                                            <button class="btn btn-danger" type="button" onclick="btnEliminarRol('.$data[$i]['id_rol'].');"><i class= "fas fa-trash-alt"></i></button>
                                             
                                        </div>';
                }
                
              }else{
                  $data[$i]['rol_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>                                    
                                           <button class="btn btn-success" type="button" onclick="btnReingresarRol('.$data[$i]['id_rol'].');"><i class="fas fa-power-off"></i></button>
                                      </div>';
              }
              
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
        }

        public function registrar(){
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id = $_POST['id'];
            
            if (empty($nombre) || empty($descripcion)) {
                $msg = "Los campos 'Nombre' y 'Descripción' son obligatorios para completar el registro";
            }else{
                if ($id == "") {
                        $data = $this->model-> registrarRoles($nombre,$descripcion);
                        if ($data == "ok") {
                            $mensaje = 'Insertar';
                            $datos_cliente = array(
                                "nombre" => $nombre,
                                "descripcion" => $descripcion
                            );
                            $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                            $msg = "si";
                        }else if ($data == "existe"){
                            $msg = "El Rol ya existe";
                        }else{
                            $msg = "Error al Registar el Rol";
                        }
                }else{
                    $data = $this->model->modificarRoles($nombre,$descripcion,$id);
                    if ($data == "modificado") {
                        $mensaje = 'Modificar';
                        $datos_cliente = array(
                            "nombre" => $nombre,
                            "descripcion" => $descripcion
                        );
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "El Rol ya existe";
                    } else {
                        $msg = "Error al Registrar el Rol";
                    }
                }
                
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function editar(int $id){
            $data = $this->model->editarRoles($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function eliminar(int $id){
            $validar = $this->model->validarrol($id); 
            if ($validar === 0) {
                $data = $this->model->accionRoles(0, $id);
                $name = $this->model->editarRoles($id);
                $nombre = $name['nombre_rol'];
                if ($data == 1) {
                    $mensaje = 'Inhabilitar';
                    $this->model->registrarMov($_SESSION['usuario'],$nombre, $mensaje );
                    $msg = "ok";
                }else{
                    $msg = "Error al eliminar el Rol";
                }
            }else{
                $msg = "El rol está asignado a un usuario";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionRoles(1 , $id);
            $name = $this->model->editarRoles($id);
            $nombre = $name['nombre_rol'];
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el Rol";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function permisos($id){
            if (empty($_SESSION['activo'])) {
                header("location: ".base_url);
             }
            $data['datos'] = $this->model->getPermisos();
            $permisos = $this->model->getDetallePermisos($id);
            $data['asignados'] = array();
            foreach ($permisos as $permiso) {
                $data['asignados'][$permiso['id_permiso']] = true;
            }
            $data['id_rol'] = $id;
            $this->views->getView($this, "permisos", $data);
        }

        public function registrarPermiso(){
           $msg= '';
           $id_rol = $_POST['id_rol'];
           $eliminar = $this->model->eliminarPermisos($id_rol);
           if ($eliminar == 'ok') {
                foreach ($_POST['permisos'] as $id_permiso) {
                   $msg = $this->model->registrarPermisos($id_rol, $id_permiso);
                }
                if ($msg == 'ok') {
                    $msg = "Permisos Asignados";
                } else {
                    $msg = "Error al asignar los permisos";
                }
                

           }else{

                $msg = "Error al eliminar los permisos anteriores";
           }
           echo json_encode($msg, JSON_UNESCAPED_UNICODE);
           die();
        }

    }//fin de la clase


?>

