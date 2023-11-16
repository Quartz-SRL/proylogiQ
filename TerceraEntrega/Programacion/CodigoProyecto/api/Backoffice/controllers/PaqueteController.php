<?php
require_once(__DIR__ . '/../models/PaqueteModel.php');
;

class paqueteController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new PaqueteModel();
    }

    public function principalPaquetes(){
        
        if (isset($_POST['paquete_eliminar'])) {
            $codigo = $_POST['paquete_eliminar'];
            $success = $this->modelo->eliminarPaquete($codigo);

            echo json_encode(array('success' => $success));
        }

        if (isset($_POST['paquetesForm'])) {
            $datosPaquete = $_POST;
            
            $asignacionExitosa=$this->modelo->ingresarPaquete($datosPaquete);
            if ($asignacionExitosa) {
        
                echo json_encode(array("success" => true)); 
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
        }

        if (isset($_POST['modificarPaquetesForm'])) {
            $datosPaquete = $_POST;
            
            $asignacionExitosa=$this->modelo->modificarPaquete($datosPaquete);
        
            if ($asignacionExitosa) {
                
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
         }


    }

    public function  obtenerPaquetePorCodigo($codigo){
        
        return $this->modelo->obtenerPaquetePorCodigo($codigo);
    }

    public function obtenerPaquetes()
    {
        $paquetesJson = $this->modelo->obtenerPaquetes();
        return $paquetesJson;
    }
}    
        

$controller = new paqueteController();
$controller->principalPaquetes();

?>