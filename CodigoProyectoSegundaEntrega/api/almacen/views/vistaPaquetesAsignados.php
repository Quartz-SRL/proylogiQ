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
    <title>Paquetes Asignados al Lote</title>
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

    <h1>Paquetes Asignados al Lote</h1>
       
    <div id="table-container">
    <table>
                <tr>
                    <th>Codigo</th>
                    <th>Peso</th>
                    <th>Categoria</th>
                    <th>Fragil</th>
                    <th>Direccion</th>
                    <th>Ciudad</th>
                    <th>Departamento</th>
                    <th>Email</th>
                    <th>FechaIngreso</th>
                    <th>Accion</th>
                </tr>
    <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador = new Controlador();

        if (isset($_GET['lote_id'])) {
            $loteId = $_GET['lote_id'];
            $paquetes = $controlador->obtenerPaquetesPorLote($loteId);

            if (empty($paquetes)) {
                echo "<p>No hay paquetes asignados a este lote.</p>";
            } else {
                foreach ($paquetes as $paquete) {
                    
                    echo "<td>{$paquete['codigo']}</td>";
            echo "<td>{$paquete['peso']}</td>";
            echo "<td>{$paquete['categoria']}</td>";
            echo "<td>{$paquete['fragil']}</td>";
            echo "<td>{$paquete['calle']} {$paquete['numero']}</td>";
            echo "<td>{$paquete['ciudad']}</td>";
            echo "<td>{$paquete['departamento']}</td>";
            echo "<td>{$paquete['emailDestino']}</td>";
            echo "<td>{$paquete['fechaIngreso']}</td>";
                    echo "<td><button onclick=\"eliminarPaqueteDelLote({$paquete['codigo']})\">Eliminar del Lote</button></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<p>No se ha especificado un ID de lote.</p>";
        }
    ?>
    
    </table>
    </div>

    <div id="btnVolver">
        <a href="vistaAsignarPaquetes.php"><button id="btnVolver">Volver</button></a>
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
        function eliminarPaqueteDelLote(paqueteId) {
            if (confirm('¿Estás seguro de eliminar este paquete del lote?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/apiAlmacen/controllers/controlador.php', 
                    data: { paquete_id_eliminar: paqueteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Paquete eliminado del lote correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el paquete del lote.');
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