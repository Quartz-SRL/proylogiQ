<?php
class UsuarioModel
{
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "quartz");

        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
      
    }
    public function obtenerUsuarios()
    {
        
        $instruccion = "SELECT * FROM usuarios";
        $resultado =$this-> conexion->query($instruccion);
        $usuarios = array();
        while($fila = $resultado->fetch_assoc()){
            $usuarios[] = array(
                "id" => $fila["id"],
                "usuario" => $fila["usuario"],
                "contraseña" => $fila["contrasena"],
                "tipoUsuario" => $fila['tipoUsuario'],
            );
        } 
        return json_encode($usuarios);
    }
    public function insertarUsuario($datos)
    {
        

        $id = $datos['id'];
        $usuario = $datos['usuario'];
        $contraseña = $datos['contraseña'];
        $hash_contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
        $tipoUsuario = $datos['tipoUsuario'];

        
        $sentenciaUsuario = "INSERT INTO usuarios (id, usuario, contrasena, tipoUsuario) 
                        VALUES ('$id', '$usuario', '$hash_contraseña', '$tipoUsuario')";

       

        return $this->conexion->query($sentenciaUsuario);
        
    }

    public function insertarCamionero($datos){
        
        $tipoUsuario = $datos['tipoUsuario'];
        $nombre = $datos['nombre'];
        $apellido = $datos['apellido'];
        $documento = $datos['documento'];
        $enServicio = $datos['enServicio'];
        $tipoLibreta = $datos['tipoLibreta'];
        $id = $this->conexion->insert_id;
        if ($tipoUsuario === 'camionero') {
            // Insertar en la tabla  según el tipo de usuari
            $sentencia1 = "INSERT INTO choferes (documento, nombre, apellido, enServicio, id) VALUES ('$documento', '$nombre', '$apellido', '$enServicio','$id')";
            $sentencia2="INSERT INTO camionero (documento, tipoLibreta) VALUES ('$documento', '$tipoLibreta');";

            $this->conexion->query($sentencia1);

            return $this->conexion->query($sentencia2);
        }elseif($tipoUsuario === 'transportista'){
            $sentencia = "INSERT INTO choferes (documento, nombre, apellido, enServicio, id) VALUES ('$documento', '$nombre', '$apellido', '$enServicio','$id')";
            $sentencia3="INSERT INTO transportista(documento) VALUES ('$documento');";
            $this->conexion->query($sentencia);
            return $this->conexion->query($sentencia3);
        }else{
            return "error";
        }       
        

        
        
    }

    public function buscarUsuario($id)
{
    $conexion = new mysqli("127.0.0.1", "root", "", "quartz");
    $sentencia = "SELECT * FROM usuarios WHERE id = '$id';";
    $resultado = $conexion->query($sentencia);

    $usuario = $resultado->fetch_assoc();


    return $usuario;
}

    public function buscarCamionero($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");
        $sentencia = "SELECT c.*, ca.*
        FROM choferes c
        INNER JOIN camionero ca ON c.documento = ca.documento WHERE c.id='$id';
        ";
        $resultado = $conexion->query($sentencia);

        $camionero = $resultado->fetch_assoc();
        return $camionero;
        
    }

    public function buscarTransportista($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");
        $sentencia =  "SELECT c.*, t.*
        FROM choferes c
        INNER JOIN transportista t ON c.documento = t.documento WHERE c.id='$id';
        ";
        $resultado = $conexion->query($sentencia);

        $transportista = $resultado->fetch_assoc();
        return $transportista;
    }
    public function actualizarUsuario($datosModificados)
    {
      

        $idUsuario = $datosModificados['idUsuario'];
        $nuevoUsuario = $datosModificados['usuario'];
        $contraseña = $datosModificados['contraseña'];
        $hash_contraseña = password_hash($contraseña, PASSWORD_DEFAULT); 
        $tipoUsuario = $datosModificados['tipoUsuario'];

        if($datosModificados['tipoUsuario']==="camionero"){
        $tipoLibreta = $datosModificados['tipoLibreta'];
        $nombre = $datosModificados['nombre'];
        $apellido = $datosModificados['apellido'];
        $documento = $datosModificados['documento'];
        
        $sentenciaCamionero1= "UPDATE camionero
            SET 
                tipoLibreta = '$tipoLibreta'
            WHERE documento='$documento';";
            $this->conexion->query($sentenciaCamionero1);
        
        $sentenciaCamionero = "UPDATE choferes 
            SET nombre = '$nombre',
                apellido = '$apellido' 
            WHERE id = '$idUsuario';";

            $this->conexion->query($sentenciaCamionero);
       }elseif($datosModificados['tipoUsuario']==="transportista" ){

            $nombre = $datosModificados['nombre'];
            $apellido = $datosModificados['apellido'];
            $documento = $datosModificados['documento'];
            
            $sentenciaTransportista = "UPDATE choferes
            SET nombre = '$nombre',
                apellido = '$apellido',
                documento = '$documento'  
            WHERE id = '$idUsuario';";

            $this->conexion->query($sentenciaTransportista);
       }
       
       $idUsuario = $datosModificados['idUsuario'];
       $nuevoUsuario = $datosModificados['usuario'];
   
       // Verifica si ya existe un usuario con el nuevo nombre de usuario
       $consultaExistencia = "SELECT COUNT(*) AS total FROM usuarios WHERE usuario = '$nuevoUsuario' AND id != '$idUsuario';";
       $resultado = $this->conexion->query($consultaExistencia);
       $fila = $resultado->fetch_assoc();
   
       if ($fila['total'] > 0) {
           // El nuevo nombre de usuario ya existe, devuelve un mensaje de error
           return false;
       }
        
        $sentenciaUsuarios = "UPDATE usuarios 
            SET usuario = '$nuevoUsuario', 
                contrasena = ' $hash_contraseña', 
                tipoUsuario = '$tipoUsuario'  
            WHERE id = '$idUsuario';";

            return $this->conexion->query($sentenciaUsuarios);
              
    }

    public function eliminarUsuario($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");
        
        $sentencia = "DELETE FROM usuarios WHERE id = '$id';";

        return $conexion->query($sentencia);

    }
    public function eliminarCamionero($id){
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");

        $sentencia = "DELETE FROM camionero WHERE id = '$id';";

        $conexion->query($sentencia);
    }
    public function eliminarTransportista($id){
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");

        $sentencia = "DELETE FROM transportista WHERE id = '$id';";

        $conexion->query($sentencia);
    }

}


?>