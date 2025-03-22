<?php 

    class Productos extends Controller{

        public function __construct(){

            session_start();
            
            parent::__construct();


        }

        public function index(){

            if (empty($_SESSION['activo'])) {
                header("location: ".base_url);
             }

            $id_rol = $_SESSION['id_rol'];
            $verificar = $this->model->verificarPermiso($id_rol, 'Productos');
            if (!empty($verificar) || $id_rol == 1 ) {
                $data['medidas']=$this->model->getMedidas();
                $data['categorias']=$this->model->getCategorias();
                $this->views->getView($this, "index", $data);
            } else {
                header('Location: ' .base_url. 'Errors/permisos');
            }

        }

        public function listar(){

            $data = $this->model->getProductos();
            for ($i=0; $i < count($data) ; $i++) { 
                $data[$i]['imagen'] = '<img class="img-thumbnail" src="'.base_url."Assets/img/".$data[$i]['pro_foto'].'" style="width: 120px; height: 100px;">';
              if ($data[$i]['pro_estado'] == 1) {
                  $data[$i]['pro_estado'] = '<span class="badge badge-success">Activo</span>';
                  $data[$i]['acciones'] = '<div>
                  <button class="btn btn-primary" type="button" onclick="btnEditarPro('.$data[$i]['pro_id'].');"><i class= "fas fa-edit"></i></button>
                  <button class="btn btn-danger" type="button" onclick="btnEliminarPro('.$data[$i]['pro_id'].');"><i class= "fas fa-trash-alt"></i></button>
              </div>';
              }else{
                  $data[$i]['pro_estado'] = '<span class="badge badge-danger">Inactivo</span>';
                  $data[$i]['acciones'] = '<div>
                   <button class="btn btn-success" type="button" onclick="btnReingresarPro('.$data[$i]['pro_id'].');"><i class="fas fa-power-off"></i></button>
              </div>';
              }
            
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
  
          }


          public function registrar() {
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $precio_compra = $_POST['precio_compra'];
            $precio_venta = $_POST['precio_venta'];
            $medida = $_POST['medida']; 
            $categoria = $_POST['categoria'];
            $id = $_POST['id'];
            $img = $_FILES['imagen'];
            $name = $img['name'];
            $tempname = $img['tmp_name'];
            $fecha = date("YmdHis");
            if (empty($codigo) || empty($nombre) || empty($precio_compra) || empty($precio_venta)) {
                $msg = "Todos los campos son obligatorios";
            } elseif (!is_numeric($precio_compra) || !is_numeric($precio_venta)) {
                $msg = "Los precios deben ser numéricos";
            } else {
                if (!empty($name)) {
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/img/". $imgNombre;
                }else if(!empty($_POST['foto_actual']) && empty($name)){ 
                    $imgNombre = $_POST['foto_actual'];
                }else{
                    $imgNombre = "default.png";
                }
                if ($id == "") {
                    $data = $this->model->registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria, $imgNombre);
                    $mensaje = 'Se insertó un nuevo producto';
                    if ($data == "ok") {
                        if (!empty($name)) {
                            move_uploaded_file($tempname, $destino);
                        }
                        $mensaje = 'Insertar';
                        $datos_cliente = array(
                            "codigo" => $codigo,
                            "nombre" => $nombre,
                            "precio_compra" => $precio_compra,
                            "precio_venta" => $precio_venta,
                            "medida" => $medida,
                            "categoria" => $categoria
                        );
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "si";
                        
                    } elseif ($data == "existe") {
                        $msg = "El Producto ya existe";
                    } else {
                        $msg = "Error al Registrar el Producto";
                    }
                } else {
                    $imagenDelete = $this->model->editarPro($id);
                     if ($imagenDelete['pro_foto'] != 'default.png') {
                         if (file_exists("Assets/img/" . $imagenDelete['pro_foto'])) {
                            unlink("Assets/img/" . $imagenDelete['pro_foto']);
                       }
                     }
                    $data = $this->model->modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria, $imgNombre, $id);
                    if ($data == "modificado") {
                        if (!empty($name)) {
                            move_uploaded_file($tempname, $destino);
                        }
                        $mensaje = 'Modificar';
                        $datos_cliente = array(
                            "codigo" => $codigo,
                            "nombre" => $nombre,
                            "precio_compra" => $precio_compra,
                            "precio_venta" => $precio_venta,
                            "medida" => $medida,
                            "categoria" => $categoria
                        );
                        $this->model->registrarMovNew($_SESSION['usuario'], $mensaje, $datos_cliente);
                        $msg = "modificado";
                    } elseif ($data == "existe") {
                        $msg = "El Producto ya existe";
                    } else {
                        $msg = "Error al Registrar el Producto";
                    }
                
                }
            }
        
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function editar(int $id){

            $data = $this->model->editarPro($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();

        }

        public function eliminar(int $id){
            $data = $this->model->accionPro(0, $id);
            $name = $this->model->editarPro($id);
            $nombre = $name['pro_descripcion'];
            if ($data == 1) {
                $mensaje = 'Inhabilitar';
                $this->model->registrarMov($_SESSION['usuario'],$nombre, $mensaje );
                $msg = "ok";
            }else{
                $msg = "Error al eliminar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function reingresar(int $id){
            $data = $this->model->accionPro(1 , $id);
            $name = $this->model->editarPro($id);
            $nombre = $name['pro_descripcion'];
            if ($data == 1) {
                $mensaje = 'Habilitar';
                $this->model->registrarMov($_SESSION['usuario'], $nombre, $mensaje);
                $msg = "ok";
            }else{
                $msg = "Error al reingresar el Producto";
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function salir(){

            session_destroy();
            header("location: ".base_url);

        }

        public function validarPro()
        {
            if (isset($_POST["codigo"])) {
                $pro = $_POST['codigo'];
                $data= $this->model->verificarPro($pro); // Llamamos al modelo
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

