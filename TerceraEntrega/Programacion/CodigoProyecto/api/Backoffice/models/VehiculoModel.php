<?php

class vehiculoModel
{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "quartz");
    }
    public function obtenerVehiculos()
    {
        $conexion = new mysqli("localhost", "root", "", "quartz");

        $sentencia = "SELECT DISTINCT v.*, p.tipoCamion, p.cantidadLotesCaja
        FROM vehiculos v
        JOIN pesados p ON p.matricula = v.matricula
        
        UNION 
        
        SELECT DISTINCT  v.*, NULL as tipoCamion, NULL as cantidadLotesCaja
        FROM vehiculos v
        JOIN ligeros l ON l.matricula = v.matricula;
        ";
        

       
        $resultUnion = $conexion->query($sentencia);
        $vehiculos = array();
        while ($fila = $resultUnion->fetch_assoc()) {
            $vehiculos[] = array(
                "matricula" => $fila["matricula"],
                "pesoMax" => $fila["pesoMax"],
                "estado" => $fila["estado"],
                "tipoCamion" => $fila["tipoCamion"],
                "cantidadLotesCaja" => $fila["cantidadLotesCaja"]
            );
        }
    
        return json_encode($vehiculos);
        
    }
    public function insertarVehiculo($datosVehiculos)
    {
        $conexion = new mysqli("localhost", "root", "", "quartz");

        $matricula = $datosVehiculos['matricula'];
        $pesoMax = $datosVehiculos['pesoMax'];
        $estado = $datosVehiculos['estado'];
        $tipoVehiculo = $datosVehiculos['tipoVehiculo'];
        $tipoCamion = $datosVehiculos['tipoCamion'];
        $tamanoCaja = $datosVehiculos['tamanoCaja'];
        $idAlmacen = $datosVehiculos['idAlmacen'];

        if ($tipoVehiculo == "ligero") {
            $sentenciaLigero1= "INSERT INTO vehiculos (matricula, pesoMax, estado) 
            VALUES ('$matricula', '$pesoMax', '$estado');";

            $sentenciaLigero2= "INSERT INTO ligeros(matricula, idAlmacen)
            VALUES ('$matricula', '$idAlmacen');";

            $conexion->query($sentenciaLigero1);

            if ($conexion->query($sentenciaLigero2) === TRUE) {
                return "success";


            } else {
                return "error";
            }
        } else {
            $sentenciaPesado1="INSERT INTO vehiculos (matricula, pesoMax, estado) 
            VALUES ('$matricula', '$pesoMax', '$estado');";

            $sentenciaPesado2 = "INSERT INTO pesados (matricula, tipoCamion, cantidadLotesCaja) 
            VALUES ('$matricula','$tipoCamion', '$tamanoCaja');";
            $conexion->query($sentenciaPesado1);
            if ($conexion->query($sentenciaPesado2) === TRUE) {
                return "success";
            } else {
                return "error";
            }
        }
    }

    public function obtenerVehiculoPorMatricula($matricula)
    {

        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");

        $sentenciaLigero ="SELECT v.*, l.*
        FROM vehiculos v
        INNER JOIN ligeros l ON v.matricula = l.matricula WHERE v.matricula='$matricula';
        ";
        $resultadoLigero = $conexion->query($sentenciaLigero);

        if ($resultadoLigero->num_rows === 1) {
            return $resultadoLigero->fetch_assoc();
        } else {
            $sentenciaPesado = "SELECT v.*, p.*
            FROM vehiculos v
            INNER JOIN pesados p ON v.matricula = p.matricula WHERE v.matricula='$matricula';
            ";
            $resultadoPesado = $conexion->query($sentenciaPesado);

            if ($resultadoPesado->num_rows === 1) {
                return $resultadoPesado->fetch_assoc();
            } else {
                return null;
            }
        }
    }






    public function actualizarVehiculo($datosModificados)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "quartz");

        $matricula = $datosModificados['matricula'];
        $pesoMax = $datosModificados['pesoMax'];
        $estado = $datosModificados['estado'];
        
        

        if (array_key_exists('tipoCamion', $datosModificados)) {
            $tipoCamion = $datosModificados['tipoCamion'];
            $tamanoCaja = $datosModificados['tamanoCaja'];

            $sentenciaPesados= "UPDATE vehiculos
            SET pesoMax = '$pesoMax', 
            estado = '$estado' 
            WHERE matricula = '$matricula';";

            $sentenciaPesados1 = "UPDATE pesados
            SET
            tipoCamion = '$tipoCamion',
            cantidadLotesCaja = '$tamanoCaja'  
            WHERE matricula = '$matricula';";

            $conexion->query($sentenciaPesados) ;
           return $conexion->query($sentenciaPesados1) ;
                
            }else {

            

            $sentencialigero2 = "UPDATE vehiculos
            SET pesoMax = '$pesoMax', 
            estado = '$estado'
            
            WHERE matricula = '$matricula';";

            

            

           $respuesta=$conexion->query($sentencialigero2) ;
                return $respuesta;
            }
        }
    



        public function eliminarVehiculo($matricula)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

        $sentenciaLigero = "DELETE FROM vehiculoligero WHERE matricula = '$matricula';";
        $sentenciaPesado = "DELETE FROM vehiculopesado WHERE matricula = '$matricula';";

        $eliminacionLigeroExitosa = $conexion->query($sentenciaLigero);
        $eliminacionPesadoExitosa = $conexion->query($sentenciaPesado);

        if ($eliminacionLigeroExitosa || $eliminacionPesadoExitosa) {
            return "success";
        } else {
            return "error";
        }
    }
        


}


?>