<?php 
require_once(__DIR__ . '/../models/seguimientoModel.php');

class SeguimientoController{
    private $modelo;
    private $controlador;
    public function __construct(){
        $this->modelo = new seguimientoModel();
        
    }

    public function estadoPaquete($codigoPaquete){
        $estado=$this->modelo->estadoPaquete($codigoPaquete);
        return $estado; 
        
    }
}
?>