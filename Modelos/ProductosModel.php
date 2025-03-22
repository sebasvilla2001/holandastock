<?php 

    class ProductosModel extends Query{
        private $codigo, $nombre, $precio_compra, $precio_venta, $id_medida, $id_categoria, $id, $estado, $img;
        public function __construct(){
            parent::__construct();

        }

        public function getProductos(){

            $sql = "SELECT p. *, m.med_id, m.med_nombre,m.med_nom_corto, c.cat_id, c.cat_nombre FROM productos p INNER JOIN medidas m ON p.pro_id_medida = m.med_id INNER JOIN categorias c ON p.pro_id_categoria = c.cat_id";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getMedidas(){

            $sql = "SELECT * FROM medidas WHERE med_estado =1";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getCategorias(){

            $sql = "SELECT * FROM categorias WHERE cat_estado =1";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria, string $img){

            $this->codigo = $codigo;
            $this->nombre = $nombre;
            $this->precio_compra = $precio_compra;
            $this->precio_venta = $precio_venta;
            $this->id_medida = $id_medida;
            $this->id_categoria = $id_categoria;
            $this->img = $img;
            $verificar = "SELECT * FROM productos WHERE pro_codigo = '$this->codigo'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO productos (pro_codigo, pro_descripcion, pro_precio_compra, pro_precio_venta, pro_id_medida, pro_id_categoria, pro_foto) VALUES (?,?,?,?,?,?,?);";
                $datos= array($this->codigo, $this->nombre, $this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria, $this->img);
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

        public function modificarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria, string $img, int $id){

            $this->codigo = $codigo;
            $this->nombre = $nombre;
            $this->precio_compra = $precio_compra;
            $this->precio_venta = $precio_venta;
            $this->id_medida = $id_medida;
            $this->id_categoria = $id_categoria;
            $this->id = $id;
            $this->img = $img;
            $verificar = "SELECT * FROM productos WHERE pro_codigo = '$this->codigo' AND pro_id != '$this->id'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "UPDATE productos SET pro_codigo = ?, pro_descripcion = ?, pro_precio_compra = ?, pro_precio_venta = ?, pro_id_medida = ? , pro_id_categoria = ?, pro_foto = ? WHERE  pro_id = ?";
                $datos= array($this->codigo, $this->nombre, $this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria, $this->img, $this->id);
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

        public function editarPro(int $id){
            $sql = "SELECT * FROM productos WHERE pro_id = $id ";
            $data = $this->select($sql);
            return $data;
        }


       public function accionPro(int $estado, int $id){

        $this->estado= $estado;
        $this->id= $id;
        $sql = "UPDATE productos SET pro_estado = ? WHERE pro_id = ?";
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
        $detalle = " El producto con la código = " . $nombre;
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }

    public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
    {
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $detalle = "El producto con el código: " . $datos_cliente['codigo'] . 
               ", Nombre: " . $datos_cliente['nombre'] . 
               ", Precio Compra: " . $datos_cliente['precio_compra'] . 
               ", Precio Venta: " . $datos_cliente['precio_venta'] . 
               ", Medida: " . $datos_cliente['medida'] .
               ", Categoria: " . $datos_cliente['categoria'];
        $sql = "INSERT INTO bitacoramovimientos (usuario, tipo_movimiento, fecha, detalle) VALUES (?,?, NOW(), ?)";
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data);

    }

    public function verificarPro(string $pro)
        {
        $this->pro= $pro;
        $verificar = "SELECT * FROM productos WHERE pro_codigo = '$this->pro'";
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