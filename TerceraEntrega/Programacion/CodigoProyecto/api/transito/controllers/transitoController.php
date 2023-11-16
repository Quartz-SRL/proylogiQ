<?php 
require_once(__DIR__ . '/../models/transitoModel.php');

session_start();
class TransitoController{
    private $modelo;
    private $matricula; 
    private $documento;
    public function __construct()
    {
        $this->modelo = new transitoModel();
        $this->matricula= $_SESSION['matricula'];
        $this->documento= $_SESSION['documento'];
    }
    
    public function asignarVehiculo(){
        $matricula1 = $this->matricula;
        $documento1 = $this->documento;

        return $this->modelo->asignarVehiculo($matricula1,$documento1);

    }
    public function asignarTrayecto(){
        
            $matricula1 = $this->matricula;
            
            $destino = $this->modelo->destinoLotesAsignados($matricula1);

            if($destino){
                $trayectoRecomendado=$this->modelo->destinoTrayectos($destino);
                if($trayectoRecomendado){
                    $this->modelo->asignarTrayecto($trayectoRecomendado, $matricula1);
                    $almacenes=$this->modelo->verTrayecto($trayectoRecomendado, $matricula1);
                    
                    return $almacenes;
                }
            }

    }

    public function entregado(){
        
        
        if (isset($_POST['idLote_entregado'])) {
            $idLote = $_POST['idLote_entregado'];
            $success = $this->modelo->marcarLoteEntregado($idLote );

            echo json_encode(array('success' => $success));
        }
    }

    public function verContenido(){
        $matricula = $this->matricula;

        $resultado= $this->modelo->obtenerLotePorCamion($matricula);
        return $resultado;
        
    }

    public function lotesEntregados(){
        $matricula=$this->matricula;
        $lotesEntregados=$this->modelo->obtenerEntregados($matricula);

        return $lotesEntregados;
    }

    public function lotesADescargar($idAlmacen){
        $lotes= $this->modelo->lotesDestinadosAlmacen($idAlmacen);
        return $lotes;
    }

    public function verContenidoTransportista(){
        $matricula=$this->matricula;
        $resultado=$this->modelo->verContenidoTransportista($matricula);
        return $resultado;
    }

    public function paquetesEntregados(){
        $matricula=$this->matricula;
        $paquetesEntregados=$this->modelo->obtenerPaquetesEntregados($matricula);

        return $paquetesEntregados;
    }

    public function entregarPaquete(){
        if(isset($_POST['codigoPaquete_entregado'])){
            $codigoPaquete=$_POST['codigoPaquete_entregado'];
            $success = $this->modelo->marcarPaqueteEntregado($codigoPaquete);

            echo json_encode(array('success' => $success));
        }
    }

    public function buscarPaquete($codigoPaquete){
        $paquete= $this->modelo->obtenerPaquete($codigoPaquete);
        return $paquete;
    }

    public function obtenerVehiculo(){
        $matricula=$this->matricula;
        $resultado=$this->modelo->obtenerVehiculo($matricula);
        return $resultado;
    }
    public function concluirRecorrido() {
        $matricula = $this->matricula;
        $documento = $this->documento;
    
        if (isset($_POST['action']) && $_POST['action'] === 'concluir_recorrido') {
            $success = $this->modelo->concluirRecorrido($matricula, $documento);
    
            header('Content-Type: application/json');
            session_destroy();
            echo json_encode(array('success' => $success));
        }
    }
        

}

$controller = new TransitoController();
$controller->asignarTrayecto();
$controller->entregado();
$controller->entregarPaquete();
$controller->concluirRecorrido();
?>