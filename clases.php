<?php
    class Pais{
        public $ID;
        public $Nombre;
        public $TotalDepartamentos;


        function __Construct($paisID = null, $paisNOM = null, $totalDEP){
            $this->ID = $paisID;
            $this->Nombre = $paisNOM;
            $this->TotalDepartamentos = $totalDEP;
        }
    }
?>