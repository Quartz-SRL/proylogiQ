<?php
require_once(__DIR__ . '/../models/AlmacenModel.php');


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
                echo json_encode(array("success" => false));
            }
        }

        if (isset($_POST['modificarAlmacenForm'])) {
            $datosAlmacenMod = $_POST;
            
            $modificacionExitosa=$this->modelo->modificarAlmacen($datosAlmacenMod);
        
            echo json_encode(array('success' => $modificacionExitosa));
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

    public function crearTrayecto(){
        
// Aquí debes incluir la lógica para procesar el formulario y agregar el trayecto
if (isset($_POST['almacenes_seleccionados'])) {
    // Recuperar los datos del formulario
    
   
    $almacenesSeleccionados = isset($_POST['almacenes_seleccionados']) ? $_POST['almacenes_seleccionados'] : [];
    $demora=     isset($_POST['tiempoAlmCentral']) ? $_POST['tiempoAlmCentral'] : [];
    // Aquí debes implementar la lógica para agregar el trayecto y los almacenes seleccionados a la base de datos
    return $this->modelo->agregarTrayecto($demora, $almacenesSeleccionados); // Función de ejemplo, debes implementarla

    // Responder al cliente (puedes enviar un JSON u otra respuesta según necesidades)
    
} else {
    // Si no es una solicitud POST, redirigir o manejar según necesidades
    return json_encode(["success" => false]);
}

    }
}    
        

$controller = new almacenController();
$controller->principalAlmacen();
$controller->crearTrayecto();
?>