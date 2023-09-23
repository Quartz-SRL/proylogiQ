<?php
require_once(__DIR__ . '/../models/VehiculoModel.php');

class vehiculoController
{
    private $model;

    public function __construct()
    {
        $this->model = new VehiculoModel();
    }

    public function principalVehiculos()
    {
        


        if (isset($_POST['alta'])) {

            $datosVehiculo = $_POST;
            $respuesta = $this->model->insertarVehiculo($datosVehiculo);
            
            if($respuesta){

            
            echo json_encode(array("success" => true)); 
        } else {
            echo json_encode(array("success" => false, "message" => "Error al crear el vehiculo"));
        }
         }

        
        

        if (isset($_POST['vehiculo_eliminar'])) {
            $matricula = $_POST['vehiculo_eliminar'];
            $eliminado=$this->model->eliminarVehiculo($matricula);
            if($eliminado){

            
                echo json_encode(array("success" => true)); 
            } else {
                echo json_encode(array("success" => false, "message" => "Error al crear el vehiculo"));
            }
        }

        

        if (isset($_POST["modVehiculo"])) {
            $datosModificados = $_POST; 
            $respuesta2=$this->model->actualizarVehiculo($datosModificados);
            
            if($respuesta2){
             echo "vehiculo modificado correctamente";
            } else {
                echo json_encode(array("success" => false, "message" => "Error al modificar el vehiculo"));
            }
        }
        
    }

    public function obtenerVehiculos(){
        
        $vehiculo = $this->model->obtenerVehiculos();
        return $vehiculo;
    }

    public function obtenerVehiculoPorMatricula($matricula){
        $vehiculo = $this->model->obtenerVehiculoPorMatricula($matricula);
        return $vehiculo;
    }

}


$controller = new vehiculoController();
$controller->principalVehiculos();

?>