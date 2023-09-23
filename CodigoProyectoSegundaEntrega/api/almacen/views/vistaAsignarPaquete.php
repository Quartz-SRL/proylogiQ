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
    <title>Asignar Paquetes a Lotes</title>
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
    <h1>Asignar Paquetes a Lotes</h1>


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
    include(__DIR__ . '/../controllers/controlador.php');
    $controlador = new Controlador();
    $paquetesJSON = $controlador->obtenerPaquetes();
    $paquetes = json_decode($paquetesJSON, true);

    $hayPaquetes = false; 
    
    foreach ($paquetes as $paquete) {
        if ($paquete['idLote'] === null) {
            $hayPaquetes = true;
            
           
            echo "<tr id='fila-paquete-{$paquete['codigo']}'>";
            echo "<td>{$paquete['codigo']}</td>";
            echo "<td>{$paquete['peso']}</td>";
            echo "<td>{$paquete['categoria']}</td>";
            echo "<td>{$paquete['fragil']}</td>";
            echo "<td>{$paquete['calle']} {$paquete['numero']}</td>";
            echo "<td>{$paquete['ciudad']}</td>";
            echo "<td>{$paquete['departamento']}</td>";
            echo "<td>{$paquete['emailDestino']}</td>";
            echo "<td>{$paquete['fechaIngreso']}</td>";
            echo "<td><button onclick=\"mostrarLotes('{$paquete['codigo']}')\">Agregar a Lote</button></td>";
            echo "</tr>";
            
        }
    }
    echo "</table>";
    if (!$hayPaquetes) {
        echo "No hay paquetes para mostrar.";
    }
    ?>

    <div id="modal" style="display: none;">
    <div class="contenidoModal">
    
        <h2>Paquete nro: <span id="codigo_paquete"></span></h2>
        <p>Generar nuevo lote con el destino del paquete</p>
        <button onclick="generarLote()">Generar Lote</button>
        <button onclick="cerrarModal()">Cancelar</button>
        <h3>Asignar a Lote con destino:</h3>
        <table id="tabla-lotes">
        <tr>
            <th>ID Lote</th>
            <th>Peso del Lote</th>
            <th>Acciones</th>
        </tr>
            <?php
            
            $lotesJSON = $controlador->obtenerLotes();
            $lotes = json_decode($lotesJSON, true);

            foreach ($lotes as $lote) {
                echo "<tr>";
                echo "<td>{$lote['idLote']}</td>";
                echo "<td>{$lote['destino']}</td>";
                echo "<td><button onclick=\"agregarPaqueteALote('{$lote['idLote']}')\">Asignar a Lote</button></td>";
                echo "</tr>";
            }
            ?>
        </table>
        
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
        let codigo;

        function mostrarLotes(id) {
            codigo = id;
            document.getElementById('codigo_paquete').innerText = codigo;
            const modal = document.getElementById('modal');
            modal.style.display = 'block';
        }

        function generarLote(destino) {
            $.ajax({
                type: 'POST',
                url: 'http://localhost/apiAlmacen/controllers/controlador.php',
                data: { codigo_paquete: codigo },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const filaPaquete = document.getElementById(`fila-paquete-${codigo}`);
                        filaPaquete.remove();
                        alert('Paquete asignado correctamente.');
                    } else {
                        alert('Hubo un error al asignar el paquete.');
                    }

                    cerrarModal();
                },
                error: function () {
                    alert('Hubo un error al comunicarse con el servidor.');
                    cerrarModal();
                }
            })
        }
        function agregarPaqueteALote(lote_id) {
            const idLote = lote_id;

            $.ajax({
                type: 'POST',
                url: 'http://localhost/apiAlmacen/controllers/controlador.php',
                data: { paquete_id: codigo, lote_id: idLote },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const filaPaquete = document.getElementById(`fila-paquete-${codigo}`);
                        filaPaquete.remove();
                        alert('Paquete asignado correctamente.');
                    } else {
                        alert('Hubo un error al asignar el paquete.');
                    }

                    cerrarModal();
                },
                error: function () {
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