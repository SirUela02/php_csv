<?php

    class baseDatos{
        public static function conectarDB($baseDatos){
            $host = 'localhost';
            $user = 'root';
            $contraseña = '';
            $baseDatos = $baseDatos;

            $conexionExitosa = mysqli_connect($host,$user,$contraseña);

            mysqli_set_charset($conexionExitosa,'utf8');
            mysqli_select_db($conexionExitosa,$baseDatos);

            return $conexionExitosa;
        }
        public static function GuardarBD2($id, $nombre,$cadeConexion){
            $sql = "INSERT INTO continentes (id,nombre) VALUES ('$id','$nombre')";
            $verifica = mysqli_query($cadeConexion,$sql);

            return $verifica;
        }
        public static function GuardarBD($id, $nombre,$continente,$cadeConexion){
            $sql = "INSERT INTO paises (id,nombre,continente) VALUES ('$id','$nombre','$continente')";
            $verifica = mysqli_query($cadeConexion,$sql);
            
            return $verifica;
        }
    }

    class Continente{
        public $ID;
        public $Nombre;
        
        function __construct($ID = null, $Nombre = null)
        {
            if($ID){
                $this-> ID = $ID;
            }
            if($Nombre){
                $this-> Nombre = $Nombre;
            }
        }

        public static function nombreContinente($id, $arrayContinentes){
            foreach($arrayContinentes as $Continente){
                if($Continente-> ID == $id){
                    return $Continente-> Nombre;
                }
            }
        } 
    }

    class Pais{
        public $ID;
        public $Nombre;
        public $Continente;

        public $FilaCorrecta;

        function __Construct($ID = null, $Nombre = null, $Continente = null, $FilaCorrecta = null){
            if($ID){
                $this->ID = $ID;
            }
            if($Nombre){
                $this->Nombre = $Nombre;
            }
            if($Continente){
                $this->Continente = $Continente;
            }
            $this->FilaCorrecta = $FilaCorrecta;
            
        }
        public static function agregaPais(&$arrayPaises, Pais $nuevoPais){
            array_push($arrayPaises, $nuevoPais);
        }
        public static function borraPais(&$arrayPaises, $indice){
            array_splice($arrayPaises, $indice, 1);
        }
    }

    $Continentes = [
        new Continente(1, "America"),
        new Continente(2, "Asia"),
        new Continente(3, "Africa"),
        new Continente(4, "Oceania"),
        new Continente(5, "Europa")
    ];
    
?>