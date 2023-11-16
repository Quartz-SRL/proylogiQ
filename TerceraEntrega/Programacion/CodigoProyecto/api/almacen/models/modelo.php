<?php
class Modelo {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "quartz");
        
        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
    }
    public function obtenerPaquetes()
{
    $instruccion = "SELECT p.* 
                    FROM paquetes p
                    LEFT JOIN forman fo ON fo.codigoPaquete = p.codigoPaquete
                    WHERE fo.codigoPaquete IS NULL ;";

    $resultado = $this->conexion->query($instruccion);

    $paquetes = array();
    while ($fila = $resultado->fetch_assoc()) {
        $paquetes[] = array(
            "codigoPaquete" => $fila["codigoPaquete"],
            "pesoPaquete" => $fila["pesoPaquete"],
            "departamento" => $fila["departamento"],
            "direccion" => $fila["direccion"],
            "categoria" => $fila["categoria"],
            "fechaIngreso" => $fila["fechaIngreso"],
            "fragil" => $fila["fragil"],
            "ciudad" => $fila["ciudad"],
            "emailDestinatario" => $fila["emailDestinatario"]
        );
    }

    return json_encode($paquetes);
}

    
    public function obtenerLotes()
    {
        $instruccion = "SELECT l.*, a.departamento
        FROM lotes l 
        JOIN almacenes a ON a.idAlmacen=l.idAlmacen
        WHERE l.estado = 'cargando'
        AND NOT EXISTS (
            SELECT 1
            FROM trasladan tr
            WHERE tr.idLote = l.idLote
        );
        ";
        $resultado = $this->conexion->query($instruccion);
    
    $lotes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $lotes[] = array(
                "idLote" => $fila["idLote"],
                "destino" => $fila["departamento"],
                "pesoLote"=>$fila['pesoLote']
                
            );
        }
    
        return json_encode($lotes);
    }

    public function asignarPaqueteALote($codigo, $idLote) {
        
        $queryPaquete = "SELECT departamento FROM paquetes WHERE codigoPaquete = '$codigo';";
        $resultPaquete = $this->conexion->query($queryPaquete);
    
        $queryLote = "SELECT a.departamento FROM almacenes a
                    JOIN lotes l ON l.idAlmacen=a.idAlmacen
                     WHERE idLote = '$idLote';";
        $resultLote = $this->conexion->query($queryLote);
    
        if ($resultPaquete && $resultLote) {
            $filaPaquete = $resultPaquete->fetch_assoc();
            $filaLote = $resultLote->fetch_assoc();
    
            
            if ($filaPaquete['departamento'] === $filaLote['departamento']) {
                
                $queryAsignacion = "INSERT INTO forman (codigoPaquete, idLote)
                                  VALUES ('$codigo', '$idLote');";
                return $this->conexion->query($queryAsignacion);
            } else {
                
                return false;
            }
        } else {
           
            return false;
        }
    }
    

    public function obtenerPaquetesPorLote($loteId) {
        $instruccion = "SELECT p.* FROM paquetes p 
               JOIN (SELECT * FROM forman WHERE idLote = $loteId) f 
               ON p.codigoPaquete = f.codigoPaquete;";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $paquetes[] = $fila;
        }
        
        return $paquetes;
    }

    public function eliminarPaqueteDelLote($codigoPaquete) {
        $instruccion = "DELETE FROM forman WHERE codigoPaquete = $codigoPaquete;";
        return $this->conexion->query($instruccion);
    }

    public function obtenerVehiculosPesados(){

            $instruccion = "SELECT v.*, p.*
            FROM vehiculos v
            INNER JOIN pesados p ON v.matricula = p.matricula;
            ";
            $resultado = $this->conexion->query($instruccion);
        
        $vPesado = array();
            while ($fila = $resultado->fetch_assoc()) {
                $vPesado[] = array(
                    "matricula" => $fila["matricula"],
                    "pesoMax" => $fila["pesoMax"],
                    "estado" => $fila["estado"],
                    "tipoCamion" => $fila["tipoCamion"],
                    "tamanoCaja" => $fila["cantidadLotesCaja"]
                );
            }
        
            return json_encode($vPesado);
        
    }

    
    public function asignarLoteACamion($matricula, $idLote) {
        

        $lotes= $this->obtenerLotePorCamion($matricula);
        

        $query = "INSERT INTO trasladan (matricula, idLote) VALUES (?, ?);";
        
        
        $stmt = $this->conexion->prepare($query);
    
        if ($stmt) {
            
            $stmt->bind_param("si", $matricula, $idLote);
            
            
            if ($stmt->execute()) {
               
                return true;
            } else {
               
                return false;
            }
        } else {
            
            return false;
        }
    }
    
    

        public function obtenerLotePorCamion($matriculaLote){
            
            $instruccion = "SELECT l.*, a.departamento AS destino FROM lotes l 
            JOIN trasladan t ON l.idLote=t.idLote
            JOIN almacenes a ON a.idAlmacen=l.idAlmacen
                             WHERE matricula = ? AND l.estado <> 'entregado'; ";
           
            $stmt = $this->conexion->prepare($instruccion);
        
            if ($stmt) {
                
                $stmt->bind_param("s", $matriculaLote);
                
               
                if ($stmt->execute()) {
                  
                    $resultado = $stmt->get_result();
                    
                    $lotes = array();
                    while($fila = $resultado->fetch_assoc()) {
                        $lotes[] = $fila;
                    }
        
                    
                    $stmt->close();
                    
                    return $lotes;
                } else {
                    
                    return false;
                }
            } else {
                
                return false;
            }
        }
        

    public function eliminarLoteDeCamion($idLote){
        $instruccion = "DELETE FROM trasladan WHERE idLote = $idLote;";
        return $this->conexion->query($instruccion);
    }

    public function generarLotePorDestino($codigo){
        $primeraInstruccion = "SELECT departamento , pesoPaquete FROM paquetes WHERE codigoPaquete = '$codigo'";
        $result = $this->conexion->query($primeraInstruccion);
    
        if ($result) {
            $fila = $result->fetch_assoc();
            $departamento = $fila['departamento'];
            $peso=$fila['pesoPaquete'];
    
            $segundaInstruccion = "INSERT INTO lotes (idAlmacen, pesoLote, fechaIngresoLote, estado ) 
                                    VALUES ((SELECT DISTINCT idAlmacen FROM almacenes WHERE departamento='$departamento'),'$peso',NOW(),'cargando')";
            $this->conexion->query($segundaInstruccion);
        
            $idLoteGenerado = $this->conexion->insert_id;
        
            $terceraInstruccion = "INSERT INTO forman (codigoPaquete, idLote) VALUES ('$codigo', '$idLoteGenerado')";
            return $this->conexion->query($terceraInstruccion);
        } else {
            // Manejo de error si la consulta no es exitosa
            return false;
        }
    }
    

    public function obtenerVehiculosLigeros(){

        $instruccion = "SELECT v.*, p.*
            FROM vehiculos v
            INNER JOIN ligeros p ON v.matricula = p.matricula;
            ";
        $resultado = $this->conexion->query($instruccion);
    
    $vLigero = array();
        while ($fila = $resultado->fetch_assoc()) {
            $vLigero[] = array(
                "matricula" => $fila["matricula"],
                "pesoMax" => $fila["pesoMax"],
                "estado" => $fila["estado"],
                "idAlmacen"=> $fila["idAlmacen"]
            );
        }
    
        return json_encode($vLigero);
    
}

