<?php 

    class ClientesModel extends Query{
        private $cedula, $nombre, $apellido1, $apellido2, $telefono, $direccion, $id, $estado;
        public function __construct(){
            parent::__construct();

        }

        public function getClientes(){

            $sql = "SELECT * FROM clientes";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarCliente(string $cedula, string $nombre, string $apellido1, string $apellido2, string $telefono, string $direccion, string $nacionalidad, string $tipoCedulaNacional, string $tipoCedulaInternacional){

            $this->cedula = $cedula;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->nacionalidad = $nacionalidad;
            $this->tipoCedulaNacional = $tipoCedulaNacional;
            $this->tipoCedulaInternacional = $tipoCedulaInternacional;
            $verificar = "SELECT * FROM clientes WHERE cliente_cedula = '$this->cedula'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO clientes(cliente_cedula, cliente_nombre, cliente_apellido1, cliente_apellido2, cliente_telefono, cliente_direccion, cliente_nacionalidad, cliente_tipoCedulaNacional, cliente_tipoCedulaInternacional) VALUES (?,?,?,?,?,?,?,?,?)";
                $datos= array($this->cedula, $this->nombre, $this->apellido1, $this->apellido2, $this->telefono, $this->direccion, $this->nacionalidad, $this->tipoCedulaNacional, $this->tipoCedulaInternacional);
                $data = $this->save($sql, $datos);
                if ($data == 1) {
                    $res = "ok";
                }else{
                    $res = "error";
                }
                
            }else{

                $res = "existe";
            }
            
            return $res; 
        
        }

        public function editarCli(int $id){
            $sql = "SELECT * FROM clientes WHERE cliente_id = $id ";
            $data = $this->select($sql);
            return $data;
        }


        public function modificarCliente(string $cedula, string $nombre, string $apellido1, string $apellido2, string $telefono, string $direccion, string $nacionalidad, string $tipoCedulaNacional, string $tipoCedulaInternacional, int $id){

            $this->cedula = $cedula;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->nacionalidad = $nacionalidad;
            $this->tipoCedulaNacional = $tipoCedulaNacional;
            $this->tipoCedulaInternacional = $tipoCedulaInternacional;
            $this->id = $id;
            $verificar = "SELECT * FROM clientes WHERE cliente_cedula = '$this->cedula' AND cliente_id != '$this->id'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "UPDATE clientes SET cliente_cedula = ?, cliente_nombre = ?, cliente_apellido1 = ?, cliente_apellido2 = ?, cliente_telefono = ?, cliente_direccion = ?, cliente_nacionalidad = ?, cliente_tipoCedulaNacional = ?, cliente_tipoCedulaInternacional = ? WHERE  cliente_id = ?";
                $datos= array($this->cedula, $this->nombre, $this->apellido1, $this->apellido2,$this->telefono, $this->direccion, $this->nacionalidad, $this->tipoCedulaNacional, $this->tipoCedulaInternacional, $this->id);
                $data = $this->save($sql, $datos);
                if ($data == 1) {
                    $res = "modificado";
                }else{
                    $res = "error";
                }
            }else{
                $res = "existe";
            }
            
            return $res; 
        
        }

       public function accionCli(int $estado, int $id){

        $this->estado= $estado;
        $this->id= $id;
        $sql = "UPDATE clientes SET cliente_estado = ? WHERE cliente_id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
       }

       public function verificarPermiso(int $id_rol, string $nombre){
        $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }


    public function registrarMov(string $id_usuario, string $nombre, string $mensaje)
    {
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
        $detalle = " El cliente con la cédula = " . $nombre;
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }

    public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
    {
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $detalle = "El cliente con la Cédula: " . $datos_cliente['cedula'] . 
               ", Nombre: " . $datos_cliente['nombre'] . 
               ", Apellido1: " . $datos_cliente['apellido1'] . 
               ", Apellido2: " . $datos_cliente['apellido2'] . 
               ", Teléfono: " . $datos_cliente['telefono'] . 
               ", Dirección: " . $datos_cliente['direccion'] .
               ", Nacionalidad: " . $datos_cliente['nacionalidad'] .
               ", TipoCedulaNacional: " . $datos_cliente['tipoCedulaNacional'] .
               ", TipoCedulaInternacional: " . $datos_cliente['tipoCedulaInternacional'];
        $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data);

    }

    public function verificarCli(string $cedula)
        {
        $this->cedula= $cedula;
        $verificar = "SELECT * FROM clientes WHERE cliente_cedula = '$this->cedula'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $res = "no existe";
           
        }else{
            $res = "existe";
        }
        return $res; 
        }




    }//fin de la clase


?>