<?php
class seguimientoModel
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "quartz");

        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
    }

    
    public function estadoPaquete($codigoPaquete){
        $sentencia2 = "SELECT DISTINCT p.codigoPaquete, p.estado, f.idLote, t.matricula, co.tiempoAlmCentral
        FROM paquetes p
        JOIN forman f ON f.codigoPaquete = p.codigoPaquete
        JOIN lotes l ON l.idLote = f.idLote
        JOIN trasladan t ON t.idLote = l.idLote
        JOIN toman tm ON tm.idLote = l.idLote
        JOIN trayectos ty ON ty.idTrayecto = tm.idTrayecto
        JOIN conformado co ON co.idTrayecto = ty.idTrayecto
        JOIN almacenes a ON a.idAlmacen = co.idAlmacen
        WHERE p.codigoPaquete = '$codigoPaquete' AND a.idAlmacen = l.idAlmacen;
        ";
    
        $result2 = $this->conexion->query($sentencia2);
    
        if ($result2) {
            $estado2 = array();
            while ($fila = $result2->fetch_assoc()) {
                $estado2[] = $fila;
            }
    
            if (!empty($estado2)) {
                return json_encode($estado2);
            }
        }
    
        // Si no hay resultados en la segunda consulta, realizamos la primera consulta más general.
        $sentencia1 = "SELECT p.estado FROM paquetes p WHERE p.codigoPaquete = '$codigoPaquete';";
        
        $result1 = $this->conexion->query($sentencia1);
    
        if ($result1) {
            $estado1 = array();
            while ($fila = $result1->fetch_assoc()) {
                $estado1[] = array('estado' => $fila["estado"]);
            }
        
            if (!empty($estado1)) {
                return json_encode($estado1);
            }
        }
    
        // Si el paquete no existe o hay un error en la consulta, devolvemos el mensaje.
        return json_encode(array("mensaje" => "No existe el paquete"));
    }
    
        }
    
       
    
    
    



?>