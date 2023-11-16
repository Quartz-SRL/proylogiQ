<?php
class transitoModel
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "quartz");

        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
    }

    
    public function lotesAsignados($matricula)
    {
        $sql = "SELECT * FROM trasladan
                WHERE matricula=$matricula;";
        $result = $this->conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function asignarVehiculo($matricula, $documento) {
        try {
            
            $validacionMatricula = "SELECT l.matricula
                                    FROM ligeros l 
                                    JOIN vehiculos v ON v.matricula=l.matricula
                                    WHERE l.matricula='$matricula';";
    
            $resultadoMatricula = $this->conexion->query($validacionMatricula);
    
            if ($resultadoMatricula->num_rows > 0) {
                
                $sentenciaVehiculos1 = "UPDATE vehiculos SET estado = 'ocupado' WHERE matricula = '$matricula';";
                $this->conexion->query($sentenciaVehiculos1);
    
                
                $sentenciaConducen = "INSERT INTO conducen (matricula, documento, fechaInicioConduccion) VALUES ('$matricula', '$documento', NOW());";
                return $this->conexion->query($sentenciaConducen);
            } else {
                
                $sentenciaVehiculos = "UPDATE vehiculos SET estado = 'ocupado' WHERE matricula = '$matricula';";
                $this->conexion->query($sentenciaVehiculos);
    
                
                $sentenciaManejan = "INSERT INTO maneja (matricula, documento, fechaInicioManeja) VALUES ('$matricula', '$documento', NOW());";
                return $this->conexion->query($sentenciaManejan);
            }
        } catch (mysqli_sql_exception $e) {
           
            echo "Error en la asignación, asegúrese de que el número de documento y la matricula sean válidos.";
        }
    }
    
    public function concluirRecorrido($matricula, $documento) {
        $validacionMatricula = "SELECT l.matricula
                                FROM ligeros l 
                                JOIN vehiculos v ON v.matricula = l.matricula
                                WHERE l.matricula = '$matricula';";
    
        $resultadoMatricula = $this->conexion->query($validacionMatricula);
    
        if ($resultadoMatricula->num_rows > 0) {
          
            $sentenciaVehiculos1 = "UPDATE vehiculos SET estado = 'libre' WHERE matricula = '$matricula';";
            $this->conexion->query($sentenciaVehiculos1);
    
           
            $sentenciaConducen = "UPDATE conducen SET fechaFinConduccion = NOW() WHERE matricula = '$matricula' AND documento = '$documento' AND fechaFinConduccion IS NULL;";
            return $this->conexion->query($sentenciaConducen);
        } else {
            
            $sentenciaVehiculos = "UPDATE vehiculos SET estado = 'libre' WHERE matricula = '$matricula';";
            $this->conexion->query($sentenciaVehiculos);
    
            
            $sentenciaManejan = "UPDATE maneja SET fechaFinManeja = NOW() WHERE matricula = '$matricula' AND documento = '$documento' AND fechaFinManeja IS NULL;";
            return $this->conexion->query($sentenciaManejan);
        }
    }
    
    
    


    //obtengo los destinos de los lotes que estan asignados al camion del chofer para luego comparar
    //con la ubicacion de los alcenes que contiene un trayecto
    public function destinoLotesAsignados($matricula)
    {
        $sql = "SELECT a.departamento AS destino 
                FROM trasladan t 
                JOIN lotes l ON t.idLote=l.idLote 
                JOIN almacenes a ON l.idAlmacen=a.idAlmacen
                WHERE t.matricula = '$matricula';";

        $result = $this->conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    //busco los trayectos que contengan almacenes que estan en ubicacion del destino.
    //y filtro por el de menor suma de tiempo para recomendar trayecto mas corto
    public function destinoTrayectos($destino)
    {
        //  consulta para obtener los trayectos
        $destinos = implode("', '", $destino);
        $sql = "SELECT DISTINCT c.idTrayecto 
               FROM almacenes a 
        JOIN conformado c ON a.idAlmacen = c.idAlmacen
        WHERE a.departamento IN ('$destinos');";
        $result = $this->conexion->query($sql);

        if ($result->num_rows > 0) {
            $trayectos = array();

            
            while ($row = $result->fetch_assoc()) {
                $idTrayecto = $row['idTrayecto'];

                // Realiza la segunda consulta para obtener la suma de tiempoAlmCentral
                $sql = "SELECT c.idTrayecto, SUM(c.tiempoAlmCentral) AS tiempo_total
                      FROM conformado c
                       WHERE c.idTrayecto = $idTrayecto
                       GROUP BY c.idTrayecto;";
                $result2 = $this->conexion->query($sql);

                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $trayectos[] = $row2;
                }
            }

            // Encuentra el trayecto con la suma de tiempoAlmCentral más baja
            $trayectoMinTiempo = null;
            $minTiempo = PHP_INT_MAX; // Inicializa con un valor grande

            foreach ($trayectos as $trayecto) {
                if ($trayecto['tiempo_total'] < $minTiempo) {
                    $minTiempo = $trayecto['tiempo_total'];
                    $trayectoMinTiempo = $trayecto;
                }
            }

            return $trayectoMinTiempo;
        } else {
            return false;
        }

    }
    public function asignarTrayecto($trayectoRecomendado, $matricula) {
        $trayecto = $trayectoRecomendado["idTrayecto"];
        
        $sentencia1 = "SELECT idLote FROM trasladan 
                    WHERE matricula = '$matricula';";
        $result = $this->conexion->query($sentencia1);
        
        while ($row = $result->fetch_assoc()) {
            $idLote = $row["idLote"];
            
            // Verifica si el par idLote e idTrayecto ya está asignado
            $verificarAsignacion = "SELECT COUNT(*) AS count FROM toman WHERE idLote = '$idLote';";
            $resultVerificar = $this->conexion->query($verificarAsignacion);
            $rowVerificar = $resultVerificar->fetch_assoc();
            
            // si ya está asignado, no hace nada
            if ($rowVerificar['count'] > 0) {
                continue;
            }
            $sentencia1 = 'UPDATE lotes SET estado = "en trafico"';
            // Si no está asignado, lo asigna
            $sql = "INSERT INTO toman (idLote, idTrayecto, estadoTrayecto, fechaInicioTrayecto) 
            VALUES ('$idLote', '$trayecto', 'iniciado', NOW());";
            $this->conexion->query($sql);
    
            // Obtener códigos de paquetes asociados al lote
            $sentenciaPaquetes = "SELECT codigoPaquete FROM forman WHERE idLote = '$idLote';";
            $resultPaquetes = $this->conexion->query($sentenciaPaquetes);
    
            while ($rowPaquete = $resultPaquetes->fetch_assoc()) {
                $codigoPaquete = $rowPaquete['codigoPaquete'];
    
                // Actualizar estado del paquete a 'en tránsito'
                $sqlActualizarEstado = "UPDATE paquetes SET estado = 'en transito' WHERE codigoPaquete = '$codigoPaquete';";
                $this->conexion->query($sqlActualizarEstado);
            }
        }
    }
    
    

    //obtener almacenes del trayecto para luego visualizar ruta e indicar cual parada hacer primero
    public function verTrayecto($idTrayecto, $matricula) {
        $id = $idTrayecto["idTrayecto"];
        $sentencia1 = "SELECT a.idAlmacen, a.direccion, a.ciudad, a.departamento, c.tiempoAlmCentral, c.idTrayecto, COUNT(tm.idLote) AS cantidadLotes
        FROM conformado c
        JOIN almacenes a ON c.idAlmacen = a.idAlmacen
        JOIN trayectos t ON t.idTrayecto=c.idTrayecto
        JOIN toman tm ON t.idTrayecto=tm.idTrayecto
        JOIN trasladan tr ON tr.idLote=tm.idLote
        JOIN lotes l ON tr.idLote = l.idLote
        WHERE c.idTrayecto = '$id' AND tr.matricula='$matricula' AND (DATE(tm.fechaFinTrayecto) = CURDATE() OR tm.fechaFinTrayecto is NULL ) AND a.idAlmacen=l.idAlmacen
        GROUP BY a.idAlmacen
        ORDER BY c.tiempoAlmCentral;";

    
        $result = $this->conexion->query($sentencia1);
    
        $almacenes = array();
    
        while ($row = $result->fetch_assoc()) {
            $almacenes[] = $row;
        }
    
        return json_encode($almacenes);
    }
    
    

    
    
    public function marcarLoteEntregado($idLote)
{

        $sentencia1 = "UPDATE lotes
        SET estado = 'entregado', fechaLlegada = NOW()
        WHERE idLote = '$idLote';
        ";

        if ($this->conexion->query($sentencia1)) {
            // Actualiza el estado de los paquetes asociados al lote entregado
            $sentencia2 = "UPDATE paquetes p
                           JOIN forman f ON f.codigoPaquete = p.codigoPaquete
                           SET p.estado = 'en almacen destino'
                           WHERE f.idLote = '$idLote';";

            $this->conexion->query($sentencia2);

            // Agrega los paquetes entregados a la tabla almacenEsta
            $sentencia3 = "INSERT INTO almacenEsta (idAlmacen, codigoPaquete, fechaIngreso)
                           SELECT a.idAlmacen, f.codigoPaquete, NOW()
                           FROM forman f
                           JOIN lotes l ON l.idLote = f.idLote
                           JOIN almacenes a ON a.idAlmacen = l.idAlmacen
                           WHERE l.idLote = '$idLote';";

            $this->conexion->query($sentencia3);

            $sentencia4 = "UPDATE toman SET fechaFinTrayecto = NOW() WHERE idlote='$idLote';";

            if ($this->conexion->query($sentencia4)) {
                return true;
            } else {
                return false;
            }
        
    }

    return false;
}

    public function obtenerLotePorCamion($matriculaLote){
        
        // Preparar la consulta SQL con una sentencia preparada
        $instruccion = "SELECT l.*, a.departamento
                        FROM trasladan t
                        JOIN lotes l ON l.idLote=t.idLote 
                        JOIN almacenes a ON a.idAlmacen=l.idAlmacen
                        WHERE t.matricula = ? AND (l.estado IS NULL OR l.estado <> 'entregado')
                        ORDER BY a.departamento;";
        
        // Preparar la sentencia
        $stmt = $this->conexion->prepare($instruccion);
    
        if ($stmt) {
            // Vincular el parámetro y su tipo
            $stmt->bind_param("s", $matriculaLote);
            
            // Ejecutar la sentencia preparada
            if ($stmt->execute()) {
                // Obtener el resultado
                $resultado = $stmt->get_result();
                
                $lotes = array();
                while($fila = $resultado->fetch_assoc()) {
                    $lotes[] = $fila;
                }
    
                // Cerrar la sentencia preparada
                $stmt->close();
                
                return json_encode($lotes);
            } else {
                // Error al ejecutar la sentencia
                return false;
            }
        } else {
            // Error al preparar la sentencia
            return false;
        }
    }

    public function obtenerEntregados($matriculaLote){
        // Preparar la consulta SQL con una sentencia preparada
        $instruccion = "SELECT l.*, tom.fechaFinTrayecto , a.departamento
                FROM trasladan t
                JOIN lotes l ON l.idLote = t.idLote
                JOIN toman tom ON l.idLote = tom.idLote
                JOIN almacenes a ON a.idAlmacen=l.idAlmacen
                WHERE t.matricula = ? AND DATE(tom.fechaFinTrayecto) = CURDATE()
                ORDER BY tom.fechaFinTrayecto;";

        
        // Preparar la sentencia
        $stmt = $this->conexion->prepare($instruccion);
    
        if ($stmt) {
            // Vincular el parámetro y su tipo
            $stmt->bind_param("s", $matriculaLote);
            
            // Ejecutar la sentencia preparada
            if ($stmt->execute()) {
                // Obtener el resultado
                $resultado = $stmt->get_result();
                
                $lotes = array();
                while($fila = $resultado->fetch_assoc()) {
                    $lotes[] = $fila;
                }
    
                // Cerrar la sentencia preparada
                $stmt->close();
                
                return json_encode($lotes);
            } else {
                // Error al ejecutar la sentencia
                return false;
            }
        } else {
            // Error al preparar la sentencia
            return false;
        }
    }

    public function lotesDestinadosAlmacen($idAlmacen){
        $sentencia = "SELECT DISTINCT l.*, a.departamento as destino
                    FROM lotes l 
                    JOIN trasladan tr ON tr.idLote=l.idLote
                    JOIN toman t ON t.idLote=l.idLote
                    JOIN trayectos ty ON ty.idTrayecto=t.idTrayecto
                    JOIN conformado c ON c.idTrayecto = c.idTrayecto
                    JOIN almacenes a ON a.idAlmacen = c.idAlmacen
                    WHERE a.idAlmacen= '$idAlmacen' AND a.idAlmacen=l.idAlmacen AND l.estado <> 'entregado'; ";

        $resultado=$this->conexion->query($sentencia);           
        $lotes = array();
        while($fila = $resultado->fetch_assoc()) {
        $lotes[] = $fila;
    } 
    return json_encode($lotes);

    }
    
    public function verContenidoTransportista($matricula){
        $sentencia="SELECT p.* 
        FROM llevan l
        JOIN paquetes p ON p.codigoPaquete=l.codigoPaquete
        WHERE l.matricula = ? AND (p.estado IS NULL OR p.estado <> 'entregado')
        ORDER BY p.codigoPaquete;";

$stmt = $this->conexion->prepare($sentencia);
    
if ($stmt) {
    // Vincular el parámetro y su tipo
    $stmt->bind_param("s", $matricula);
    
    // Ejecutar la sentencia preparada
    if ($stmt->execute()) {
        // Obtener el resultado
        $resultado = $stmt->get_result();
        
        $paquetes = array();
        while($fila = $resultado->fetch_assoc()) {
            $paquetes[] = $fila;
        }

        // Cerrar la sentencia preparada
        $stmt->close();
        
        return json_encode($paquetes);
    } else {
        // Error al ejecutar la sentencia
        return false;
    }
} else {
    // Error al preparar la sentencia
    return false;
}
    }

    function obtenerPaquetesEntregados($matricula){
        $sentencia = "SELECT p.*
                    FROM paquetes p 
                    JOIN llevan l ON  l.codigoPaquete=p.codigoPaquete
                    JOIN ligeros li ON li.matricula=l.matricula
                    WHERE p.estado= 'entregado' AND li.matricula='$matricula';";
                    
        $resultado = $this->conexion->query($sentencia);
        $paquetes = array();
        while($fila = $resultado->fetch_assoc()) {
            $paquetes[] = $fila;
        }

        return json_encode($paquetes);

    }

    function marcarPaqueteEntregado($codigoPaquete){
        $sentencia = "UPDATE paquetes SET fechaEntregaPaquete = NOW(), horaEntregaPaquete = NOW(), estado='entregado'
              WHERE paquetes.codigoPaquete = '$codigoPaquete';";
        $resultado = $this->conexion->query($sentencia);
    

        return $resultado;
    }

    public function obtenerPaquete($codigoPaquete)
    {
        $instruccion = "SELECT * FROM paquetes WHERE codigoPaquete=$codigoPaquete;";
        $resultado = $this->conexion->query($instruccion);
    
        $paquetes = array();
        while ($fila = $resultado->fetch_assoc()) {
            $paquetes[] = array(
                "codigoPaquete" => $fila["codigoPaquete"],
                "pesoPaquete" => $fila["pesoPaquete"],
                "departamento" => $fila["departamento"],
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

    public function obtenerVehiculo($matricula){
    $sentencia = "SELECT vehiculos.*, pesados.* FROM vehiculos
                  LEFT JOIN pesados ON vehiculos.matricula = pesados.matricula
                  WHERE vehiculos.matricula = '$matricula' AND pesados.matricula ='$matricula';";

    $resultado = $this->conexion->query($sentencia);

    
    if ($resultado && $resultado->num_rows > 0) {
        
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] =$fila;
        }

        
        return json_encode($datos);
    } else {
        $sentencia2 = "SELECT vehiculos.*, ligeros.* FROM vehiculos
                  LEFT JOIN ligeros ON vehiculos.matricula = ligeros.matricula
                  WHERE vehiculos.matricula = '$matricula';";

    $resultado2 = $this->conexion->query($sentencia2);
    if ($resultado2 && $resultado2->num_rows > 0) {
        
        $datos2 = array();
        while ($fila = $resultado2->fetch_assoc()) {
            $datos2[] =$fila;
        }
        return json_encode($datos2);
        }else{
            return false;
        }

    }
}

}

?>