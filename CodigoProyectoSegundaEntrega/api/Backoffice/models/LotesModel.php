<?php
    
class lotesModel
{   
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "logiQ");
    }
    public function obtenerLotes()
    {
        $instruccion = "SELECT * FROM lotes";
        $resultado = $this->conexion->query($instruccion);
    
        $lotes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $lotes[] = array(
                "idLote" => $fila["idLote"],
                "pesoLote" => $fila["pesoLote"],
                "destino" => $fila["destino"],
                "matricula" => $fila["matricula"],
                "fechaIngresoLote"=>$fila["fechaIngresoLote"]
             
            );
        }
    
        return json_encode($lotes);
    }
    public function eliminarLotes($id){
        $instruccion = "DELETE FROM lotes WHERE idLote = $id";

        return $this->conexion->query($instruccion);
    }

    public function ingresarLotes($datosLote){

        $idLote = $datosLote['idLote'];
        $pesoLote = $datosLote['pesoLote'];
        $destino = $datosLote['destino'];
        $fechaIngresoLote = $datosLote['fechaIngresoLote'];



        $sentencia = "INSERT INTO lotes (
                        idLote, pesoLote, destino, fechaIngresoLote
                    ) 
                    VALUES (
                        '$idLote', '$pesoLote', '$destino', '$fechaIngresoLote'
                    )";


        return $this->conexion->query($sentencia);
    }

    public function  obtenerLotesPorId($id){
            $instruccion = "SELECT * FROM lotes WHERE idLote = $id";

         $resultado = $this->conexion->query($instruccion);
        return $resultado->fetch_assoc();

    }
    public function modificarLotes($datosModificados){
        
        $idLote = $datosModificados['idLote'];
        $pesoLote = $datosModificados['pesoLote'];
        $destino = $datosModificados['destino'];
        $fechaIngresoLote = $datosModificados['fechaIngresoLote'];


        $sentencia = "UPDATE lotes
        SET
            pesoLote = '$pesoLote',
            destino = '$destino',
            fechaIngresoLote = '$fechaIngresoLote'
            
        WHERE
            idLote = '$idLote'";
        return $this->conexion->query($sentencia);            
    }
}


?>