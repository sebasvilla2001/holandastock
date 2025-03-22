<?php 

    class CategoriasModel extends Query{
        private $nombre;
        public function __construct(){
            parent::__construct();

        }

        public function getCat(){

            $sql = "SELECT * FROM categorias";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarCategoria(string $nombre){

            $this->nombre = $nombre;
            $verificar = "SELECT * FROM categorias WHERE cat_nombre = '$this->nombre'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO categorias(cat_nombre) VALUES (?)";
                $datos= array($this->nombre);
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

        public function editarCat(int $id){
            $sql = "SELECT * FROM categorias WHERE cat_id = $id ";
            $data = $this->select($sql);
            return $data;
        }


        public function modificarCategoria(string $nombre, int $id){

            $this->nombre = $nombre;
            $this->id = $id;
            $verificar = "SELECT * FROM categorias WHERE cat_nombre = '$this->nombre' AND cat_id != '$this->id'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "UPDATE categorias SET cat_nombre = ? WHERE  cat_id = ?";
                $datos= array($this->nombre, $this->id);
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

       public function accionCat(int $estado, int $id){

        $this->estado= $estado;
        $this->id= $id;
        $sql = "UPDATE categorias SET cat_estado = ? WHERE cat_id = ?";
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
        $detalle = "El nombre de la categoría = " . $nombre;
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }

    public function validarcat(int $id){
        $sql = "SELECT COUNT(*) FROM productos WHERE pro_id_categoria = $id ";
        $data = $this->select($sql);
        return $data['COUNT(*)'];
    }


    }//fin de la clase


?>