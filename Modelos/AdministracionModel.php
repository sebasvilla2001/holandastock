<?php 

    class AdministracionModel extends Query{
        public function __construct(){
            parent::__construct();

        }

        public function getEmpresa(){
            $sql = "SELECT * FROM configuracion";
            $data = $this->select($sql);
            return $data;
        }

        public function modificar(string $nombre, string $tel, string $dir, string $mensaje, int $id){
                $sql = "UPDATE configuracion SET con_nombre = ?, con_telefono = ?, con_direccion = ?, con_mensaje = ? WHERE con_id = ?";
                $datos= array($nombre, $tel, $dir,$mensaje, $id );
                $data = $this->save($sql, $datos);
                if ($data == 1) {
                    $res = "ok";
                }else{
                    $res = "error";
                }
            
            return $res; 
        }

        public function verificarPermiso(int $id_rol, string $nombre){
            $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
            $data = $this->selectAll($sql);
            return $data;
        }



    }//fin de la clase


?>