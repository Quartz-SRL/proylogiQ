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
    <title>Asignar Lotes a Camiones</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
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
  
    <h1>Asignar Lotes a Camiones</h1>
    <div id="table-container">
    <table>
        <thead></thead>
        <tr>
            <th>Matrícula del Camión</th>
            <th>Tipo de Camión</th>
            <th>Estado</th>
            <th>Carga Máxima (kg)</th>
            <th>Capacidad Disponible (lotes)</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador = new Controlador();
        $camionesJSON = $controlador->obtenerVehiculosPesados();
        $camiones = json_decode($camionesJSON, true); 

        foreach ($camiones as $camion) {
            echo "<tr id='fila-camion-{$camion['matricula']}'>";
            echo "<td>{$camion['matricula']}</td>";
            echo "<td>{$camion['tipoCamion']}</td>";
            echo "<td>{$camion['estado']}</td>";
            echo "<td>{$camion['pesoMax']}</td>";
            echo "<td>{$camion['tamanoCaja']}</td>";
            echo "<td><button onclick=\"mostrarLotes('{$camion['matricula']}')\">Asignar Lote</button>
            <a href='vistaLotesAsignados.php?matricula={$camion['matricula']}'><button>Ver Contenido</button></a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
    <div id="modal" style="display: none;">
        <div class="contenidoModal">
        
        <h2>Camión con Matrícula: <span id="matricula_camion"></span></h2>
        
        <h3>Lotes Disponiblespara asignar:</h3>
        <button class="" onclick="cerrarModal()">Cerrar</button>
        <table id="tabla-lotes">
            <tr>
                <th>ID Lote</th>
                <th>Destino</th>
                <th>Acción</th>
            </tr>
            <?php
                $lotesJSON = $controlador->obtenerLotes();
                $lotes = json_decode($lotesJSON, true);
                foreach ($lotes as $lote) {
                    if($lote['matricula'] === null){
                    echo "<tr id='fila-lote-{$lote['idLote']}'>";
                    echo "<td>{$lote['idLote']}</td>";
                    echo "<td>{$lote['destino']}</td>";
                    echo "<td><button onclick=\"agregarLoteACamion('{$lote['idLote']}')\">Agregar a Camión</button></td>";
                    echo "</tr>";
                    }
                }
            ?>
        </table>
        <button class="" onclick="cerrarModal()">Cerrar</button>
        </div>
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
        let matriculaCamion;
        let idLote;
        function mostrarLotes(matricula) {
            matriculaCamion = matricula;
            document.getElementById('matricula_camion').innerText = matriculaCamion;
            const modal = document.getElementById('modal');
            modal.style.display = 'block';
        }

        function agregarLoteACamion(id) {
            idLote = id;
            $.ajax({
                type: 'POST',
                url: 'http://localhost/apiAlmacen/controllers/controlador.php',
                data: { matriculaCamion: matriculaCamion, idLote: idLote },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const filaLote = document.getElementById(`fila-lote-${idLote}`);
                        filaLote.remove();
                        alert('Lote asignado correctamente.');
                    } else {
                        alert('Hubo un error al asignar el lote.');
                    }
                    
                    
                },
                error: function() {
                    
                    alert('Hubo un error al comunicarse con el servidor.');
                    cerrarModal();
                }

            });
        
        }

        function cerrarModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
