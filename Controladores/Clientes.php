<?php 

    class Clientes extends Controller{

        public function __construct(){

            session_start();
            if (empty($_SESSION['activo'])) {
               header("location: ".base_url);
            }
            parent::__construct();


        }

        public function index(){
            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Clientes');
            if (!empty($verificar) || $id_rol == 1 ) {
                $this->views->getView($this, "index");
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }
           
        }
        public function listar(){

            $data = $this->model->getClientes();
            for ($i=0; $i < count($data) ; $i++) { 
              if ($data[$i]['cliente_estado'] == 1) {
                  $data[$i]['cliente_estado'] = '<span class="badge badge-success">Activo</span>';
                  $data[$i]['acciones'] = '<div>
                                          <button class="btn btn-primary" type="button" onclick="btnEditarCli('.$data[$i]['cliente_id'].');"><i class= "fas fa-edit"></i></button>
                                          <button class="btn btn-danger" type="button" onclick="btnEliminarCli('.$data[$i]['cliente_id'].');"><i class= "fas fa-trash-alt"></i></button>
                                           
                                      </div>';
              }else{
                  $data[$i]['cliente_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>                                    
                                           <button class="btn btn-success" type="button" onclick="btnReingresarCli('.$data[$i]['cliente_id'].');"><i class="fas fa-power-off"></i></button>
                                      </div>';
              }
              
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
        }


        public function registrar() {
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $id = $_POST['id'];
            $nacionalidad = $_POST['nacionalidad'];
            $tipoCedulaNacional = $_POST['tipoCedulaNacional'];
            $tipoCedulaInternacional = $_POST['tipoCedulaInternacional'];
        
            if (empty($cedula) || empty($nombre) || empty($telefono)) {
                $msg = "Los campos 'Cédula', 'Nombre' y 'Teléfono' son obligatorios para completar el registro";
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
        
            if (!preg_match('/^[0-9\-]{8,10}$/', $telefono)) {
                $msg = "Formato de teléfono inválido. Debe contener solo números, con una longitud de 8 caracteres.";
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
        
            if ($nacionalidad === "Nacional") {
                if ($tipoCedulaNacional === "Fisica") {
                    if (!preg_match('/^\d{9}$/', $cedula)) {
                        $msg = "Formato incorrecto. La cédula física debe tener 9 dígitos numéricos sin guiones.";
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                } elseif ($tipoCedulaNacional === "Juridica") {
                    if (!preg_match('/^\d{10}$/', $cedula)) {
                        $msg = "Formato incorrecto. La cédula jurídica debe tener 10 dígitos numéricos sin guiones.";
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                } else {
                    $msg = "Tipo de cédula nacional inválido.";
                    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                    die();
                }
            } elseif ($nacionalidad === "Internacional") {
                if ($tipoCedulaInternacional === "Cedula_Residente" || $tipoCedulaInternacional === "Pasaporte") {
                    if (!preg_match('/^[A-Za-z0-9]{9,12}$/', $cedula)) {
                        $msg = "El pasaporte o cédula de extranjero debe tener entre 9 y 12 caracteres y puede contener letras y números.";
                        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                } else {
                    $msg = "Tipo de cédula internacional inválido.";
                    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                    die();
                }
            }
        
            if ($id == "") {
                $data = $this->model->registrarCliente($cedula, $nombre, $apellido1, $apellido2, $telefono, $direccion, $nacionalidad, $tipoCedulaNacional, $tipoCedulaInternacional);
                $mensaje = 'Insertar';
                $datos_cliente = array(
                    "cedula" => $cedula,
                    "nombre" => $nombre,
                    "apellido1" => $apellido1,
                    "apellido2" => $apellido2,
                    "telefono" => $telefono,
                    "direccion" => $direccion,
                    "nacionalidad" => $nacionalidad,
                    "tipoCedulaNacional" => $tipoCedulaNacional,
                    "tipoCedulaInternacional" => $tipoCedulaInternacional
                );
                if ($data == "ok") {
                    $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                    $msg = "si";
                } elseif ($data == "existe") {
                    $msg = "El Cliente ya existe";
                } else {
                    $msg = "Error al Registrar el Cliente";
                }
            } else {
                $data = $this->model->modificarCliente($cedula, $nombre, $apellido1, $apellido2, $telefono, $direccion, $nacionalidad, $tipoCedulaNacional, $tipoCedulaInternacional, $id);
                if ($data == "modificado") {
                    $name = $this->model->editarCli($id);
                    $nombre = $name['cliente_cedula'];
                    $mensaje = 'Modificar';
                    $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                    $msg = "modificado";
                } elseif ($data == "existe") {
                    $msg = "El cliente ya existe";
                } else {
                    $msg = "Error al Registrar el cliente";
                }
            }
        
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        
        
        

        public function editar(int $id){

            $data = $this->model->editarCli($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id){
            $data = $this->model->accionCli(0, $id);
            $name = $this->model->editarCli($id);
            $nombre = $name['cliente_cedula'];
            if ($data == 1) {
                $mensaje = 'Inhabilitar';
                $this->model->registrarMov($_SESSION['usuario'],$nombre, $mensaje );
                $msg = "ok";
            }else{
                $msg = "Error al eliminar el cliente";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionCli(1 , $id);
            $name = $this->model->editarCli($id);
            $nombre = $name['cliente_cedula'];
            // print_r($nombre);
            // die();
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el cliente";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function validarCli()
        {
            if (isset($_POST["cedula"])) {
                $cedula = $_POST['cedula'];
                $data= $this->model->verificarCli($cedula); // Llamamos al modelo
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

