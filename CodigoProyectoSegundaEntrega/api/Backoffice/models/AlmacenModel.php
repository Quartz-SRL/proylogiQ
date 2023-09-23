<?php

class AlmacenModel
{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "logiQ");
    }
    public function obtenerAlmacenes()
    {
        
        $instruccion = "SELECT * from almacenes";
        $resultado = $this->conexion->query($instruccion);
         
         $almacenes = array();

         while($filas = $resultado->fetch_assoc()){
            $almacenes[] = array(
                "id" => $filas["id"],
                "departamento" => $filas["departamento"],
                "numero" => $filas["numero"],
                "calle" => $filas["calle"],
                "ciudad" => $filas["ciudad"],
                "cantEntradas" => $filas["cantEntradas"],
                "codigoVerificacion" => $filas["codigoVerificacion"],
                "ciudadesCubre"=>$filas["ciudadesCubre"],
                "Firma" => $filas["Firma"],
                "km" => $filas["km"],
                "ruta"=>$filas["ruta"]
            );
         }
         return json_encode($almacenes);
    }
    public function ingresarAlmacen($datosAlmacen)
    {
        

        $id = $datosAlmacen['id'];
        $calle = $datosAlmacen['calle'];
        $numero = $datosAlmacen['numero'];
        $ciudad = $datosAlmacen['ciudad'];
        $departamento = $datosAlmacen['departamento'];
        $cantEntradas = $datosAlmacen['cantEntradas'];
        $codigoVerificacion = $datosAlmacen['codigoVerificacion'];
        $ciudadesCubre = $datosAlmacen['ciudadesCubre'];
        $firma = $datosAlmacen['Firma'];
        $km = $datosAlmacen['km'];
        $ruta = $datosAlmacen['ruta'];

        $sentencia = "INSERT INTO almacenes (id, calle, numero, ciudad, departamento, cantEntradas, codigoVerificacion, ciudadesCubre, Firma, km, ruta) 
                        VALUES ('$id', '$calle', '$numero', '$ciudad', '$departamento', '$cantEntradas', '$codigoVerificacion', '$ciudadesCubre', '$firma', '$km','$ruta')";

        
        return $this->conexion->query($sentencia) ;
 
    }

    public function obtenerAlmacenPorId($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");
        $sentencia = "SELECT * FROM almacenes WHERE id = '$id'";
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
        $calle = $datosModificados['calle'];
        $numero = $datosModificados['numero'];
        $ciudad = $datosModificados['ciudad'];
        $departamento = $datosModificados['departamento'];
        $cantEntradas = $datosModificados['cantEntradas'];
        $codigoVerificacion = $datosModificados['codigoVerificacion'];
        $ciudadesCubre = $datosModificados['ciudadesCubre'];
        $firma = $datosModificados['Firma'];
        $km = $datosModificados['km'];
        

        $sentencia = "UPDATE almacenes 
                    SET calle = '$calle', 
                    numero = '$numero',
                    ciudad = '$ciudad', 
                    departamento = '$departamento',
                    cantEntradas = '$cantEntradas',
                    codigoVerificacion = '$codigoVerificacion',
                    ciudadesCubre = '$ciudadesCubre',
                    Firma = '$firma',
                    km = '$km'
                     
                    WHERE id = '$idAlmacen'";

        return $this->conexion->query($sentencia);
    }

    public function eliminarAlmacen($id)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

        $sentencia = "DELETE FROM almacenes WHERE id = '$id'";

        return $conexion->query($sentencia);

    }
}


?>