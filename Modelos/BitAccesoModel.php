<?php 

    class BitAccesoModel extends Query{
        public function __construct(){
            parent::__construct();

        }

        public function getAcceso(){

            $sql =  "SELECT * FROM bitacoraacceso WHERE id < (SELECT MAX(id) FROM bitacoraacceso)";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function verificarPermiso(int $id_rol, string $nombre){
            $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function getUsuarios(){

            $sql = "SELECT * FROM usuarios WHERE user_estado =1";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getFiltros($desde, $hasta, $usuario)
        {
    
            if (!empty($desde) && !empty($hasta)) {
                $sql = "SELECT * FROM bitacoraacceso WHERE fecha_ingreso BETWEEN '$desde' AND '$hasta'";
                $data = $this->selectAll($sql);
                return $data;
            }
    
            if (!empty($usuario)) {
                $sql = "SELECT * FROM bitacoraacceso WHERE usuario = '$usuario'";
                $data = $this->selectAll($sql);
                return $data;
            }

        }
    

    }//fin de la clase


?>