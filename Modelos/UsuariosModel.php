<?php 

    class UsuariosModel extends Query{
        private $usuario, $nombre, $apellido1, $apellido2, $clave, $id_caja, $id, $estado;
        public function __construct(){
            parent::__construct();

        }

        public function getUsuario(string $usuario, string $clave)
        {
            // Agregar condición para que solo los usuarios con estado = 1 sean seleccionados
            $sql = "SELECT * FROM usuarios WHERE user_usuario = '$usuario' AND user_clave = '$clave' AND user_estado = 1";
            
            $data = $this->select($sql);
            return $data;
        }

        public function getUsuarios(){

            $sql = "SELECT u.*,c.caja_id, c.caja_caja, r.id_rol, r.nombre_rol FROM usuarios u INNER JOIN caja c ON u.user_idcaja = c.caja_id INNER JOIN roles r ON u.user_idrol = r.id_rol";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getCajas(){

            $sql = "SELECT * FROM caja WHERE caja_estado =1";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getRoles(){

            $sql = "SELECT * FROM roles WHERE rol_estado =1";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarUsuario(string $usuario, string $nombre, string $apellido1, string $apellido2, string $clave, int $id_caja, int $id_rol){

            $this->usuario = $usuario;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->clave = $clave;
            $this->id_caja = $id_caja;
            $this->id_rol = $id_rol;
            $verificar = "SELECT * FROM usuarios WHERE user_usuario = '$this->usuario'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO usuarios(user_usuario, user_nombre, user_apellido1, user_apellido2, user_clave, user_idcaja, user_idrol) VALUES (?,?,?,?,?,?,?)";
                $datos= array($this->usuario, $this->nombre, $this->apellido1, $this->apellido2, $this->clave, $this->id_caja,$this->id_rol );
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

        public function editarUser(int $id){
            $sql = "SELECT * FROM usuarios WHERE user_id = $id ";
            $data = $this->select($sql);
            return $data;
        }


        public function modificarUsuario(string $usuario, string $nombre, string $apellido1, string $apellido2, int $id_caja, int $id_rol, int $id){

            $this->usuario = $usuario;
            $this->nombre = $nombre;
            $this->apellido1 = $apellido1;
            $this->apellido2 = $apellido2;
            $this->id_caja = $id_caja;
            $this->id_rol = $id_rol;
            $this->id = $id;
            $verificar = "SELECT * FROM usuarios WHERE user_usuario = '$this->usuario' AND user_id != '$this->id'";
            $existe = $this->select($verificar);

            if (empty($existe)) {
                $sql = "UPDATE usuarios SET user_usuario = ?, user_nombre = ?, user_apellido1 = ?, user_apellido2 = ?, user_idcaja = ?, user_idrol = ? WHERE  user_id = ?";
                $datos= array($this->usuario, $this->nombre, $this->apellido1, $this->apellido2, $this->id_caja, $this->id_rol, $this->id);
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

       public function accionUser(int $estado, int $id){

        $this->estado= $estado;
        $this->id= $id;
        $sql = "UPDATE usuarios SET user_estado = ? WHERE user_id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;




       }

    public function registrarAcceso(string $id_usuario)
    {
        $this->id_usuario = $id_usuario;

        // Insertar el registro en la tabla bitacoraaccesos
        $sql = "INSERT INTO bitacoraacceso (usuario, fecha_ingreso, fecha_salida) VALUES (?, NOW(), Null)";
        $datos = array($this->id_usuario);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "registro_exitoso";
        } else {
            $res = "error";
        }

        return $res;
    }


        public function registrarSalida()
        {
            // Consulta para actualizar el último registro insertado
            $sql = "UPDATE bitacoraacceso SET fecha_salida = NOW()  WHERE id = (SELECT MAX(id) FROM bitacoraacceso)";
             $data = $this->save($sql,[]); // No se necesitan parámetros
        
            if ($data == 1) {
                $res = "registro_exitoso";
            } else {
                $res = "error";
            }
            return $res;
        }


        public function getUserRole($id_usuario) {
            $sql = "SELECT id_rol FROM detalle_permiso WHERE id_usuario = :id_usuario";
            $data = $this->selectAll($sql);
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
            $detalle = " El usuario con el user = " . $nombre;
            $datos = array($this->id_usuario,$mensaje, $detalle);
            $data = $this->save($sql, $datos);
        
            return ($data == 1);
        }
    
        public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
        {
            $this->id_usuario = $id_usuario;
            $this->mensaje = $mensaje;
            $detalle = "El usuario con la user: " . $datos_cliente['usuario'] . 
                   ", Nombre: " . $datos_cliente['nombre'] . 
                   ", Apellido1: " . $datos_cliente['apellido1'] . 
                   ", Apellido2: " . $datos_cliente['apellido2'] . 
                   ", Caja: " . $datos_cliente['caja'] . 
                   ", Rol: " . $datos_cliente['rol'];
            $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
            $datos = array($this->id_usuario,$mensaje, $detalle);
            $data = $this->save($sql, $datos);
        
            return ($data);
    
        }

        public function verificarUsuario(string $usuario)
        {
        $this->usuario = $usuario;
        $verificar = "SELECT * FROM usuarios WHERE user_usuario = '$this->usuario'";
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