<?php

class vehiculoModel
{
    public function obtenerVehiculos()
    {
        $conexion = new mysqli("localhost", "root", "", "logiQ");
        $sqlLigeros = "SELECT matricula, pesoMax, estado,  'Ligero' AS tipoCamion, NULL AS tamanoCaja FROM vehiculoLigero";
        $sqlPesados = "SELECT matricula, pesoMax, estado, tipoCamion, tamanoCaja FROM vehiculoPesado";

        $sqlUnion = "$sqlLigeros UNION $sqlPesados";
        $resultUnion = $conexion->query($sqlUnion);
        $vehiculos = array();
        while ($fila = $resultUnion->fetch_assoc()) {
            $vehiculos[] = array(
                "matricula" => $fila["matricula"],
                "pesoMax" => $fila["pesoMax"],
                "estado" => $fila["estado"],
                "tipoCamion" => $fila["tipoCamion"],
                "tamanoCaja" => $fila["tamanoCaja"]
            );
        }
    
        return json_encode($vehiculos);
        
    }
    public function insertarVehiculo($datosVehiculos)
    {
        $conexion = new mysqli("localhost", "root", "", "logiq");

        $matricula = $datosVehiculos['matricula'];
        $pesoMax = $datosVehiculos['pesoMax'];
        $estado = $datosVehiculos['estado'];
        $tipoVehiculo = $datosVehiculos['tipoVehiculo'];
        $tipoCamion = $datosVehiculos['tipoCamion'];
        $tamanoCaja = $datosVehiculos['tamanoCaja'];


        if ($tipoVehiculo == "ligero") {
            $sentencia = "INSERT INTO vehiculoligero (matricula, pesoMax, estado) 
            VALUES ('$matricula', '$pesoMax', '$estado')";
            if ($conexion->query($sentencia) === TRUE) {
                return "success";


            } else {
                return "error";
            }
        } else {
            $sentencia = "INSERT INTO vehiculopesado (matricula, pesoMax, estado, tipoCamion, tamanoCaja) 
            VALUES ('$matricula', '$pesoMax', '$estado','$tipoCamion', '$tamanoCaja')";

            if ($conexion->query($sentencia) === TRUE) {
                return "success";
            } else {
                return "error";
            }
        }
    }

    public function obtenerVehiculoPorMatricula($matricula)
    {

        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

        $sentenciaLigero = "SELECT * FROM vehiculoligero WHERE matricula = '$matricula'";
        $resultadoLigero = $conexion->query($sentenciaLigero);

        if ($resultadoLigero->num_rows === 1) {
            return $resultadoLigero->fetch_assoc();
        } else {
            $sentenciaPesado = "SELECT * FROM vehiculopesado WHERE matricula = '$matricula'";
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
        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

        $matricula = $datosModificados['matricula'];
        $pesoMax = $datosModificados['pesoMax'];
        $estado = $datosModificados['estado'];


        if (array_key_exists('tipoCamion', $datosModificados)) {
            $tipoCamion = $datosModificados['tipoCamion'];
            $tamanoCaja = $datosModificados['tamanoCaja'];
            $sentenciaPesados = "UPDATE vehiculopesado
            SET pesoMax = '$pesoMax', 
            estado = '$estado',
            tipoCamion = '$tipoCamion',
            tamanoCaja = '$tamanoCaja'  
            WHERE matricula = '$matricula'";
           return $conexion->query($sentenciaPesados) ;
                
            }else {
            $sentencia = "UPDATE vehiculoligero 
            SET pesoMax = '$pesoMax', 
            estado = '$estado'  
            WHERE matricula = '$matricula'";

           $respuesta=$conexion->query($sentencia) ;
                return $respuesta;
            }
        }
    



    public function eliminarVehiculo($matricula)
    {
        $conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

        $sentenciaLigero = "DELETE FROM vehiculoligero WHERE matricula = '$matricula'";
        $sentenciaPesado = "DELETE FROM vehiculopesado WHERE matricula = '$matricula'";

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