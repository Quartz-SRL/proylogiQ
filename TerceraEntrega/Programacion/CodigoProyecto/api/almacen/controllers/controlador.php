<?php
include(__DIR__ . '/../models/modelo.php');

class Controlador
{
    private $modelo;
    private $almacen;
    public function __construct()
    {
        
       //$this->almacen= $_SESSION['almacen'];
        
        $this->modelo = new Modelo();
    }
    

    public function obtenerPaquetes()
    {
        
        $paquetesJson = $this->modelo->obtenerPaquetes();
        return $paquetesJson;
    }
    public function ingresarPaquete(){
        
        
        if (isset($_POST['paquetesForm'])) {
            $datosPaquete = $_POST;
            $asignacionExitosa=$this->modelo->ingresarPaquete($datosPaquete);
          
            if ($asignacionExitosa) {
                
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el paquete"));
            }
    }
    }
    public function obtenerLotes()
    {
       
        $lotesJson = $this->modelo->obtenerLotes();
        return $lotesJson;
    }

    public function asignarPaqueteALote()
    {
        if (isset($_POST['paquete_id']) && isset($_POST['lote_id'])) {
            $paqueteId = $_POST['paquete_id'];
            $loteId = $_POST['lote_id'];

            $asignacionExitosa = $this->modelo->asignarPaqueteALote($paqueteId, $loteId);

            echo json_encode(array("success" => $asignacionExitosa));
        }
    }

    public function obtenerPaquetesPorLote($loteId)
    {
        return $this->modelo->obtenerPaquetesPorLote($loteId);
    }

    public function eliminarPaqueteDelLote()
    {
        if (isset($_POST['paquete_id_eliminar'])) {
            $codigoPaquete = $_POST['paquete_id_eliminar'];
            $success = $this->modelo->eliminarPaqueteDelLote($codigoPaquete);

            echo json_encode(array('success' => $success));
        }
    }

    public function obtenerVehiculosPesados()
    {
        $vPesadosJson = $this->modelo->obtenerVehiculosPesados();
        return $vPesadosJson;
    }



    public function asignarLoteACamion()
    {
        if (isset($_POST['matriculaCamion']) && isset($_POST['idLote'])) {
            $matricula = $_POST['matriculaCamion'];
            $loteId = $_POST['idLote'];
            $asignacionExitosa = $this->modelo->asignarLoteACamion($matricula, $loteId);

            echo json_encode(array("success" => $asignacionExitosa));
        }
    }

    public function obtenerlotePorCamion($matriculaLote)
    {
        return $this->modelo->obtenerlotePorCamion($matriculaLote);
    }

    public function eliminarLoteDeCamion()
    {
        if (isset($_POST['idLoteEliminar'])) {
            $idLote = $_POST['idLoteEliminar'];
            $success = $this->modelo->eliminarLoteDeCamion($idLote);

            echo json_encode(array('success' => $success));
        }
    }

    public function generarLotePorDestino()
    {
        if (isset($_POST['codigo_paquete'])) {

            $codigo = $_POST['codigo_paquete'];

            $success = $this->modelo->generarLotePorDestino($codigo);
            echo json_encode(array('success' => $success));
        }
    }

    public function obtenerVehiculosLigeros()
    {
        $vLigerosJson = $this->modelo->obtenerVehiculosLigeros();
        return $vLigerosJson;
    }

    public function eliminarLote()
    {
        if (isset($_POST['lote_id_eliminar'])) {
            $idLote = $_POST['lote_id_eliminar'];

            $success = $this->modelo->eliminarLote($idLote);

            if ($success) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        }
    }


    public function asignarPaqueteALigero()
    {
        if (isset($_POST['matriculaLigero']) && isset($_POST['codigo'])) {
            $matriculaLigero = $_POST['matriculaLigero'];
            $codigo = $_POST['codigo'];
            $asignacionExitosa = $this->modelo->asignarPaqueteALigero($matriculaLigero, $codigo);

            echo json_encode(array("success" => $asignacionExitosa));
        }
    }

    public function obtenerPaquetesPorLigeros($matriculaPaquete)
    {
        return $this->modelo->obtenerPaquetesPorLigero($matriculaPaquete);
    }

    public function eliminarPaqueteDeLigero()
    {
        if (isset($_POST['codigoPaqueteEliminar'])) {
            $codigo = $_POST['codigoPaqueteEliminar'];
            $success = $this->modelo->eliminarPaqueteDeLigero($codigo);

            echo json_encode(array('success' => $success));
        }
    }
    public function eliminarPaquete(){

        if (isset($_POST['paquete_eliminar'])) {
            $codigo = $_POST['paquete_eliminar'];
            $success = $this->modelo->eliminarPaquete($codigo);

            echo json_encode(array('success' => $success));
        }
    }

   

    public function  obtenerPaquetePorCodigo($codigo){
        
        return $this->modelo->obtenerPaquetePorCodigo($codigo);
    }

    public function modificarPaquete(){
        if (isset($_POST['modificarPaquetesForm'])) {
            $datosPaquete = $_POST;
            
            $asignacionExitosa=$this->modelo->modificarPaquete($datosPaquete);
        
            if ($asignacionExitosa) {
                
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error"));
            }
    }
    }
}
$contr = new Controlador();
$contr->asignarPaqueteALigero();
$contr->eliminarPaqueteDeLigero();
$contr->asignarLoteACamion();
$contr->asignarPaqueteALote();
$contr->eliminarPaqueteDelLote();
$contr->eliminarLoteDeCamion();
$contr->generarLotePorDestino();
$contr->eliminarLote();
$contr->eliminarPaquete();
$contr->ingresarPaquete();
$contr->modificarPaquete();
?>