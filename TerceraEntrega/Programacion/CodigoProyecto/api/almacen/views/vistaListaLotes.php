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
    <title>Lista de Lotes</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    <h1>Lista de Lotes</h1>
    <div id="table-container">
    <table>
        
        <tr>
            <th>ID Lote</th>
            <th>Destino del Lote</th>
            <th>Peso Lote</th>
            <th>Acciones</th>
        </tr>
        <?php
            include (__DIR__ . '/../controllers/controlador.php');
            $controlador = new Controlador();
            $lotesJSON = $controlador->obtenerLotes();
            $lotes=json_decode($lotesJSON,true);
            foreach ($lotes as $lote) {
                echo "<tr>";
                echo "<td>{$lote['idLote']}</td>";
                echo "<td>{$lote['destino']}</td>";
                echo "<td>{$lote['pesoLote']}</td>";
                echo "<td><a href='vistaPaquetesAsignados.php?lote_id={$lote['idLote']}'><button>Ver Paquetes</button></a>
                        <button onclick=\"eliminarLote('{$lote['idLote']}')\">Eliminar Lote</button></td>";
                echo "</tr>";
            }
        ?>
    
    </table>
    </div>
        </div>
    
        <script>
             function eliminarLote(loteId) {
            if (confirm('¿Estás seguro de eliminar este lote?')) {
                console.log(loteId);
                $.ajax({
                    type: 'POST',
                    url: '../controllers/controlador.php', 
                    data: { lote_id_eliminar: loteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Lote eliminado del lote correctamente.');
                            location.reload();
                        } else {
                            alert('No pede eliminar lotes con paquetes asignados.');
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