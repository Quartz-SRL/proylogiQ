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
    <title>Asignar Paquetes a Ligeros</title>
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

    <h1>Asignar Paquetes a Ligeros</h1>
    <div id="table-container">
    <table>
        <tr>
            <th>Matrícula del vehiculo</th>
            <th>Estado</th>
            <th>Carga Máxima (kg)</th>
            <th>Acción</th>
        </tr>
        <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador = new Controlador();
        $ligerosJSON = $controlador->obtenerVehiculosLigeros();
        $ligeros = json_decode($ligerosJSON, true); 

        foreach ($ligeros as $ligero) {
            echo "<tr id='fila-ligero-{$ligero['matricula']}'>";
            echo "<td>{$ligero['matricula']}</td>";
            echo "<td>{$ligero['estado']}</td>";
            echo "<td>{$ligero['pesoMax']}</td>";
            echo "<td><button onclick=\"mostrarPaquetes('{$ligero['matricula']}')\">Asignar Paquete</button>
            <a href='vistaPaquetesCargados.php?matriculaLigero={$ligero['matricula']}'><button>Ver Contenido</button></a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <div id="modal" style="display: none;">
        <div class="contenidoModal">
            
        
        <h2>Vehiculo con Matrícula: <span id="matricula_ligero"></span></h2>
        
        <h3>Paquetes Disponibles:</h3>
        <table id="tabla-paquetes">
            <tr>
                <th>Codigo Paquete</th>
                <th>Destino</th>
                <th>Acción</th>
            </tr>
            <?php
                $paquetesJSON = $controlador->obtenerPaquetes();
                $paquetes = json_decode($paquetesJSON, true);
                foreach ($paquetes as $paquete) {
                    if($paquete['matricula'] === null){
                    echo "<tr id='fila-paquete-{$paquete['codigo']}'>";
                    echo "<td>{$paquete['codigo']}</td>";
                    echo "<td>{$paquete['calle']}{$paquete['numero']}</td>";
                    echo "<td><button onclick=\"agregarPaqueteALigero('{$paquete['codigo']}')\">Agregar a vehiculo</button></td>";
                    echo "</tr>";
                    }
                }
            ?>
        </table>
        
        <button onclick="cerrarModal()">Cerrar</button>
        </div>
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
        let matriculaLigero;
        let codigo;
        function mostrarPaquetes(matricula) {
            matriculaLigero = matricula;
            document.getElementById('matricula_ligero').innerText = matriculaLigero;
            const modal = document.getElementById('modal');
            modal.style.display = 'block';
        }

        function agregarPaqueteALigero(id) {
            codigo = id;
            $.ajax({
                type: 'POST',
                url: 'http://localhost/apiAlmacen/controllers/controlador.php',
                data: { matriculaLigero: matriculaLigero, codigo: codigo },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const filaPaquete = document.getElementById(`fila-paquete-${codigo}`);
                        filaPaquete.remove();
                        alert('Paquete asignado correctamente.');
                    } else {
                        alert('Hubo un error al asignar el paquete.');
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
