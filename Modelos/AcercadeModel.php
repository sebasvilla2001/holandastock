<?php 

    class AcercadeModel extends Query{
        public function __construct(){
            parent::__construct();

        }


        public function verificarPermiso(int $id_rol, string $nombre){
            $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
            $data = $this->selectAll($sql);
            return $data;
        }



    }//fin de la clase


?>