<?php
    
class PaqueteModel
{   
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "logiQ");
    }
    public function obtenerPaquetes()
    {
        $instruccion = "SELECT * FROM paquetes";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $paquetes[] = array(
                "codigo" => $fila["codigo"],
                "peso" => $fila["peso"],
                "departamento" => $fila["departamento"],
                "idLote" => $fila["idLote"],
                "matricula" => $fila["matricula"],
                "numero" => $fila["numero"],
                "calle" => $fila["calle"],
                "categoria" => $fila["categoria"],
                "fechaIngreso"=>$fila["fechaIngreso"],
                "fragil"=>$fila["fragil"],
                "ciudad"=>$fila["ciudad"],
                "emailDestino"=>$fila["emailDestino"]
            );
        }
    
        return json_encode($paquetes);
    }
    public function eliminarPaquete($codigo){
        $instruccion = "DELETE FROM paquetes WHERE codigo = $codigo";

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
        $fechaIngreso = $datosPaquete['fechaIngreso'];



        $sentencia = "INSERT INTO paquetes (
                        codigo, peso, categoria, fragil, 
                        calle, numero, ciudad, departamento, 
                        emailDestino, telDestino, fechaIngreso
                    ) 
                    VALUES (
                        '$codigo', '$peso', '$categoria', '$fragil', 
                        '$calle', '$numero', '$ciudad', '$departamento', 
                        '$emailDestino', '$telDestino', '$fechaIngreso'
                    )";


        return $this->conexion->query($sentencia);
    }

    public function  obtenerPaquetePorCodigo($codigo){
        $instruccion = "SELECT * FROM paquetes WHERE codigo = $codigo";

         $resultado = $this->conexion->query($instruccion);
        return $resultado->fetch_assoc();

    }
    public function modificarPaquete($datosModificados){
        
        $codigo = $datosModificados['codigo'];
        $peso = $datosModificados['peso'];
        $categoria = $datosModificados['categoria'];
        $fragil = $datosModificados['fragil'];
        $calle = $datosModificados['calle'];
        $numero = $datosModificados['numero'];
        $ciudad = $datosModificados['ciudad'];
        $departamento = $datosModificados['departamento'];
        $emailDestino = $datosModificados['emailDestino'];
        $telDestino = $datosModificados['telDestino'];
        $fechaIngreso = $datosModificados['fechaIngreso'];

        

        $sentencia = "UPDATE paquetes
        SET
            peso = '$peso',
            categoria = '$categoria',
            fragil = '$fragil',
            calle = '$calle',
            numero = '$numero',
            ciudad = '$ciudad',
            departamento = '$departamento',
            emailDestino = '$emailDestino',
            telDestino = '$telDestino',
            fechaIngreso = '$fechaIngreso'
        WHERE
            codigo = '$codigo'";
        return $this->conexion->query($sentencia);            
    }
}


?>