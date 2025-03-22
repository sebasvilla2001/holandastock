<?php 
    class Conexion{
        private $conect;
        public function __construct()
        {

            $pdo="mysql:host=".host.";dbname=".db.";.charset.";

            try {
                $this->conect = new PDO($pdo, user, pass);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión".$e->getMessage();
            }

        }

        public function conect(){

            return $this->conect;

        }

    }//fin de la clase




?>