public function asignarPaqueteALigero($matricula, $codigo) {
    // Preparar la consulta SQL con una sentencia preparada
    $query = "INSERT INTO llevan (matricula, codigoPaquete) VALUES (?, ?);";
    
    // Preparar la sentencia
    $stmt = $this->conexion->prepare($query);

    if ($stmt) {
        // Vincular los parámetros y sus tipos
        $stmt->bind_param("ss", $matricula, $codigo);
        
        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            return true;
        } else {
            // Error al ejecutar la sentencia
            return false;
        }
    } else {
        // Error al preparar la sentencia
        return false;
    }
}


public function obtenerPaquetesPorLigero($matriculaPaquete) {
    // Escapar el valor para evitar inyección SQL
    $matriculaPaquete = $this->conexion->real_escape_string($matriculaPaquete);
    
    $instruccion = "SELECT * FROM llevan WHERE matricula = '$matriculaPaquete';";
    $resultado = $this->conexion->query($instruccion);

    $paquetes = array();
    while ($fila = $resultado->fetch_assoc()) {
        $paquetes[] = $fila;
    }

    return $paquetes;
}


    public function eliminarPaqueteDeLigero($codigo){
        $instruccion = "DELETE FROM llevan  WHERE codigoPaquete = $codigo;";
        return $this->conexion->query($instruccion);
    }

    public function eliminarLote($idLote){
        $instruccion = "SELECT * FROM forman WHERE idLote = $idLote;";
        $resultado = $this->conexion->query($instruccion);

    
        if ($resultado->num_rows === 0) {
        
           $borrarInstruccion = "DELETE FROM lotes WHERE idLote = $idLote;";
           $borrarResultado = $this->conexion->query($borrarInstruccion);

        return $borrarResultado ;
        }
         
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
