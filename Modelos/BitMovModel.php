<?php 

    class BitMovModel extends Query{
        private $nombre;
        public function __construct(){
            parent::__construct();

        }

        public function getMov(){

            $sql = "SELECT * FROM bitacoramovimientos";
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


    public function getFiltros($desde, $hasta, $usuario, $tipoMov)
    {

        if (!empty($desde) && !empty($hasta)) {
            $sql = "SELECT * FROM bitacoramovimientos WHERE fecha BETWEEN '$desde' AND '$hasta'";
            $data = $this->selectAll($sql);
            return $data;
        }

        if (!empty($usuario)) {
            $sql = "SELECT * FROM bitacoramovimientos WHERE usuario = '$usuario'";
            $data = $this->selectAll($sql);
            return $data;
        }
        if (!empty($tipoMov)) {
            $sql = "SELECT * FROM bitacoramovimientos WHERE tipo_movimiento = '$tipoMov'";
            $data = $this->selectAll($sql);
            return $data;
        }


    }

       


    }//fin de la clase


?>