
<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["tipoUsuario"] !== "empAlmacen") {
    
    header("Location: ../index.php"); 
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Paquetes asignados al vehiculo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="stylesAsignados.css">
</head>
<body>
<header>
    <div class="logo">
      <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../../../paginas/almacen.php">Volver a Almacen</a></li> 
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>

    <h1>Paquetes asignados al vehiculo</h1>

    <div id="table-container">
    <table>
        <tr>
            <th>Codigo Paquete</th>
            <th>Matricula</th>
            <th>Accion</th>
        </tr>    
    <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador = new Controlador();

        if (isset($_GET['matriculaLigero'])) {
            $paqueteMatricula = $_GET['matriculaLigero'];
            $paquetes = $controlador->obtenerPaquetesPorLigeros($paqueteMatricula);

            if (empty($paquetes)) {
                echo "<p>No hay paquetes asignados a este vehiculo.</p>";
            } else {
                foreach ($paquetes as $paquete) {
                    echo "<tr>";
                    echo "<td>{$paquete['codigoPaquete']}</td>";
                    echo "<td>{$paquete['matricula']}</td>";
                    echo "<td><button onclick=\"eliminarPaqueteDeLigero({$paquete['codigoPaquete']})\">Eliminar del vehiculo</button></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<p>No se ha especificado un matricula.</p>";
        }
    ?>
    </table>
    </div>

    <div id="btnVolver">
        <a href="vistaCargarPaquetes.php"><button id="btnVolver">Volver</button></a>
    </div>


    
    <script>
        function eliminarPaqueteDeLigero(paquete) {
            if (confirm('¿Estás seguro de eliminar este paquete del vehiculo?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/controlador.php', 
                    data: { codigoPaqueteEliminar: paquete },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Paquete eliminado del vehiculo correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el paquete del vehiculo.');
                        }
                    },
                    error: function() {
                        alert('Hubo un error al comunicarse con el servidor.');
                    }
                });
            }
        }
    </script>
</body>
</html>