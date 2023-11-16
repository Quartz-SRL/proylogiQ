<?php
    
class lotesModel
{   
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "quartz");
    }
    public function obtenerLotes()
    {
        $instruccion = "SELECT * FROM lotes;";
        $resultado = $this->conexion->query($instruccion);
    
        $lotes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $lotes[] = array(
                "idLote" => $fila["idLote"],
                "pesoLote" => $fila["pesoLote"],
                "idAlmacen" => $fila["idAlmacen"],
                "fechaIngresoLote"=>$fila["fechaIngresoLote"]
             
            );
        }
    
        return json_encode($lotes);
    }
    public function eliminarLotes($id){
        $instruccion = "DELETE FROM lotes WHERE idLote = $id;";

        return $this->conexion->query($instruccion);
    }

    public function ingresarLotes($datosLote){

        $idLote = $datosLote['idLote'];
        $pesoLote = $datosLote['pesoLote'];
        
        $idAlmacen=$datosLote['idAlmacen'];



        $sentencia = "INSERT INTO lotes (
                        idLote, pesoLote, fechaIngresoLote, estado, idAlmacen
                    ) 
                    VALUES (
                        '$idLote', '$pesoLote',  NOW(), 'cargando','$idAlmacen'
                    );";


        return $this->conexion->query($sentencia);
    }

    public function  obtenerLotesPorId($id){
            $instruccion = "SELECT * FROM lotes WHERE idLote = $id;";

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
            idAlmacen = '$destino',
            fechaIngresoLote = '$fechaIngresoLote'
            
        WHERE
            idLote = '$idLote';";
        return $this->conexion->query($sentencia);            
    }
}


?>