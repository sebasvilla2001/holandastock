<?php 

    class Views{

        public function getView($controlador, $vista, $data=""){

            $controlador = get_class($controlador);
            if ($controlador == "Home") {
                $vista = "Vistas/".$vista.".php";
            }else{

                $vista = "Vistas/".$controlador."/".$vista.".php";

            }

            require $vista;

        }



    }//fin de la clase


?>