<?php
    
class PaqueteModel
{   
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "quartz");
    }
    public function obtenerPaquetes()
    {
        $instruccion = "SELECT * FROM paquetes;";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $paquetes[] = array(
                "codigoPaquete" => $fila["codigoPaquete"],
                "pesoPaquete" => $fila["pesoPaquete"],
                "departamento" => $fila["departamento"],
                //"idLote" => $fila["idLote"],
                //"matricula" => $fila["matricula"],
               // "numero" => $fila["numero"],
                "direccion" => $fila["direccion"],
                "categoria" => $fila["categoria"],
                "fechaIngreso"=>$fila["fechaIngreso"],
                "fragil"=>$fila["fragil"],
                "ciudad"=>$fila["ciudad"],
                "emailDestinatario"=>$fila["emailDestinatario"]
            );
        }
    
        return json_encode($paquetes);
    }
    public function eliminarPaquete($codigo){
        $instruccion = "DELETE FROM paquetes WHERE codigoPaquete = $codigo;";

        return $this->conexion->query($instruccion);
    }

    public function ingresarPaquete($datosPaquete){

        $codigo = $datosPaquete['codigo'];
        $peso = $datosPaquete['peso'];
        $categoria = $datosPaquete['categoria'];
        $fragil = $datosPaquete['fragil'];
        $calle = $datosPaquete['calle'];
        $numero = $datosPaquete['numero'];
        $ciudad = $datosPaquete['ciudad'];
        $departamento = $datosPaquete['departamento'];
        $emailDestino = $datosPaquete['emailDestino'];
        $telDestino = $datosPaquete['telDestino'];



        $sentencia = "INSERT INTO paquetes (
                        codigoPaquete, pesoPaquete, categoria, fragil, 
                        direccion, ciudad, departamento, 
                        emailDestinatario, telDestinatario, fechaIngreso, estado
                    ) 
                    VALUES (
                        '$codigo', '$peso', '$categoria', '$fragil', 
                        '$calle', '$ciudad', '$departamento', 
                        '$emailDestino', '$telDestino', NOW(), 'en almacen principal QC' 
                    );";

                    
        return $this->conexion->query($sentencia);
    }

    public function  obtenerPaquetePorCodigo($codigo){
        $instruccion = "SELECT * FROM paquetes WHERE codigoPaquete = $codigo;";

         $resultado = $this->conexion->query($instruccion);
        return $resultado->fetch_assoc();

    }
    public function modificarPaquete($datosModificados){
        
        $codigo = $datosModificados['codigo'];
        $peso = $datosModificados['peso'];
        $categoria = $datosModificados['categoria'];
        $fragil = $datosModificados['fragil'];
        $direccion = $datosModificados['direccion'];
        
        $ciudad = $datosModificados['ciudad'];
        $departamento = $datosModificados['departamento'];
        $emailDestino = $datosModificados['emailDestino'];
        $telDestino = $datosModificados['telDestino'];
        $fechaIngreso = $datosModificados['fechaIngreso'];



        $sentencia = "UPDATE paquetes
        SET
            pesoPaquete = '$peso',
            categoria = '$categoria',
            fragil = '$fragil',
            direccion = '$direccion',
            ciudad = '$ciudad',
            departamento = '$departamento',
            emailDestinatario = '$emailDestino',
            telDestinatario = '$telDestino',
            fechaIngreso = '$fechaIngreso'
        WHERE
            codigoPaquete = '$codigo';";
        return $this->conexion->query($sentencia);            
    }
}


?>