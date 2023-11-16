<?php
require_once(__DIR__ . '/../models/usuarioModel.php');
;

class UsuarioController
{
    private $model;

    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    public function usuariosMetodo()
    {
        

        if (isset($_POST['altaForm'])) {
    $datosUsuario = $_POST;
    
    $asignacionExitosa=$this->model->insertarUsuario($datosUsuario);
    $asignacionExitosa2=$this->model->insertarCamionero($datosUsuario);

    if ($asignacionExitosa&&$asignacionExitosa2) {
        
        echo json_encode(array("success" => true)); 
    } else {
        echo json_encode(array("success" => false, "message" => "Error al crear el usuario"));
    }
    
}



        if (isset($_POST['idUsuarioEliminar'])) {
            $id = $_POST['idUsuarioEliminar'];
            $usuarioEncontrado = $this->model->buscarUsuario($id);

            if ($usuarioEncontrado['tipoUsuario'] === 'camionero') {

                $this->model->eliminarCamionero($id);
            }elseif($usuarioEncontrado['tipoUsuario'] === 'transportista'){
                $this->model->eliminarTransportista($id);
            }
            
            $accionExitosa=$this->model->eliminarUsuario($id);

            if ($accionExitosa) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al eliminar el usuario"));
            }
        }


       
        if (!empty($_POST["formModificar"])) {
            $datosModificados = $_POST; 

            $modificacionExitosa=$this->model->actualizarUsuario($datosModificados);
            if ($modificacionExitosa) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al modificar el usuario"));
            }
        }
        
    }
    
    public function obtenerUsuarios(){
        $usuarios= $this->model->obtenerUsuarios();
        return $usuarios;
        
    }

    public function buscarUsuario($id) {
        $idUsuario = $id;
        $usuario = $this->model->buscarUsuario($idUsuario);
        
        return $usuario;
    }
    public function buscarCamionero($id){
        $idCamionero = $id;
        return $this->model->buscarCamionero($idCamionero);
        
    }
    
    public function buscarTransportista($id){
        $idCamionero = $id;
        return $this->model->buscarTransportista($idCamionero);
        
    }

}

$controller = new UsuarioController();
$controller->usuariosMetodo();


?>