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
    <title>Lotes Asignados al camion</title>
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

    <h1>Lotes Asignados al camion</h1>
    <div id=table-container></div>
    <table>
        <tr>
            <th>Id Lote</th>
            <th>Matricula</th>
            <th>Accion</th>
        </tr>    
    <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador = new Controlador();

        if (isset($_GET['matricula'])) {
            $loteMatricula = $_GET['matricula'];
            $lotes = $controlador->obtenerLotePorCamion($loteMatricula);

            if (empty($lotes)) {
                echo "<p> No hay lotes asignados a este camión.</p>";
            } else {
                foreach ($lotes as $lote) {
                    echo "<tr>";
                    echo "<td>{$lote['idLote']}</td>";
                    echo "<td>{$lote['matricula']}</td>";
                    echo "<td><button onclick=\"eliminarLoteDeCamion({$lote['idLote']})\">Eliminar del camión</button></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<p>No se ha especificado un ID del camión.</p>";
        }
    ?>
    </table>
    </div>
    
    <div id="btnVolver">
        <a href="vistaAsignarLotes.php"><button id="btnVolver">Volver</button></a>
    </div>

    <footer class="footer">

    <div class="footer-container">
    
    <div class="logo">
          <img src="../../../img/logo.png">
        <p>2023 © - todos los derechos reservados</p>
    </div>
    
    </div>        
  </footer>

    <script>
        function eliminarLoteDeCamion(lote) {
            if (confirm('¿Estás seguro de eliminar este lote del camion?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/apiAlmacen/controllers/controlador.php', 
                    data: { idLoteEliminar: lote },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Lote eliminado del camión correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el lote del camión.');
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