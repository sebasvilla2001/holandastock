<?php 

    class ComprasModel extends Query{
        public function __construct(){
            parent::__construct();
        }

        public function getProCod(string $codigo){
            $sql = "SELECT p.*, m.med_id, m.med_nombre FROM productos p INNER JOIN medidas m ON p.pro_id_medida = m.med_id WHERE p.pro_codigo = '$codigo'";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function getProductos(int $id){
            $sql = "SELECT * FROM productos WHERE pro_id = $id";
            $data = $this->selectAll($sql);
            return $data;

        }

        public function registrarDetalle(int $id_pro, int $id_user, string $precio, float $cantidad, string $subtotal){
            $sql = "INSERT INTO detalle(det_id_pro, det_id_user, det_precio, det_cantidad, det_subtotal)  VALUES (?,?,?,?,?)";
            $datos= array($id_pro, $id_user, $precio, $cantidad, $subtotal);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function getDetalle(int $id){
            $sql = "SELECT d.*, p.pro_id, p.pro_descripcion FROM detalle d INNER JOIN productos p ON d.det_id_pro = p.pro_id WHERE d.det_id_user = $id";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function calcularCompra(int $id_usuario){
            $sql = "SELECT det_subtotal, SUM(det_subtotal) AS total FROM detalle WHERE det_id_user = $id_usuario";
            $data = $this->select($sql);
            return $data;
        }

        public function deleteDetalle(int $id){
            $sql = "DELETE FROM detalle WHERE det_id = ?";
            $datos= array($id);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function getDetalleBit(int $id){
            $sql = "SELECT * FROM detalle WHERE det_id = $id";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function consultarDetalle(int $id_productos, int $id_usuario){
            $sql = "SELECT * FROM detalle WHERE det_id_pro = $id_productos AND det_id_user = $id_usuario";
            $data = $this->select($sql);
            return $data;
        }

        public function actualizarDetalle(string $precio, float $cantidad, string $subtotal,int $id_pro, int $id_user){
            $sql = "UPDATE detalle SET det_precio = ?, det_cantidad = ?, det_subtotal = ? WHERE det_id_pro = ? AND det_id_user = ?";
            $datos= array($precio, $cantidad, $subtotal, $id_pro, $id_user);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function registararCompra(string $total){
            $sql = "INSERT INTO compras (comp_total) VALUES (?)";
            $datos= array($total);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function id_compra(){
            $sql = "SELECT MAX(comp_id) AS id FROM compras";
            $data = $this->select($sql);
            return $data;
        }

        public function registrarDetalleCompra(int $id_compra, int $id_producto, float $cantidad, string $precio, string $sub_total){
            $sql = "INSERT INTO detalle_compras (deco_id_compra, deco_id_producto, deco_cantidad, deco_precio, deco_subtotal) VALUES (?,?,?,?,?)";
            $datos= array($id_compra, $id_producto, $cantidad, $precio, $sub_total);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
            
        }

        public function getEmpresa(){
            $sql = "SELECT * FROM configuracion";
            $data = $this->select($sql);
            return $data;
        }

        public function vaciarDetalle(int $id_usuario){
            $sql = "DELETE FROM detalle WHERE det_id_user = ?";
            $datos= array($id_usuario);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function getProCompra(int $id_compra){
            $sql = "SELECT c.*, d.*, p.pro_id, p.pro_descripcion FROM compras c INNER JOIN detalle_compras d ON c.comp_id = d.deco_id_compra INNER JOIN productos p ON p.pro_id = d.deco_id_producto WHERE c.comp_id = $id_compra";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function getHistorialcompras(){
            $sql = "SELECT * FROM compras";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function actualizarStock(float $cantidad, int $id_producto){
            $sql = "UPDATE productos SET pro_cantidad = ? WHERE pro_id = ?";
            $datos= array($cantidad, $id_producto);
            $data = $this->save($sql, $datos);
            return $data; 
        }

        public function verificarPermiso(int $id_rol, string $nombre){
            $sql = "SELECT p.id_permiso, p.nombre_permiso, d.id_depe, d.id_rol, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id_permiso = d.id_permiso WHERE d.id_rol = $id_rol AND p.nombre_permiso = '$nombre'";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function getRangoFechas(string $desde, string $hasta){
            $sql = "SELECT * FROM compras WHERE comp_fecha BETWEEN '$desde' AND '$hasta'";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
        {
            $this->id_usuario = $id_usuario;
            $this->mensaje = $mensaje;
            $detalle = "El producto con el Nombre: " . $datos_cliente['nombre'] . 
                   ", Cantidad: " . $datos_cliente['cantidad'] . 
                   ", Subtotal: " . $datos_cliente['subtotal'] . " se ha ejecutado la acción " . $mensaje . " en la compra" ;
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
        $detalle = "EL producto con el nombre = " . $nombre . " se ha eliminado de la compra ";
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }


    }//fin de la clase


?>