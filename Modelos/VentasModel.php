<?php 

    class VentasModel extends Query{
        public function __construct(){
            parent::__construct();
        }

        public function getClientes(){
            $sql = "SELECT * FROM clientes WHERE cliente_estado = 1";
            $data = $this->selectAll($sql);
            return $data;

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
            $sql = "INSERT INTO detalleventa(det_id_pro, det_id_user, det_precio, det_cantidad, det_subtotal)  VALUES (?,?,?,?,?)";
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
            $sql = "SELECT d.*, p.pro_id, p.pro_descripcion FROM detalleventa d INNER JOIN productos p ON d.det_id_pro = p.pro_id WHERE d.det_id_user = $id";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function getDetalleBit(int $id){
            $sql = "SELECT * FROM detalleventa WHERE det_id = $id";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function calcularVenta(int $id_usuario){
            $sql = "SELECT det_subtotal, SUM(det_subtotal) AS total FROM detalleventa WHERE det_id_user = $id_usuario";
            $data = $this->select($sql);
            return $data;
        }

        public function deleteDetalleVenta(int $id){
            $sql = "DELETE FROM detalleventa WHERE det_id = ?";
            $datos= array($id);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function consultarDetalle(int $id_productos, int $id_usuario){
            $sql = "SELECT * FROM detalleventa WHERE det_id_pro = $id_productos AND det_id_user = $id_usuario";
            $data = $this->select($sql);
            return $data;
        }

        public function actualizarDetalle(string $precio, float $cantidad, string $subtotal,int $id_pro, int $id_user){
            $sql = "UPDATE detalleventa SET det_precio = ?, det_cantidad = ?, det_subtotal = ? WHERE det_id_pro = ? AND det_id_user = ?";
            $datos= array($precio, $cantidad, $subtotal, $id_pro, $id_user);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "modificado";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function registararVenta(string $total){
            $sql = "INSERT INTO ventas (vent_total) VALUES (?)";
            $datos= array($total);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function id_venta(){
            $sql = "SELECT MAX(vent_id) AS id FROM ventas";
            $data = $this->select($sql);
            return $data;
        }

        public function registrarDetalleVenta(int $id_venta, int $id_producto, float $cantidad, string $descuento,  string $precio, string $sub_total){
            $sql = "INSERT INTO detalle_venta (deve_id_venta, deve_id_producto, deve_cantidad, deve_descuento, deve_precio, deve_subtotal) VALUES (?,?,?,?,?,?)";
            $datos= array($id_venta, $id_producto, $cantidad, $descuento, $precio, $sub_total);
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
            $sql = "DELETE FROM detalleventa WHERE det_id_user = ?";
            $datos= array($id_usuario);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function getProVenta(int $id_venta){
            $sql = "SELECT v.*, d.*, p.pro_id, p.pro_descripcion FROM ventas v INNER JOIN detalle_venta d ON v.vent_id = d.deve_id_venta INNER JOIN productos p ON p.pro_id = d.deve_id_producto WHERE v.vent_id = $id_venta";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function getHistorialventas(){
            $sql = "SELECT * FROM ventas";
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
            $sql = "SELECT * FROM ventas WHERE vent_fecha BETWEEN '$desde' AND '$hasta'";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function actualizarDescuento(string $desc, $sub_total, int $id){
            $sql = "UPDATE detalleventa SET det_descuento = ?, det_subtotal = ? WHERE det_id = ?";
            $datos= array($desc, $sub_total, $id);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
            return $res; 
        }

        public function verificarDescuento(int $id){
            $sql = "SELECT * FROM detalleventa WHERE det_id = $id";
            $data = $this->selectAll($sql);
            return $data;
        }

        public function registrarMovNew(string $id_usuario, string $mensaje, array $datos_cliente)
        {
            $this->id_usuario = $id_usuario;
            $this->mensaje = $mensaje;
            $detalle = "El producto con el Nombre: " . $datos_cliente['nombre'] . 
                   ", Cantidad: " . $datos_cliente['cantidad'] . 
                   ", Subtotal: " . $datos_cliente['subtotal'] . " se ha ejecutado la acción " . $mensaje . " en la venta" ;
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
        $detalle = "EL producto con el nombre = " . $nombre . " se ha eliminado de la venta";
        $datos = array($this->id_usuario,$mensaje, $detalle);
        $data = $this->save($sql, $datos);
    
        return ($data == 1);
    }



    }//fin de la clase 


?>