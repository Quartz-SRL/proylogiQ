<?php

class AlmacenModel
{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "quartz");
    }
    public function obtenerAlmacenes()
    {
        
        $instruccion = "SELECT * from almacenes;";
        $resultado = $this->conexion->query($instruccion);
         
         $almacenes = array();

         while($filas = $resultado->fetch_assoc()){
            $almacenes[] = array(
                "idAlmacen" => $filas["idAlmacen"],
                "departamento" => $filas["departamento"],
                "direccion" => $filas["direccion"],
                "ciudad"=> $filas["ciudad"],
                "telefono" => $filas["telefono"],
                "email" => $filas["email"],
                "cantEntradasParaCamion" => $filas["cantEntradasParaCamion"],
                "firma" => $filas["firma"],
            );
         }
         return json_encode($almacenes);
    }
    public function ingresarAlmacen($datosAlmacen)
    {
        

        $id = $datosAlmacen['id'];
        $direccion = $datosAlmacen['direccion'];
        $ciudad = $datosAlmacen['ciudad'];
        $departamento = $datosAlmacen['departamento'];
        $cantEntradas = $datosAlmacen['cantEntradas'];
        $codigoVerificacion = $datosAlmacen['codigoVerificacion'];
        $ciudadesCubre = $datosAlmacen['ciudadesCubre'];
        $firma = $datosAlmacen['Firma'];
        $telefono = $datosAlmacen['telefono'];
        $email = $datosAlmacen['email'];
        $tiempo=$datosAlmacen['tiempo'];

        $sentencia = "INSERT INTO almacenes (idAlmacen, direccion, ciudad, departamento, telefono, email, cantEntradasParaCamion, codigoVerificacionLlegadaCamion, firma) 
                        VALUES ( '$id','$direccion', '$ciudad', '$departamento','$telefono','$email', '$cantEntradas', '$codigoVerificacion', '$firma');";

        
        return $this->conexion->query($sentencia) ;
 
    }

    public function obtenerAlmacenPorId($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");
        $sentencia = "SELECT * FROM almacenes WHERE idAlmacen = '$id';";
        $resultado = $conexion->query($sentencia);

        if ($resultado->num_rows === 1) {
            return $resultado->fetch_assoc();

        } else {

            return null;
        }


    }

    public function modificarAlmacen($datosModificados)
    {
       

        $idAlmacen = $datosModificados['id'];
        $direccion = $datosModificados['direccion'];
        $ciudad = $datosModificados['ciudad'];
        $departamento = $datosModificados['departamento'];
        $cantEntradas = $datosModificados['cantEntradas'];
        $firma = $datosModificados['Firma'];
        $email = $datosModificados['email'];
        $telefono = $datosModificados['telefono'];

      

        $sentencia = "UPDATE almacenes 
                    SET direccion = '$direccion', 
                    ciudad = '$ciudad', 
                    departamento = '$departamento',
                    cantEntradasParaCamion = '$cantEntradas',

                    firma = '$firma',
                    telefono = '$telefono',
                    email = '$email'
                     
                    WHERE idAlmacen = '$idAlmacen';";

        return $this->conexion->query($sentencia);
    }

    public function eliminarAlmacen($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");

        $sentencia = "DELETE FROM almacenes WHERE idAlmacen = '$id';";

        return $conexion->query($sentencia);

    }

    public function agregarTrayecto($demoras, $almacenesSeleccionados) {
        // Insertar el nuevo trayecto en la tabla de trayectos
        $queryInsertTrayecto = "INSERT INTO trayectos (idTrayecto) VALUES ('');";
        $this->conexion->query($queryInsertTrayecto);
    
        // Obtener el ID del trayecto recién insertado
        $idTrayecto = $this->conexion->insert_id;
    
        // Insertar las relaciones entre el trayecto y los almacenes seleccionados en la tabla conformado
        foreach (array_combine($almacenesSeleccionados, $demoras) as $idAlmacen => $demora) {
            $queryInsertConformado = "INSERT INTO conformado (idTrayecto, idAlmacen, tiempoAlmCentral) VALUES ('$idTrayecto', '$idAlmacen', '$demora');";
            
            if ($this->conexion->query($queryInsertConformado)) {
                // La inserción se realizó con éxito
            } else {
                // Manejar el error según sea necesario
            }
        }
    }
    
}


?>