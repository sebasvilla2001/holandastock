<?php 

    class Roles_PermisosModel extends Query{
        private $nombre, $descripcion;
        public function __construct(){
            parent::__construct();

        }

        public function getRoles(){

            $sql = "SELECT * FROM roles";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarRoles(string $nombre, string $descripcion){

            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $verificar = "SELECT * FROM roles WHERE nombre_rol = '$this->nombre'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO roles(nombre_rol, descripcion_rol) VALUES (?,?)";
                $datos= array($this->nombre, $this->descripcion);
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

        public function editarRoles(int $id_rol){
            $sql = "SELECT * FROM roles WHERE id_rol = $id_rol ";
            $data = $this->select($sql);
            return $data;
        }


        public function modificarRoles(string $nombre, string $descripcion, int $id_rol){

            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->id_rol = $id_rol;
            $verificar = "SELECT * FROM roles WHERE nombre_rol = '$this->nombre' AND id_rol !='$this->id_rol'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "UPDATE roles SET nombre_rol = ?, descripcion_rol = ? WHERE  id_rol = ?";
                $datos= array($this->nombre, $this->descripcion, $this->id_rol);
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

       public function accionRoles(int $rol_estado, int $id_rol){

        $this->rol_estado= $rol_estado;
        $this->id_rol= $id_rol;
        $sql = "UPDATE roles SET rol_estado = ? WHERE id_rol = ?";
        $datos = array($this->rol_estado, $this->id_rol);
        $data = $this->save($sql, $datos);
        return $data;




       }

       public function getPermisos(){
        $sql = "SELECT * FROM permisos";
        $data = $this->selectAll($sql);
        return $data;
       }


       public function registrarPermisos(int $id_rol, int $id_permiso){
            $sql = "INSERT INTO detalle_permisos(id_rol, id_permiso) VALUES (?,?)";
            $datos= array($id_rol, $id_permiso);
            $data = $this->save($sql, $datos);
            if($data == 1){
                $res = 'ok';
    
            }else{
    
                $res = 'error';
            }
            return $res;
       }

       public function eliminarPermisos(int $id_rol){
        $sql = "DELETE FROM detalle_permisos WHERE id_rol = ?";
        $datos= array($id_rol);
        $data = $this->save($sql, $datos);
        if($data == 1){
            $res = 'ok';

        }else{

            $res = 'error';
        }
        return $res;  
   }

   public function getDetallePermisos(int $id_rol){
        $sql = "SELECT * FROM detalle_permisos WHERE id_rol = $id_rol";
        $data = $this->selectAll($sql);
        return $data;
   }

   public function verificarPermiso(int $id_rol, string $nombre){
        $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
    {
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $detalle = "El nombre del rol: " . $datos_cliente['nombre'] . 
               ", Descripción: " . $datos_cliente['descripcion'];
        $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data);

    }

    public function registrarMov(string $id_usuario, string $nombre, string $mensaje)
    {
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
        $detalle = "El nombre del Rol = " . $nombre;
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }

    public function validarrol(int $id){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE user_idrol = $id ";
        $data = $this->select($sql);
        return $data['COUNT(*)'];
    }


}//fin de la clase


?>