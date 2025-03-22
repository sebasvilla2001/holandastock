<?php 

    class MedidasModel extends Query{
        private $nombre, $nomcorto;
        public function __construct(){
            parent::__construct();

        }

        public function getMedidas(){

            $sql = "SELECT * FROM medidas";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarMed(string $nombre, string $nomcorto){

            $this->nombre = $nombre;
            $this->nomcorto = $nomcorto;
            $verificar = "SELECT * FROM medidas WHERE med_nombre = '$this->nombre'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO medidas(med_nombre, med_nom_corto) VALUES (?,?)";
                $datos= array($this->nombre, $this->nomcorto);
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

        public function editarMed(int $id){
            $sql = "SELECT * FROM medidas WHERE med_id = $id ";
            $data = $this->select($sql);
            return $data;
        }


        public function modificarMedida(string $nombre, string $nomcorto, int $id){

            $this->nombre = $nombre;
            $this->nomcorto = $nomcorto;
            $this->id = $id;
            $verificar = "SELECT * FROM medidas WHERE med_nombre = '$this->nombre' AND med_id !='$this->id'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "UPDATE medidas SET med_nombre = ?, med_nom_corto = ? WHERE  med_id = ?";
                $datos= array($this->nombre, $this->nomcorto, $this->id);
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

       public function accionMed(int $estado, int $id){

        $this->estado= $estado;
        $this->id= $id;
        $sql = "UPDATE medidas SET med_estado = ? WHERE med_id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
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
        $detalle = "El nombre de la medida: " . $datos_cliente['nombre'] . 
               ", Abreviatura: " . $datos_cliente['abreviatura'];
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
        $detalle = "El nombre de la Medida = " . $nombre;
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }

    public function validarmed(int $id){
        $sql = "SELECT COUNT(*) FROM productos WHERE pro_id_medida = $id ";
        $data = $this->select($sql);
        return $data['COUNT(*)'];
    }


    }//fin de la clase


?>