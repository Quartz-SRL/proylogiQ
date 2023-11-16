<?php
require_once(__DIR__ . '/../models/lotesModel.php');
;

class loteController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new lotesModel();
    }

    public function principalLotes(){
        
        if (isset($_POST['lotes_eliminar'])) {
            $idLote = $_POST['lotes_eliminar'];
            $success = $this->modelo->eliminarLotes($idLote);

            echo json_encode(array('success' => $success));
        }

        if (isset($_POST['lotesForm'])) {
            $datosLotes = $_POST;
            
            $asignacionExitosa=$this->modelo->ingresarLotes($datosLotes);
            if ($asignacionExitosa) {
        
                echo json_encode(array("success" => true)); 
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
        }

        if (isset($_POST['modificarLotesForm'])) {
            $datosLotes = $_POST;
            
            $asignacionExitosa=$this->modelo->modificarLotes($datosLotes);
        
            if ($asignacionExitosa) {
                
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
            }
         }


    }

    public function  obtenerLotesPorId($Id){
        
        return $this->modelo->obtenerLotesPorId($Id);
    }

    public function obtenerLotes()
    {
        $LotesJson = $this->modelo->obtenerLotes();
        return $LotesJson;
    }
}    
        

$controller = new loteController();
$controller->principalLotes();

?>