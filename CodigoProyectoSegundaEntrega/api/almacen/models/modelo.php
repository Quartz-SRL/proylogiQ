<?php
class Modelo {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "logiq");

        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
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
    
    public function obtenerLotes()
    {
        $instruccion = "SELECT * FROM lotes";
        $resultado = $this->conexion->query($instruccion);
    
    $lotes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $lotes[] = array(
                "idLote" => $fila["idLote"],
                "destino" => $fila["destino"],
                "matricula" => $fila["matricula"]
            );
        }
    
        return json_encode($lotes);
    }

    public function asignarPaqueteALote($codigo, $idLote) {
        $query = "UPDATE paquetes SET idLote = $idLote WHERE codigo = $codigo";
        return $this->conexion->query($query);
    }

    public function obtenerPaquetesPorLote($loteId) {
        $instruccion = "SELECT * FROM paquetes WHERE idLote = $loteId";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $paquetes[] = $fila;
        }
    
        return $paquetes;
    }

    public function eliminarPaqueteDelLote($codigoPaquete) {
        $instruccion = "UPDATE paquetes SET idLote = NULL WHERE codigo = $codigoPaquete";
        return $this->conexion->query($instruccion);
    }

    public function obtenerVehiculosPesados(){

            $instruccion = "SELECT * FROM vehiculopesado";
            $resultado = $this->conexion->query($instruccion);
        
        $vPesado = array();
            while ($fila = $resultado->fetch_assoc()) {
                $vPesado[] = array(
                    "matricula" => $fila["matricula"],
                    "pesoMax" => $fila["pesoMax"],
                    "estado" => $fila["estado"],
                    "tipoCamion" => $fila["tipoCamion"],
                    "tamanoCaja" => $fila["tamanoCaja"]
                );
            }
        
            return json_encode($vPesado);
        
    }

    public function asignarLoteACamion($matricula,$idLote){
        $query = "UPDATE lotes SET matricula = $matricula WHERE idLote = $idLote";
        return $this->conexion->query($query);
    }

    public function obtenerLotePorCamion($matriculaLote){
        $instruccion = "SELECT * FROM lotes WHERE matricula = $matriculaLote";
        $resultado = $this->conexion->query($instruccion);
    
        $lotes = array();
        while($fila = $resultado->fetch_assoc()) {
            $lotes[] = $fila;
        }
    
        return $lotes;
    }

    public function eliminarLoteDeCamion($idLote){
        $instruccion = "UPDATE lotes SET matricula = NULL WHERE idLote = $idLote";
        return $this->conexion->query($instruccion);
    }

    public function generarLotePorDestino($codigo){
        $primeraInstruccion="SELECT departamento FROM paquetes WHERE codigo = $codigo";
        $result = $this->conexion->query($primeraInstruccion);

        $fila = $result->fetch_assoc();
        $destino = $fila['departamento'];

        $segundaInstruccion="INSERT INTO lotes (destino) VALUES ('$destino')";

        $this->conexion->query($segundaInstruccion);
    
        
        $idLoteGenerado = $this->conexion->insert_id;
    
        $terceraInstruccion = "UPDATE paquetes SET idLote = $idLoteGenerado WHERE codigo = $codigo";
        return $this->conexion->query($terceraInstruccion);
    }

    public function obtenerVehiculosLigeros(){

        $instruccion = "SELECT * FROM vehiculoligero";
        $resultado = $this->conexion->query($instruccion);
    
    $vLigero = array();
        while ($fila = $resultado->fetch_assoc()) {
            $vLigero[] = array(
                "matricula" => $fila["matricula"],
                "pesoMax" => $fila["pesoMax"],
                "estado" => $fila["estado"]
            );
        }
    
        return json_encode($vLigero);
    
}

    public function asignarPaqueteALigero($matricula,$codigo){
        $query = "UPDATE paquetes SET matricula = $matricula WHERE codigo = $codigo";
        return $this->conexion->query($query);
    }

    public function obtenerPaquetesPorLigero($matriculaPaquete){
        $instruccion = "SELECT * FROM paquetes WHERE matricula = $matriculaPaquete";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while($fila = $resultado->fetch_assoc()) {
            $paquetes[] = $fila;
        }
    
        return $paquetes;
    }

    public function eliminarPaqueteDeLigero($codigo){
        $instruccion = "UPDATE paquetes SET matricula = NULL WHERE codigo = $codigo";
        return $this->conexion->query($instruccion);
    }

    public function eliminarLote($idLote){
        $instruccion = "SELECT * FROM paquetes WHERE idLote = $idLote";
        $resultado = $this->conexion->query($instruccion);

    
        if ($resultado->num_rows === 0) {
        
           $borrarInstruccion = "DELETE FROM lotes WHERE idLote = $idLote";
           $borrarResultado = $this->conexion->query($borrarInstruccion);

        return $borrarResultado ;
        }
         
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
