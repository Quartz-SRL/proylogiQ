<?php
require_once(__DIR__ . '/../models/AlmacenModel.php');
;

class almacenController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new AlmacenModel();
    }

    public function principalAlmacen(){
        
        if (isset($_POST['almacen_eliminar'])) {
            $id = $_POST['almacen_eliminar'];
            $success = $this->modelo->eliminarAlmacen($id);

            echo json_encode(array('success' => $success));
        }

        if (isset($_POST['almacenForm'])) {
            $datosAlmacen = $_POST;
            $asignacionExitosa=$this->modelo->ingresarAlmacen($datosAlmacen);
            if ($asignacionExitosa) {
        
                echo json_encode(array("success" => true)); 
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
        }

        if (isset($_POST['modificarAlmacenForm'])) {
            $datosAlmacenMod = $_POST;
            
            $asignacionExitosa=$this->modelo->modificarAlmacen($datosAlmacenMod);
        
            if ($asignacionExitosa) {
                
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
         }


    }

    public function  obtenerAlmacenPorId($id){
        
        return $this->modelo->obtenerAlmacenPorId($id);
    }

    public function obtenerAlmacen()
    {
        $almacenesJson = $this->modelo->obtenerAlmacenes();
        return $almacenesJson;
    }
}    
        

$controller = new almacenController();
$controller->principalAlmacen();

?>